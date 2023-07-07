<?php 
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Unset all session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    header("Location: ../index.php");
    //  echo 'logged out';
} else {
    // The user is not logged in, redirect them to the login page
    header("Location: ../index.php");
    exit;
}
?>