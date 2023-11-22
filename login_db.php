<?php
    session_start();
    require_once('db_connect.php');
    $_SESSION['success'] = 0;
    $_SESSION["username"] = '';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $username = $_GET['username'];
        $password = $_GET['password'];

        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Fetch the user data
            $userData = $result->fetch_assoc();
            if($userData['username'] === $username && $userData['password'] === $password){
                // Set session variables
                $_SESSION["success"] = 1;
                $_SESSION["username"] = $userData['username'];
            }
            // Redirect to home.php
            header("Location: home.php");
            exit();
            
        } else {
            // Redirect to login.php if login fails
            header("Location: login.php?fail=1");
            exit();
        }
    }

    if (isset($conn) && $conn) {
        $conn->close();
    }
?>
