<?php
// functions.php — reusable functions for sessions and redirects

session_start(); // ensures session variables can be used

function checkLogin() {
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit();
    }
}

function isTherapist() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'therapist';
}

function isUser() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
}

?>
