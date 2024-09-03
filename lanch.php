<?php 
    include 'includes/conn.php';
    session_start();
    if(isset ($_SESSION['user_id'])){
        
    }else{
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dakahlia kitchen</title>
         <!-- basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- mobile metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <!-- owl stylesheets --> 
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></script> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/alert.css">
    <link rel="stylesheet" href="css/home.css">
    
    
    </head>
  <body>
  <div class="liveAlertPlaceholder"></div>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <!-- <a class="navbar-brand" href="#">Navbar</a> -->
    <img class="navbar-brand" src="./imgs/download.png" alt="">
  </div>
</nav>

    

<div class="container py-5">
  <div class="row mt-3">
    <?php

    include "./includes/conn.php";

    $query = "SELECT * FROM items where category='Lunch' And active='1'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            ?>
    <div class="col-lg-5 col-12 gap-3 p-2">
      <form action="addToCart_action.php" method="post">
        
        <!-- <input type="submit" value="Order" class="btn btn-primary liveAlertBtn" style="width: 70px;"> -->
        <div class="card">
          <?php
                $imageData = $row['img'];
                ?>
                <button class="card-button" type="submit">
              <img src="imgs/<?php echo($imageData); ?>" alt="" class="h-50 w-100">
            </button>
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['item_name'] ?></h5>
                <p class="card-text"><?php echo $row['price'] ?>L.E</p>
                <p class="card-text"><div class="container">
            <a class="minus">-</a>
            <input class="range" type="range" name="qty" min="1" step="1" value="1">
            <a class="plus">+</a>
            <output for="range" class="output">1</output>
            </div></p>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
            <input type="hidden" name="item_id" value="<?php echo $row['item_id'] ?>">
        </form>
    </div>
    </div>
</div>
<?php }
}?>

</div>

    <div class="col-lg-4">
      <div class="sidebar">
        <?php
        $user_id = $_SESSION['user_id'];
        $query = "SELECT *
                  FROM cart
                  INNER JOIN items ON cart.item_id = items.item_id
                  WHERE cart.user_id = '$user_id'";
        
        $query_run = mysqli_query($conn, $query);
        if (mysqli_num_rows($query_run) > 0) {

          echo '<h1>Your Cart</h1>';

          echo '<form action="process_order_action.php" method="post">';
          echo '<table class="table">';
          echo '<thead>';
          echo '<tr>';
          echo '<th>Product</th>';
          echo '<th>Quantity</th>';
          echo '<th>Price</th>';
          echo '<th>Total</th>';
          echo '</tr>';
          echo '</thead>';
          echo '<tbody>';

          while ($row = mysqli_fetch_assoc($query_run)) {
            // Assuming `item_name`, `price`, and `qty` columns exist
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['item_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['qty']) . '</td>';
            echo '<td>' . htmlspecialchars($row['price']) . '</td>';
            echo '<td>' . htmlspecialchars($row['price'] * $row['qty']) . '</td>';
            echo '<td><a href="removeToCart_action.php?item_id=' . urlencode($row['item_id']) . '" name="qty" value=""><i class="fa-solid fa-x"></i></a></td>';
            
            echo '</tr>';

            echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($_SESSION['user_id']) . '">';
            echo '<input type="hidden" name="item_id" value="' . htmlspecialchars($row['item_id']) . '">';
            echo '<input type="hidden" name="qty" value="' . htmlspecialchars($row['qty']) . '">';
          }

          echo '</tbody>';
          echo '</table>';
          echo '<button class="checkout-btn" type="submit">Proceed to Checkout</button>';
          echo '</form>';
        } else {
          echo '<p>Your cart is empty.</p>';
        }
        ?>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  $(".minus").click(function(event) {
    var output = $(this).siblings(".output");
    var range = $(this).siblings(".range");
    var currentValue = parseInt(range.val(), 10);
    if (currentValue > 1) {
      range.val(currentValue - 1).change();
      output.text(range.val());
    }
  });

  $(".plus").click(function(event) {
    var output = $(this).siblings(".output");
    var range = $(this).siblings(".range");
    var currentValue = parseInt(range.val(), 10);
    range.val(currentValue + 1).change();
    output.text(range.val());
  });

  $(".range").on('input change', function(event) {
    $(this).siblings(".output").text($(event.currentTarget).val());
  });
});
</script>
  </body>
    <script src="js/alert.js"></script>
</html>
