<?php
//header('Content-Type: text/plain'); // Ensure the content type is set to plain text

if (isset($_POST['firstName'])) {
    $firstName = $_POST['firstName'];
    if (preg_match("/^[a-zA-Z]/", $firstName)) {
        echo "Valid!"; // Return plain text response
    } else {
        echo "First Name must start with a letter."; // Return error message as plain text
    }
} else {
    echo "First Name is required."; // Return error message as plain text
}

