<?php
include "../includes/conn.php";
session_start();


$sql = "Select * from items";

$result = mysqli_query($conn, $sql);
?>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dakahlia kitchen</title>
    <style>
      body{
        background-color: #eeffed;
      }
        .hide{
            display: none !important;
        }

        .food{
            width: 80px;
        }
    </style>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <img class="" src="./imgs/download.png" alt="">
    <a class="navbar-brand" href="#">Items</a>

  </div>
</nav>

<div class=" mb-5 mt-3">
    <div class="container">
        <!-- <h1>Booking List</h1> -->
        <!-- <hr /> -->
        <!-- <input class="form-control mt-5" list="datalistOptions" id="search" placeholder="Search by date..."> -->

    <div id="display">



<table class="table mt-3 table-columns " >
  <th>image</th>
  <th>Item Name</th>
  <th>Price</th>
  <th>Category</th>
  <th>Status</th>

 <?php

    while($row = mysqli_fetch_array($result)) {
    	echo "<tr>";
        $imageData = $row['img'];
    	?>
        <td><img src="../imgs/<?php echo($imageData); ?>" alt="" class="food"></td>
        <td><?php echo $row[2];?></td>
        <td><?php echo $row[3];?> L.E</td>
        <td><?php echo $row[4];?></td>

        <td>
<form action="<?php echo 'active_action.php?item_id=' . $row[0] ?>" method="POST">
    <select name="active">
        <option value="1" <?php echo $row['active'] == 1 ? 'selected' : ''; ?>>Active</option>
        <option value="0" <?php echo $row['active'] == 0 ? 'selected' : ''; ?>>Inactive</option>
    </select>
    <input class="btn btn-info" type="submit" value="Update">
</form>
    </div>
  </div>
</div>
            <?php
        echo "</tr>";
    }
?>
</div>
</div>
    
</div>
</div>