<?php
session_start();

// Include the Database class
require_once '../../db/Database.php';

// Create an instance of the Database class
$db = new Database();

// Initialize error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Attempt to connect to the database management system (DBMS)
    if ($db->connectToDBMS()) {
        // Attempt to connect to the specific database
        if ($db->connectToDB('kidsGames')) {
            // Prepare SQL query to fetch user data for authentication
            $sql = "SELECT p.id, a.registrationOrder, p.userName, a.passCode 
                    FROM player p
                    JOIN authenticator a ON p.registrationOrder = a.registrationOrder
                    WHERE p.userName=?";
            
            // Prepare and execute the statement
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            
            // Get the result
            $result = $stmt->get_result();

            // Check if a row is returned
            if ($result->num_rows == 1) {
                // Fetch the row
                $row = $result->fetch_assoc();
                
                // Verify the password
                if (password_verify($password, $row['passCode'])) {
                    // Authentication successful, set session variables
                    $_SESSION['player_id'] = $row['id'];
                    $_SESSION['registrationOrder'] = $row['registrationOrder'];
                    $_SESSION['username'] = $row['userName'];
                    $_SESSION['last_activity'] = time(); // Set last activity time

                    
                    // Redirect to the game page or any other desired page
                    header("Location: http://localhost/WebServerProject_Winter2024/public/form/UserMenu.php");
                    exit();
                } else {
                    // Authentication failed, set error message
                    $error_message = "Invalid username or password.";
                }
            } else {
                // Authentication failed, set error message
                $error_message = "Invalid username or password.";
            }
        } else {
            $error_message = "Error connecting to database: " . $db->getLastErrorMessage();
        }
    } else {
        $error_message = "Error connecting to database management system.";
    }
}

// Check for timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 900)) { // 900 seconds = 15 minutes
    session_unset();
    session_destroy();
    header("Location: http://localhost/WebServerProject_Winter2024/public/form/signin-form.php");
    exit();
}

// Close database connection
$db->__destruct();

// Redirect to signin form with error message, if any
header("Location: http://localhost/WebServerProject_Winter2024/public/form/signin-form.php?error_message=" . urlencode($error_message));
exit();
?>