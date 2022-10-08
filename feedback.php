<?php
require_once './includes/database_conn.php';
session_start();

if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $getUserId = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $user_id");
    $row = mysqli_fetch_array($getUserId);
    $userId = $row['user_id'];
    $userProfileIcon = $row['user_profile_image'];

    $getCartCount = mysqli_query($conn, "SELECT SUM(product_qty) FROM cart WHERE user_id = $userId");
    $rowCount = mysqli_fetch_array($getCartCount);
    $cartCount = $rowCount['SUM(product_qty)'];
} else {
    $cartCount = '0';
}

$token = $_GET['token'];
$email = $_GET['email'];

$check_token = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email' AND vkey = '$token' LIMIT 1");

if(mysqli_num_rows($check_token) == 0) {
  header('location: index');
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/backup.css">
    <title>Amarah's Corner - BF Resort Las Piñas</title>

    <style>
        body {
            background: url(./assets/images/background.png) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100%;
        }
    </style>
</head>

<body>
    <div id="preloader"></div>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "
        <script type='text/javascript'>
            window.onload = (event) => {
                document.querySelector('.header .header-1 .left .profile').style.display = 'flex';

                document.querySelector('.header .header-1 .left .loginBtn').style.display = 'none';
            }
        </script>
        ";
    }
    ?>

    <section class="feedback">
        <form action="" id="feedback">
            <div class="container">
                <div class="logo">
                    <img src="./assets/images/Amarah's Corner Logo copy.png" alt="">
                </div>
                <div class="star_widget">
                    <input type="radio" name="rate" id="rate-5" value="5" required>
                    <label for="rate-5" class="fa-solid fa-star"></label>
                    <input type="radio" name="rate" id="rate-4" value="4">
                    <label for="rate-4" class="fa-solid fa-star"></label>
                    <input type="radio" name="rate" id="rate-3" value="3">
                    <label for="rate-3" class="fa-solid fa-star"></label>
                    <input type="radio" name="rate" id="rate-2" value="2">
                    <label for="rate-2" class="fa-solid fa-star"></label>
                    <input type="radio" name="rate" id="rate-1" value="1">
                    <label for="rate-1" class="fa-solid fa-star"></label>
                </div>
                <input type="hidden" name="email" id="email" value="<?php echo $_GET['email']; ?>">
                <input type="hidden" name="token" id="token" value="<?php echo $_GET['token']; ?>">
                <div class="form">
                    <div class="textarea">
                        <textarea name="comment" id="comment" cols="30" rows="3" placeholder="Do you have any comment/suggestion for us?"></textarea>
                    </div>
                    <div class="btn">
                        <button type="submit">POST</button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <?php include './includes/cart-count.php' ?>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js">
    </script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js">
    </script>
    <script src="./assets/js/script.js"></script>
    <script>
        var loader = document.getElementById("preloader");

        window.addEventListener("load", function () {
            loader.style.display = "none";
        })

        $('#feedback').on('submit', function(e) {
          e.preventDefault();

          var form = new FormData(this);
          form.append('submit_feedback', true);

          $.ajax({
            url: "./functions/crud/feedback",
            type: "POST",
            data: form,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
              if(data == 'success') {
                window.location.href = "index";
              }
              console.log(data);
            }
          })
        })
    </script>
</body>

</html>