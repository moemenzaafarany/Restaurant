<?php 

include 'includes/db.php';
session_start();

class removeToCart extends database{
    public function remove(){
        
            $item_id  =  ($_GET['item_id']);
            $user_id  =  ($_SESSION['user_id']);
    
            $sql = "DELETE FROM cart WHERE item_id = $item_id AND user_id= $user_id";
    
            $conn = mysqli_connect($this->servername,$this->username, $this->password,$this->db_name);
    
            if (mysqli_query($conn,$sql)){
            header("location: " . $_SERVER['HTTP_REFERER']);
            $success_msg[] = "Removed Successfully!";
            }
            else{
            // echo"error: " . $sql . "<br>" . mysqli_error($conn);
            $error_msg[] = "Error";
            }
    }
}
?>