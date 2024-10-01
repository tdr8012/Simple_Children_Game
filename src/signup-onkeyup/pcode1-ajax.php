<?php
header('Content-Type: text/plain');

if (isset($_POST['password'])) {
    $password = $_POST['password'];
    if (!empty($password) && strlen($password) >= 8) {
        echo "Valid!";
    } else {
        echo "Password must contain at least 8 characters.";
    }
} else {
    echo "Password is required.";
}

