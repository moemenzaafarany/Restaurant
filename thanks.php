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
    
    <style>
        body {
    background: rgb(190, 171, 196)
}


.container {
width: 100%;
margin: 30px auto;
display: flex;
justify-content: space-between;
align-items: center;
}

input[type=range] {
width: 100%;
}

a {
flex: 0 0 auto;
width: 40px;
height: 40px;
border-radius: 100%;
background: white;
font-size: 24px;
border: 1px solid lightgrey;
cursor: pointer;
-webkit-appearance: none;
margin: 0 10px;
text-decoration: none;
padding-left: 12px;
color: green;
}


    </style>
    </head>
  <body>
  <div class="liveAlertPlaceholder"></div>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <!-- <a class="navbar-brand" href="#">Navbar</a> -->
    <img class="navbar-brand" src="./imgs/download.png" alt="">
        <div>
           <h4> Welcome, <?php echo $_SESSION['DeviceName']; ?></h4>
        </div>
  </div>
</nav>

    

<div class="container py-5">
  <div class="row mt-3">
        <h4>Thanks Your Order In Process</h4>
</div>
  </body>
</html>
