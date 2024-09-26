<?php

    ob_start();
    
    session_start();

    include 'connect.php';

    if(isset($_SESSION['token'])) {

        header('Location: users.php');

        exit();
    }

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
    
    <div class="signup-section">
        <div class="container">
            <form class='signup'>
                <h2>Chatting App</h2>
                <div class="serrors">
                    <!-- <h3>Error</h3> -->
                </div>
                <div class="field">
                    <label for="">First Name</label>
                    <input type="text" name='fname' required>
                </div>
                <div class="field">
                    <label for="">Last Name</label>
                    <input type="text" name='lname' required>
                </div>
                <div class="field">
                    <label for="">Email</label>
                    <input type="email" name='email' required>
                </div>
                <div class="field">
                    <label for="">Password</label>
                    <input type="password" class='pass' name='pass' required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field">
                    <label for="">Image</label>
                    <button id='choose-btn'>Choose File</button>
                </div>
                <input type="submit" value='Continue To Chat' id='submit-btn' name='signup'>
                <div class="question">
                    <p>Already Signed Up? <span data-class='login'>Login Now</span></p>
                </div>
            </form>
            <form class="login">
                <h2>Chatting App</h2>
                <div class="errors">
                    <!-- <h3>Error</h3> -->
                </div>
                <div class="field">
                    <label for="">Email</label>
                    <input type="email" name='email' required>
                </div>
                <div class="field">
                    <label for="">Password</label>
                    <input type="password" class='pass' name='pass' required>
                    <i class="fas fa-eye"></i>
                </div>
                <input type="submit" value='Continue To Chat' id='submit-btn' name='login'>
                <div class="question">
                    <p>Don't Have Acount? <span data-class = 'signup'>Sign Up Now</span></p>
                </div>
            </form>
        </div>
    </div>

    <script src = './js/jquery.js'></script>    

    <script>
        
        $(function() {

            // Show Sign Up Form On Page Load
            $('.signup-section form').hide();

            $('.signup').fadeIn(500);

            // Swap Between Two Forms
            $('.signup-section span').on('click',function() {

                $('.signup-section form').hide();

                $('.' + $(this).data('class')).fadeIn(500);
            });

            // Show Password
            $('.fa-eye').hover(function() {

                $('.pass').attr('type','text');

            }, function() {

                $('.pass').attr('type','password');
            });


            // Login Functionality
            $('.login').on('submit',function(e) {

                e.preventDefault();

                let errorDiv = $('.errors');

                $.ajax({

                    url: 'login.php',
                    type: 'POST',
                    data: $(this).serialize()

                }).then(function(res) {

                    let data = JSON.parse(res);

                    if(data.error) {

                        errorDiv.addClass('show').html(`<h3> ${data.error} </h3>`);

                        return;
                    }

                    localStorage.setItem('chat.token',data.token);

                    location.href = 'users.php';

                }).fail(function(res) {

                    errorDiv.addClass('show').html(`<h3> Error Attempting To Login </h3>`);
                }) 
            });

            // Signup Functionality
            $('.signup').on('submit',function(e) {

                e.preventDefault();

                let errorDiv = $('.serrors');

                $.ajax({

                    url: 'signup.php',
                    type: 'POST',
                    data: $(this).serialize()

                }).then(function(res) {

                    let data = JSON.parse(res);

                    if(data.error) {

                        errorDiv.addClass('show').html(`<h3> ${data.error} </h3>`);

                        return;
                    }

                    localStorage.setItem('chat.token', data.token);

                    location.href = 'users.php';

                }).fail(function(res) {

                    errorDiv.addClass('show').html(`<h3> Error Attempting To Signup </h3>`);
                })
            })

        });

    </script>
</body>
</html>


<?php

    ob_end_flush();

?>