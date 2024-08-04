<?php
session_start(); 
include 'includes/db.php';

class login extends database{
    public function login(){
        // $name = $_POST['DeviceName'];
        // $query = "insert into users (`DeviceName`) values ('$name')";
        // $conn = mysqli_connect($this->servername,$this->username, $this->password,$this->db_name);
        // mysqli_query($conn,$query);

        if (isset($_POST['DeviceName'])) {
            $name = trim($_POST['DeviceName']);
            if (empty($name)) {
                header("Location: login.php?error=Device Name is required");
            } else {
                $conn = mysqli_connect($this->servername,$this->username, $this->password,$this->db_name);
                $sql = $conn->prepare("SELECT * FROM users WHERE DeviceName=?");
                $sql->bind_param("s", $name);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row['DeviceName'] === $name) {
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['DeviceName'] = $row['DeviceName'];
                        // header("Location: Home.php");

                        $selectedOption = isset($_POST['option']) ? $_POST['option'] : '';

                        $links = array(
                            'Breakfast' => 'http://localhost/Restaurant/breakfast.php',
                            'Lanch' => 'http://localhost/Restaurant/lanch.php'
                        );
                        header("Location: " . $links[$selectedOption]);


                    } else {
                        header("Location: login.php?error=Incorect Username or password");
                    }
                }else{
                    $insertQuery = "INSERT INTO users (DeviceName) VALUES (?)";
                    $insertStmt = $conn->prepare($insertQuery);
                    $insertStmt->bind_param('s', $name);
                    $insertStmt->execute();
			// header("Location:Home.php");
                }
            }
        } else {
            header("Location:login.php");
        }
    }
}
?>
