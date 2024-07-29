<?php 
    require '../includes/conn.php';
    include 'Register-ition.php';
    
    if (isset($_FILES['img']) && isset($_POST['item_name']) && isset($_POST['price']) && isset($_POST['category'])) {
        // Retrieve form data
        $file = $_FILES['img'];
        $name = $_POST['item_name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
    
            // Create admin instance and insert data
            $admin = new admin();
            $admin->insert($file, $name, $price, $category);
    } else {
        // Handle error if form data is missing
        echo "Form data is missing.";
    }
?>