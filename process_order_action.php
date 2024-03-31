<?php 
    require './includes/conn.php';
    include 'process_order.php';

    $user_id = $_POST['user_id'];
    $item_id = $_POST['item_id'];
    $qty = $_POST['qty'];

    $order = new order();
    $con = $order->connect();
    $order->insert($con,$user_id,$item_id,$qty);
?>