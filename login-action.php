<?php 
    require './includes/conn.php';
    include 'log-in.php';

    $name = $_POST['DeviceName'];

    $login = new login();
    $con = $login->connect();
    $login->login($con,$name);
?>