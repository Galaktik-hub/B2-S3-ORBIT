<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['pseudo'])) {
        header("Location: ../index.html?message=You must be logged in to access this page&type=error");
        exit();
    }
}
?>
