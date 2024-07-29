<?php 

include '../includes/db.php';

class admin extends database {
    public function insert($file, $name, $price, $category) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../imgs/';
            $uploadFile = $uploadDir . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $sql = "INSERT INTO items (img, item_name, price, category) VALUES (?, ?, ?, ?)";
                $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db_name);
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $uploadFile, $name, $price, $category);
                $stmt->execute();

                $stmt->close();
                $conn->close();
                header('location:items.php');
            } else {
                throw new Exception("File upload failed.");
            }
        } else {
            throw new Exception("File upload error: " . $file['error']);
        }
    }
}


?>