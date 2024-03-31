<?php 

include 'includes/db.php';
// include 'includes/alert.php';

class item_list extends database{
    public function update(){
        $finish = ($_POST['finish']);

        $id = $_GET['order_id'];

        $sql = "UPDATE order_list
        SET finish = 'yes'
        WHERE order_id = $id ";

        $conn = mysqli_connect($this->servername,$this->username, $this->password,$this->db_name);

        if (mysqli_query($conn,$sql)){
        header("location:item_list.php");
        $success_msg[] = "Added Successfully!";
        }
        else{
        // echo"error: " . $sql . "<br>" . mysqli_error($conn);
        $error_msg[] = "Error";
        }
    }
}
?>