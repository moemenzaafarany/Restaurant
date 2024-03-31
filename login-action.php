<?php 
    require './includes/conn.php';
    include 'log-in.php';

    $email = $_POST['email'];
    $pass = $_POST['password'];

    $login = new login();
    $con = $login->connect();
    $login->login($con,$email,$pass);
?>