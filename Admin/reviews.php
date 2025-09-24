<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['admin_id'])) {
    // Not logged in, redirect to login page
    header("Location: index.php");
    exit();
}

include 'navigation.php';
?>

<link rel="stylesheet" href="style.css" />