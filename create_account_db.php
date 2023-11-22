<?php
    session_start();
    require_once('db_connect.php'); 
    $_SESSION['success'] = 0;
    $_SESSION['username'] ='';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()) {
                header("Location: home.php");
                $_SESSION['success'] = 1;
                $_SESSION['username'] = $username;
                exit();
            } else {
                header("Location: create_account.php?fail=1");
                exit();
            }
            
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
        if (isset($conn) && $conn) {
            $conn->close();
        }
    }
?>