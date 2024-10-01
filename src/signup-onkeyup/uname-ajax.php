<?php
header('Content-Type: text/plain'); // Set content type to plain text

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    // Validate the username: must start with a letter and be at least 8 characters long
    if (preg_match("/^[a-zA-Z][a-zA-Z0-9]{7,}$/", $username)) {
        echo "Valid!";
    } else {
        echo "Username must start with a letter and contain at least 8 characters.";
    }
} else {
    echo "Username is required.";
}

