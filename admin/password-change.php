<?php
session_start();
require_once '../includes/database_conn.php';
if (isset($_SESSION['admin_id']) && !empty($_SESSION['id'])) {
    header("Location: ./index");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700;800&family=Poppins:wght@200;300;400;500;600;700&display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title>Login - Admin Panel</title>

    <style>
        body {
            background: url(../assets/images/background.png);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            height: 100vh;
        }

        @media (min-width: 768px) {
            .toast {
                top: 20px;
            }
        }
    </style>
</head>

<body>
    <div id="preloader"></div>

    <!-- TOAST -->
    <div class="toast" id="toast">
        <div class="toast-content" id="toast-content">
            <i id="toast-icon" class="fa-solid fa-triangle-exclamation warning"></i>

            <div class="message">
                <span class="text text-1" id="text-1"></span>
                <span class="text text-2" id="text-2"></span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>
        <div class="progress"></div>
    </div>


    <!-- LOGIN FORM -->
    <div class="login-form-container">
    <form id="admin_pass_change">
            <a href="#" class="logo"><img src="../assets/images/official_logo.png" alt=""></a>
            <h3>Change Password</h3>
            <span>email address</span>
            <input type="email" name="email" id="email" class="box" placeholder="enter your email" value="<?php echo $_GET['email']; ?>">
            <span class="error-email" style="color: #dc3545; font-weight: 700; font-size: 12px;"></span>
            <input type="hidden" name="vkey" id="vkey" value="<?php echo $_GET['vkey']; ?>">
            <span>new password</span>
            <input type="password" name="password" id="password" class="box" placeholder="enter new password">
            <span class="error-password" style="color: #dc3545; font-weight: 700; font-size: 12px;"></span>
            <span>confirm password</span>
            <input type="password" name="cpassword" id="cpassword" class="box" placeholder="enter confirm password">
            <span class="error-cpassword" style="color: #dc3545; font-weight: 700; font-size: 12px;"></span>
            <input type="submit" value="Update Password" class="btn">
        </form>
    </div>

    <script>
        $('#admin_pass_change').on('submit', function(e) {
            e.preventDefault();

            if($('#email.box').val().length === 0) {
                $('.error-email').text('Email is empty!');
            } else {
                $('.error-email').text('');
            }

            if($('#password.box').val().length === 0) {
                $('.error-password').text('Password is empty!');
            } else {
                if($('#password.box').val().length < 8) {
                    $('.error-password').text('Password is too short!');
                } else {
                    $('.error-password').text('');
                }
            }

            if($('#cpassword.box').val().length === 0) {
                $('.error-cpassword').text('Confirm password is empty!');
            } else {
                if($('#cpassword.box').val() != $('#password.box').val()) {
                    $('.error-cpassword').text('Confirm password does not matched!');
                } else {
                    $('.error-cpassword').text('');
                }
            }

            if($('.error-email').text() != '' || $('.error-password').text() != '' || $('.error-cpassword').text() != '') {
                $('#toast').addClass('active');
                $('.progress').addClass('active');
                $('.text-1').text('Error!');
                $('.text-2').text('Fill all required fields!');
                setTimeout(() => {
                    $('#toast').removeClass("active");
                    $('.progress').removeClass("active");
                }, 5000);
            } else {
                var form = new FormData(this);
                form.append('password-change', true);
                $.ajax({
                    type: "POST",
                    url: "./functions/crud/password-change",
                    data: form,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if(response === 'Invalid token!') {
                            $('#toast').addClass('active');
                            $('.progress').addClass('active');
                            $('.text-1').text('Error!');
                            $('.text-2').text('Invalid token!');
                            setTimeout(() => {
                                $('#toast').removeClass("active");
                                $('.progress').removeClass("active");
                            }, 5000);
                        } else if(response == 'Something went wrong!') {
                            $('#toast').addClass('active');
                            $('.progress').addClass('active');
                            $('.text-1').text('Error!');
                            $('.text-2').text('Something went wrong!');
                            setTimeout(() => {
                                $('#toast').removeClass("active");
                                $('.progress').removeClass("active");
                            }, 5000);
                        } else if(response == 'Password updated successfully!') {
                            $('#toast').addClass('active');
                            $('.progress').addClass('active');
                            $('#toast-icon').removeClass(
                                'fa-solid fa-triangle-exclamation').addClass(
                                'fa-solid fa-check warning');
                            $('.text-1').text('Success!');
                            $('.text-2').text('Password updated successfully!');
                            setTimeout(() => {
                                $('#toast').removeClass("active");
                                $('.progress').removeClass("active");
                            }, 5000);
                        }
                        console.log(response);
                    }
                })
            }
        })

        // PRELOADER JS
        var loader = document.getElementById("preloader");

        window.addEventListener("load", function() {
            loader.style.display = "none";
            setTimeout(() => {
                document.querySelector(".toast").classList.remove("active");
            }, 5000);
        })
    </script>
</body>

</html>