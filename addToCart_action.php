<?php 
    require './includes/conn.php';
    include 'addToCart.php';

    $user_id = $_POST['user_id'];
    $item_id = $_POST['item_id'];
    $qty = $_POST['qty'];

    $order = new addToCart();
    $con = $order->connect();
    $order->insert($con,$user_id,$item_id,$qty);
?>