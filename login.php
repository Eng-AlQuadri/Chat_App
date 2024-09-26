<?php

    session_start();

    include 'connect.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Getting The Data

        $userEmail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

        $userPassword = filter_var($_POST['pass'],FILTER_SANITIZE_STRING);

        $hashedPass = password_hash($userPassword,PASSWORD_DEFAULT);

        // Check If User Exists In Database

        $stmt = $con->prepare("SELECT * FROM users WHERE Email = ?");

        $stmt->execute(array($userEmail));

        $user = $stmt->fetch();

        if($user && password_verify($userPassword,$user['Password'])) {

            // This Means User Is Exists

            $_SESSION['token'] = password_hash(session_id(),PASSWORD_DEFAULT);

            // Add Token To User In Database And Set User Status To 1

            $stmt = $con->prepare("UPDATE users SET token = ?,`Status` = 1 WHERE Email = ?");

            $stmt->execute(array($_SESSION['token'],$userEmail));

            echo json_encode(['token' => "${_SESSION['token']}"]);

        } else {

            // User Is Not Found

            echo json_encode(['error' => 'Incorrect Email And/Or Password']);
        }

    }

