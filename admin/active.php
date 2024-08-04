<?php 

include '../includes/db.php';

class active extends database{
    public function update(){
        $active = $_POST['active'];

        $id = $_GET['item_id'];

        $sql = "UPDATE items
        SET active = $active
        WHERE item_id = $id ";

        $conn = mysqli_connect($this->servername,$this->username, $this->password,$this->db_name);

        if (mysqli_query($conn,$sql)){
        header("location:items.php");
        $success_msg[] = "Added Successfully!";
        }
        else{
        // echo"error: " . $sql . "<br>" . mysqli_error($conn);
        $error_msg[] = "Error";
        }
    }
}
?>