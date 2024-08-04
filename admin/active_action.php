<?php 
    require '../includes/conn.php';
    include 'active.php';

    $active = $_POST['active'];

    $item = new active();
    $con = $item->connect();
    $item->update($con,$active);
?>