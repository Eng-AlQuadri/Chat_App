<?php 

    session_start();

    include 'connect.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Validation

        if(!isset($_POST['fname'])) {

            echo json_encode(['error' => 'First Name Is Required!']);
        }
        if(!isset($_POST['lname'])) {

            echo json_encode(['error' => 'Last Name Is Required!']);
        }
        if(!isset($_POST['email'])) {

            echo json_encode(['error' => 'Email Is Required!']);
        }
        if(!isset($_POST['pass'])) {

            echo json_encode(['error' => 'Password Is Required!']);
        }

        // Get User Data

        $fname = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
        $lname = filter_var($_POST['lname'],FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['pass'],FILTER_SANITIZE_STRING);
        $hashedPass = password_hash($password,PASSWORD_DEFAULT);

        // Check If User Exists In Database

        $stmt = $con->prepare("SELECT * FROM users WHERE Email = ?");

        $stmt->execute(array($email));

        if($stmt->rowCount()) {

            $user = $stmt->fetch();

        } else {

            $user = 0;
        }
    
        if($user && password_verify($password,$user['Password'])) {

            echo json_encode(['error' => 'This User Is Exists!']);

        } else {

            // Token

            $_SESSION['token'] = password_hash(session_id(),PASSWORD_DEFAULT);

            echo json_encode(['token' => "${_SESSION['token']}"]);

            // Store Data In Database

            $stmt = $con->prepare("INSERT INTO users (Fname,Lname,Email,`Password`,token,`Status`) VALUES (?,?,?,?,?,1)");

            $stmt->execute(array($fname,$lname,$email,$hashedPass,$_SESSION['token']));

            
        }

    }