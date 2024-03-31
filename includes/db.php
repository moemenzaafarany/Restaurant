<?php

// namespace db;

class database{
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $db_name="booking";

    public function connect(){
        // Create connection
        $conn = mysqli_connect($this->servername,$this->username, $this->password,$this->db_name);
        // Check connection
        // if (!$conn) {
        //     die("Connection failed: " . mysqli_connect_error());
        // }
        // echo "Connected successfully";
        // return $conn;
    }
}
?>