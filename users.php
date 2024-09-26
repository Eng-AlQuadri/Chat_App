<?php

    session_start();

    include 'connect.php';

    if(!isset($_SESSION['token'])) {

        header('Location:index.php');

        exit();
    }

    // Get Current User Data From Database

    $stmt = $con->prepare("SELECT * FROM users WHERE token = ?");

    $stmt->execute(array($_SESSION['token']));

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

    <div class="users">
        <div class="container">
            <div class="main-box">
                <div class="head">
                    <div class="texts">
                        <img src="./avatar.png" alt="">
                        <div class="info">
                            <h4><?php echo $data['Fname'] ?></h4>
                            <h5><?php echo $data['Status'] == 1 ? 'Active Now' : 'Offline' ?></h5>
                        </div>
                    </div>
                    <button id="logout">Logout</button>
                </div>
                <div class="search-box">
                    <input type='text' placeholder = 'Select An User To Start Chat' class='isearch'>
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="users-box">
                    <!-- <div class="body">
                        <div class="texts">
                            <img src="./avatar.png" alt="">
                            <div class="info">
                                <h4>John Doe</h4>
                                <h5>Active Now</h5>
                            </div>
                        </div>
                        <ul>
                            <li></li>
                        </ul> 
                    </div> -->
                </div>
                
            </div>
        </div>
    </div>

    <script src = './js/jquery.js'></script>    

    <script>
        
        $(function() {

            let searchBar = $('.isearch');

            // Hot Reload For Users
            setInterval(() => {
                
                $.ajax({

                    url: 'users.provide.php',
                    type: 'GET',
                    data:{
                        token: window.localStorage.getItem('chat.token')
                    } 

                }).then(function(res) {

                    let data = JSON.parse(res);

                    if(!data.auth) {

                        location.href = 'index.php';
                    }

                    let usersDiv = $('.users-box');

                    if(!searchBar.hasClass('active')) {

                        usersDiv.html(data.content);
                    }
                        
                    
                })

            }, 2000);

            // Search Box Functionality
            $('.isearch').on('keyup',function() {

                if(searchBar.val() != '') {

                    searchBar.addClass('active');

                } else {

                    searchBar.removeClass('active');
                }

                // Get Value From Search Input

                let letter = $(this).val();

                $.ajax({

                    url: 'search.php',
                    type:'POST',
                    data: {
                        token: window.localStorage.getItem('chat.token'),
                        searchLetter: letter
                    }

                }).then(function(res) {

                    let data = JSON.parse(res);

                    if(!data.auth) {

                        location.href = 'index.php';

                    }

                    let usersDiv = $('.users-box');

                    usersDiv.html(data.content);

                })
            });

            // Event Delegation For Open 
            $(document).on('click','.body',function() {
                location.href = `user.chat.php?userid=${$(this).data('id')}`;
            });
        });

    </script>
</body>
</html>