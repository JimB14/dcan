<?php
@session_start();

if (!isset($_SESSION['loggedIn'])){
    
    $title = 'Login';
    header('Location: index.php');
    exit();
}