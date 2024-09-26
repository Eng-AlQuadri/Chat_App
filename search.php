<?php

    session_start();

    include 'connect.php';

    if($_POST['token'] != $_SESSION['token']) {

        echo json_encode(['auth' => false]);

        exit();

    }

    // Get The Letter From User

    $letter = $_POST['searchLetter'];

    // Get Data From Database

    $stmt = $con->prepare("SELECT * FROM users WHERE Fname LIKE '%$letter%' OR Fname LIKE  '%$letter%'");

    $stmt->execute();

    $count = $stmt->rowCount();

    if(!$count) {

        echo json_encode(['auth' => true,'content' => 'No Data Found']);

        exit();

    }

    $result = $stmt->fetchAll();

    $content = '';

    foreach($result as $user) {

        $content .= '
        
            <div class="body" data-id = '. $user['UserID'].'>
                <div class="texts">
                    <img src="./avatar.png" alt="">
                    <div class="info">
                        <h4>' . $user['Fname'] . '</h4>
                        <h5>' . ($user['Status'] == 1 ? 'Active Now' : 'Offline') . '</h5>
                    </div>
                </div>
                <ul>
                    <li></li>
                </ul>
            </div>
        ';

    }

    echo json_encode(['auth' => true, 'content' => $content]);

