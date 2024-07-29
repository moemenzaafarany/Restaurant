<?php 
    require '../includes/conn.php';
    include 'insert_item_list.php';

    $finish = $_POST['finish'];

    $item = new item_list();
    $con = $item->connect();
    $item->update($con,$finish);
?>