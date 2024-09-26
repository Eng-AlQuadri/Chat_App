<?php

    session_start();

    include 'connect.php';

    if($_GET['token'] != $_SESSION['token']) {

        echo json_encode(['auth' => false]);

    } else {

        // Get Data

        $stmt = $con->prepare("SELECT * FROM users");

        $stmt->execute();

        $count = $stmt->rowCount();

        $content = '';

        if($count == 1) {

            // You Are The Only User

            echo json_encode(['auth' => true, 'content' => "No Data Found"]);

            exit();

        } elseif($count > 1) {

            $data = $stmt->fetchAll();

            foreach($data as $user) {

                $content .= '
                    <div class="body" data-id = '. $user['UserID'] .'>
                        <div class="texts">
                            <img src="./avatar.png" alt="">
                            <div class="info">
                                <h4>' .  $user['Fname'] . '</h4>
                                <h5>' .  ($user['Status'] == 1 ? "Active Now" : "Offline") . '</h5>
                            </div>
                        </div>
                        <ul>
                            <li></li>
                        </ul>
                    </div>
                ';
            }
        }

        echo json_encode(['auth' => true, 'content' => $content]);
    }

