<?php 

    session_start();

    include 'connect.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if($_POST['sender'] != $_SESSION['token']) {

            echo json_encode(['auth' => false]);
    
            exit();
    
        }

        // Get Data From The Form

        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];
        $msg = $_POST['msg'];

        // Get Sender Data

        $stmt = $con->prepare("SELECT * FROM users WHERE token = ?");

        $stmt->execute(array($sender));

        $senderData = $stmt->fetch();


        // Insert Data Into Msg Table

        if(!empty($msg)) {

            $stmt = $con->prepare("INSERT INTO messages (Income_Msg_ID,Outgoing_Msg_ID,Msg) VALUES (?,?,?)");

            $stmt->execute(array($receiver,$senderData['UserID'],$msg));
        }

    }