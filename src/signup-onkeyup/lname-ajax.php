<?php
header('Content-Type: text/plain');

if (isset($_POST['lastName'])) {
    $lastName = $_POST['lastName'];
    if (preg_match("/^[a-zA-Z]/", $lastName)) {
        echo "Valid!";
    } else {
        echo "Last Name must start with a letter.";
    }
} else {
    echo "Last Name is required.";
}

