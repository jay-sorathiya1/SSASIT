<?php
session_start();

if (!(isset($_SESSION['User_Logged-In']) && $_SESSION['User_Logged-In'] == true)) {
    header('Location: Authentication');
    exit();
}
?>