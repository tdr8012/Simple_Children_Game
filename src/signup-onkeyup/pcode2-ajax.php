<?php
header('Content-Type: text/plain');

if (isset($_POST['password'], $_POST['confirmPassword'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password === $confirmPassword) {
        echo "Valid!";
    } else {
        echo "Passwords do not match.";
    }
} else {
    echo "Both password fields are required.";
}
