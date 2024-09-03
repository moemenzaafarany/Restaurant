<?php 
    require './includes/conn.php';
    include 'removeToCart.php';

    $item_id = $_GET['item_id'];

    $order = new removeToCart();
    $con = $order->connect();
    $order->remove($con,$item_id);
?>