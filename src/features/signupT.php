<?php
session_start();

// Include the Database class
require_once '../../db/Database.php';
include '../../db/Insert.php';

// Create an instance of the Database class
$db = new Database();

// Initialize error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['confirmPassword'];

    // Validate input
    if (empty($firstName) || empty($lastName) || empty($username) || empty($password) || empty($repeatPassword)) {
        $error_message = "All fields are required.";
    } elseif (!preg_match("/^[a-zA-Z]/", $firstName) || !preg_match("/^[a-zA-Z]/", $lastName) || !preg_match("/^[a-zA-Z]/", $username)) {
        $error_message = "First Name, Last Name, and Username must begin with a letter of the alphabet.";
    } elseif (strlen($username) < 8 || strlen($password) < 8) {
        $error_message = "Username and Password must contain at least 8 characters.";
    } elseif ($password !== $repeatPassword) {
        $error_message = "Passwords do not match.";
    } else {
        // Attempt to connect to the database management system (DBMS)
        if ($db->connectToDBMS()) {
            // Attempt to connect to the specific database
            if ($db->connectToDB('kidsGames')) {
                // Check if username already exists
                $checkQuery = "SELECT COUNT(*) AS count FROM player WHERE userName = '$username'";
                $result = $db->executeOneQuery($checkQuery);

                if ($result && is_array($result)) {
                    $count = $result['count'];
                } else {
                    $count = 0;
                }

                if ($count > 0) {
                    $error_message = "Username already exists. Please choose a different username.";
                } else {
                    // Escape user input to prevent SQL injection
                    $firstName = $db->getConnection()->real_escape_string($firstName);
                    $lastName = $db->getConnection()->real_escape_string($lastName);
                    $username = $db->getConnection()->real_escape_string($username);
                    // Hash the password for security
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Insert user data into the player table
                    $insertQuery = "INSERT INTO player (fName, lName, userName, registrationTime) VALUES ('$firstName', '$lastName', '$username', NOW())";

                    // Execute the query
                    try {
                        if ($db->executeOneQuery($insertQuery)) {
                            // Insert password into the authenticator table
                            $registrationOrder = $db->getLastInsertedRegistrationOrder();
                            $insertAuthenticatorQuery = "INSERT INTO authenticator (passCode, registrationOrder) VALUES ('$hashedPassword', $registrationOrder)";
                            if ($db->executeOneQuery($insertAuthenticatorQuery)) {
                                // Registration successful
                                $_SESSION['success_message'] = "Registration successful. You can now login.";
                                header("Location: http://localhost/WebServerProject_Winter2024/public/form/signin-form.php");
                                exit();
                            } else {
                                $error_message = "Error inserting user credentials.";
                            }
                        } else {
                            $error_message = "Error inserting user.";
                        }
                    } catch (mysqli_sql_exception $e) {
                        // Handle duplicate entry exception
                        $error_message = "Username already exists. Please choose a different username.";
                    }
                }
            } else {
                $error_message = "Error connecting to database: " . $db->getLastErrorMessage();
            }
        } else {
            $error_message = "Error connecting to database management system.";
        }
    }
}

// Close database connection
$db->__destruct();

// Redirect to signup form with error message, if any
header("Location: http://localhost/WebServerProject_Winter2024/public/form/signup-form.php?error_message=" . urlencode($error_message));
exit();
?>
