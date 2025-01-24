<?php
// Start the session to access session variables
session_start();

// Include the database connection file
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

echo "Welcome, " . $_SESSION['user_name'] . "!";

header("Location:../index.html"); // Redirect to the index page
?>