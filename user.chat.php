<?php
    session_start();

    include 'connect.php';

    if(!isset($_SESSION['token'])) {

        header('Location:index.php');

        exit();
    }

    $userId = $_GET['userid'];

    // Get User Data

    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");

    $stmt->execute(array($userId));

    if($stmt->rowCount() < 1) {

        header('Location:index.php');

        exit();

    }

    $data = $stmt->fetch();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link rel='stylesheet' href='./css/master.css'/>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    

    <div class="user-chat">
        <div class="container">
            <div class="chat-box">
                <div class="head">
                    <div class="texts">
                        <img src="./avatar.png" alt="">
                        <div class="info">
                            <h4><?php echo $data['Fname']; ?></h4>
                            <h5><?php echo ( $data['Status'] == 1 ? 'Active Now' : 'Offline') ?></h5>
                        </div>
                    </div>
                    <button><i class="fa-solid fa-arrow-left"></i></button>
                </div>
                <div class="body">
                    <div class="outcome">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, quos ea corrupti consequuntur totam repudiandae qui odit voluptatibus adipisci porro iste veniam repellat fuga? Quos unde saepe maxime odit consectetur.</p>
                    </div>
                    <div class="income">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore ea iure porro. Facilis libero dolores fuga officiis natus ipsum esse sint illum quia impedit omnis tenetur eum pariatur, necessitatibus iure?</p>
                    </div>
                </div>
                <div class="foot">
                    <div class="send">
                        <form action="" class='send'>
                            <input type="text" name='msg' id = 'send'>
                            <input type="hidden" name='sender' value = <?php echo $_SESSION['token'] ?>>
                            <input type="hidden" name='receiver' value = <?php echo $data['UserID'] ?>>
                            <button class='send-btn'><i class="fa-solid fa-share"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src = './js/jquery.js'></script>    

    <script>
        
        $(function() {

            $('.send').on('submit',function(e){

                e.preventDefault();

                $.ajax({

                    url: 'insert.chat.php',
                    type: 'POST',
                    data: $(this).serialize()

                })
            })

            
        });

    </script>
</body>
</html>