<?php
include "./includes/conn.php";
session_start();


$sql = "SELECT order_list.order_id, users.name, users.email, items.item_name, order_list.qty, items.price, order_list.date
FROM order_list
INNER JOIN users ON order_list.user_id = users.user_id
INNER JOIN items ON order_list.item_id = items.item_id 
WHERE DATE(order_list.date) = DATE(NOW())
GROUP BY order_list.order_id
ORDER BY order_list.order_id DESC;";

$result = mysqli_query($conn, $sql);
?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
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
    </style>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <img class="" src="./imgs/download.png" alt="">
    <a class="navbar-brand" href="#">Orders List</a>

  </div>
</nav>

<div class=" mb-5 mt-3">
    <div class="container">
        <!-- <h1>Booking List</h1> -->
        <!-- <hr /> -->
        <button onclick="location.href='invoice.php'" class="btn btn-success" ><i class="fa-solid fa-file-invoice"></i> Daily Invoice</button>
        <!-- <input class="form-control mt-5" list="datalistOptions" id="search" placeholder="Search by date..."> -->

    <div id="display">



<table class="table mt-3 table-columns " >
  <th>Username</th>
  <th>Email</th>
  <th>Item Name</th>
  <th>Quantity</th>
  <th>Price</th>
  <th>Order Date</th>
  <th>Finish ?</th>

 <?php

    while($row = mysqli_fetch_array($result)) {
    	echo "<tr>";
    	?>
        <td><?php echo $row[1];?></td>
        <td><?php echo $row[2];?></td>
        <td><?php echo $row[3];?></td>
        <td><?php echo $row[4];?></td>
        <td><?php echo $row[5];?> L.E</td>
        <td><?php echo $row[6];?></td>

        <td>
<form action="item_list_action.php" method="post">
    <a type="submit" class="btn btn-warning finish-button" href="item_list_action.php?order_id=<?php echo $row[0];?>">yes</a>
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
    <!-- <label for="exampleDataList" class="form-label">Search Data</label> -->
    <script>
    function autoRefresh() {
        window.location = window.location.href;
    }
    setInterval('autoRefresh()', 5000);

//     const button = document.querySelector('.btn')
//     button.addEventListener('click', () => {
//   // Disable the button
//   button.parentNode.removeChild(button);

// })


// if (localStorage.getItem("buttonEdited") === "true") {
//   hideBox();
// }


// window.onload = function() {
//   hideBox();
// };


// function hideBox() {
//   const button = document.querySelector(".btn");
//   button.classList.add("hide");
//   localStorage.setItem("buttonEdited", "true");
// }


// document.querySelector(".btn").addEventListener("click", function() {
//     const button = document.querySelector(".btn");
//     hideBox();
// });


// Get all buttons
const buttons = document.getElementsByClassName("finish-button");

// Hide button function
// function hidebtn(index) {
//   return function () {
//     this.classList.add("hide");
//     localStorage.setItem("buttonEdited", "true");
//   };
// }

// // Initialize hide function
// function initializeHide(index) {
//   buttons[index].classList.add("hide");
//   localStorage.setItem("buttonEdited", "true");
// }

// // Check if a button has been edited before
// if (localStorage.getItem("buttonEdited") === "true") {
//   for (let i = 0; i < buttons.length; i++) {
//     initializeHide(i);
//   }
// }

// // Add event listener for hiding buttons
// window.onload = function () {
//   for (let i = 0; i < buttons.length; i++) {
//     // Call hidebtn with the correct this context using bind()
//     buttons[i].addEventListener("click", hidebtn(i).bind(buttons[i]));
//   }
// };

// Get all buttons
// const buttons = document.getElementsByClassName("btn");
const buttonsArray = Array.from(buttons);

// Button states in local storage
const buttonStatesKey = "buttons";

// Initialize button states
let buttonStates = JSON.parse(localStorage.getItem(buttonStatesKey)) || [];

if (buttonStates.length < buttons.length) {
  // Fill the missing states with "hidden": false
  buttonStates = buttonsArray.map((_, i) => ({
    id: buttons[i].id,
    hidden: buttonStates[i]?.hidden || false,
  }));
}

// Set up the button states
for (let i = 0; i < buttonStates.length; i++) {
  if (buttonStates[i].hidden) {
    buttonsArray[i].classList.add("hide");
  }
  buttonsArray[i].dataset.index = i;
  buttonsArray[i].addEventListener("click", toggleButton);
}

// Save button states in local storage
function saveButtonStates() {
  localStorage.setItem(buttonStatesKey, JSON.stringify(buttonStates));
}

// Toggle button state and update the local storage
function toggleButton(event) {
  const button = event.currentTarget;
  const index = button.dataset.index;
  button.classList.toggle("hide");
  buttonStates[index].hidden = button.classList.contains("hide");
  saveButtonStates();
}

// Add event listener for saving button states
window.addEventListener("beforeunload", saveButtonStates);
    </script>
</div>