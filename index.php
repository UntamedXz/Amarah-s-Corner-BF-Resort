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
            height: 100vh;
        }
        .open-button {
            background: black;
            border-radius: 50%;
            cursor: pointer;
            opacity: 0.9;
            position: fixed;
            bottom: 50px;
            right: 28px;
            width: 60px;
            padding: 25px 20px;
            z-index: 2000;
       
        }
        .chatbotLogo{
            border-radius: 50%;
            cursor: pointer;
            opacity: 0.9;
            position: fixed;
            bottom: 50px;
            right: 32px;
            width: 50px;
            z-index: 2000;
        }

        /* The popup chat - hidden by default */
        .chat-popup {
            display: none;
            position: fixed;
            right: 19px;
            border-radius: 5px;
            bottom: 2px;
            z-index: 2000;

        }

        /* Add a red background color to the cancel button */
        .cancel {
            color: black;
            background: #ffaf08;
            border-radius: 50%;
            cursor: pointer;
            border: none;
            padding: 3px 10px;
            float: right;
            margin: 5px;
        }
        .cancel:hover {
            color: #ffaf08;;
            background: black;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
            opacity: 1;
        }
        
        .botLogo{
            width: 120px;
            margin-top: 15px;
            margin-left: 140px;
        }
        #container
        {
            height: 100vh;
            width: 100%;
            position: relative;
            display: grid;
            place-items: center;
            background: #f6f6f6;
            overflow: hidden;
        }
        #screen
        {
            height: 670px;
            width: 400px;
            border-radius: 30px;
            background: #f6f6f6;
            border-radius: 25px;
            box-shadow: 3px 3px 15px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }
        #header
        {
            height: 80px;
            width: 100%;
            background: #ffaf08;
            text-shadow: 1px 1px 2px #000000a1;
        }
        #messageDisplaySection
        {
            height: 450px;
            width: 100%;
            position: absolute;
            left: 0;
            top: 100px;
            padding: 0 20px;
            overflow-y: auto;
            
        }
        .chat
        {
            min-height: 40px;
            max-width: 60%;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            
        }
        .botMessages
        {
            background: #ffaf08;
            color: black;
            text-shadow: 1px 1px 2px #000000d4;
        }
        #messagesContainer
        {
            height: auto;
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }
        .usersMessages
        {
            background: #00000010;
        }
        #userInput
        {
            height: 50px;
            width: 90%;
            position: absolute;
            left: 5%;
            bottom: 3%;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        }
        #messages
        {
            height: 50px;
            width: 90%;
            position: absolute;
            left: 0;
            border: none;
            outline: none;
            background: transparent;
            padding: 0px 15px;
            font-size: 17px;
        }
        #send
        {
            height: 50px;
            width: 24%;
            position: absolute;
            right: 0;
            border: none;
            outline: none;
            display: grid;
            place-items: center;
            color: black;
            font-size: 20px;
            background: #ffaf08;
            cursor: pointer;
            display: none;
        }
        .fa-brands{
            color: black;
            background: #ffaf08;
            padding: 10px;
            border-radius: 50%;
        }
        .fa-brands:hover{
            color: #ffaf08;
            background: black;
        }
        .center-brands{
            justify-content: center;
            display: flex;
        }
        .default-message{
            background: #ffaf08;
            color: black;
            text-shadow: 1px 1px 2px #000000d4;
            right: 0;
            padding: 0px 15px;
            font-size: 17px;
            min-height: 40px;
            max-width: 60%;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            float: right;
        }
</style>
   <!-- <script>
        (function (w, d) {
            w.CollectId = "628c48cbfaa7943a0bbb67f1";
            var h = d.head || d.getElementsByTagName("head")[0];
            var s = d.createElement("script");
            s.setAttribute("type", "text/javascript");
            s.async = true;
            s.setAttribute("src", "https://collectcdn.com/launcher.js");
            h.appendChild(s);
        })(window, document);
    </script>
    -->
</head>

<body>
    <div id="preloader"></div>

    <?php include './includes/navbar.php';
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

    <input type="hidden" id="profileIconCheck" value="<?php echo $userProfileIcon; ?>">

    <button class="open-button" onclick="openForm()"><img src="assets/images/amarahchatbot.png" class="chatbotLogo"></button>

<div class="chat-popup" id="myForm">
       
        <div id="screen">
            <div id="header"><img class="botLogo" src="./assets/images/botlogo.png">
            <button type="button" class="btn cancel" onclick="closeForm()"><h3>X</h3></button></div>
            
            <div id="messageDisplaySection">
            Welcome to Amarah's Corner!
                <br>
                Connect with us at:
                <br>
                <div class="center-brands">
                   <a href="https://www.facebook.com/amarahscornerbf"><i class="fa-brands fa-facebook-f"></i></a>
                   <a href="#"><i class="fa-brands fa-twitter"></i></a>
                   <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
                <div class="default-message">
                   <p>How can I help you?</p>
                </div>
                <br><br><br>
            </div>
            <!-- messages input field -->
            <div id="userInput">
                <input type="text" name="messages" id="messages" autocomplete="OFF" placeholder="Type Your Message Here." required>
                <input type="submit" value="Send" id="send" name="send">
            </div>
        </div>
    </div>


<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <!-- Jquery Start -->
    <script>
        $(document).ready(function(){
            $("#messages").on("keyup",function(){

                if($("#messages").val()){
                    $("#send").css("display","block");
                }else{
                    $("#send").css("display","none");
                }
            });
        });
        // when send button clicked
        $("#send").on("click",function(e){
            $userMessage = $("#messages").val();
            $appendUserMessage = '<div class="chat usersMessages">'+ $userMessage +'</div>';
            $("#messageDisplaySection").append($appendUserMessage);

            // ajax start
            $.ajax({
                url: "bot.php",
                type: "POST",
                // sending data
                data: {messageValue: $userMessage},
                // response text
                success: function(data){
                    // show response
                    $appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages">'+data+'</div></div>';
                    $("#messageDisplaySection").append($appendBotResponse);
                }
            });
            $("#messages").val("");
            $("#send").css("display","none");
        });
    </script>

<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
  
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>

<script type="text/javascript">

// When send button gets clicked
document.querySelector("#send").addEventListener("click", async () => {

  // create new request object. get user message
  let xhr = new XMLHttpRequest();
  var userMessage = document.querySelector("#userInput").value


  // create html to hold user message. 
  let userHtml = '<div class="userSection">'+'<div class="messages user-message">'+userMessage+'</div>'+
  '<div class="seperator"></div>'+'</div>'


  // insert user message into the page
  document.querySelector('#body').innerHTML+= userHtml;

  // open a post request to server script. pass user message as parameter 
  xhr.open("POST", "query.php");
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(`messageValue=${userMessage}`);


  // When response is returned, get reply text into HTML and insert in page
  xhr.onload = function () {
      let botHtml = '<div class="botSection">'+'<div class="messages bot-reply">'+this.responseText+'</div>'+
      '<div class="seperator"></div>'+'</div>'

      document.querySelector('#body').innerHTML+= botHtml;
  }

})

</script>
    <script>
        $(window).on('load', function() {
            if($('#profileIconCheck').val() == '') {
                $('#profileIcon').attr("src","./assets/images/no_profile_pic.png");
            } else {
                $('#profileIcon').attr("src","./assets/images/" + $('#profileIconCheck').val());
            }
        })
    </script>

    <!-- BANNER SECTION -->
    <section class="banner" id="home">
        <!-- <img src="./assets/images/banner2.jpg" alt=""> -->

        <div class="banner__wrapper swiper mySwiper">
            <div class="banner__content swiper-wrapper">
                <div class="banner__card swiper-slide">
                    <div class="banner__image">
                        <img src="./assets/images/banner2.jpg" alt="">
                    </div>
                </div>
                <div class="banner__card swiper-slide">
                    <div class="banner__image">
                        <img src="./assets/images/banner.jpg" alt="">
                    </div>
                </div>
                <div class="banner__card swiper-slide">
                    <div class="banner__image">
                        <img src="./assets/images/banner4.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- BRANCH NAME SECTION -->
    <section class="branch">
        <h1 class="branch">Amarah's Corner - BF Resort Las Piñas Branch</h1>
        <h5 class="desc">We aim to be one of the most competitive Pizza Place nationwide. By Serving one of the best
            pizza that will satisfy your cravings.</h5>
    </section>
    <!-- MENU SECTION -->
    <section class="menu" id="menu">
        <h3 class="title-header">Menu</h3>
        <div class="menu__container">
            <div class="menu__wrapper swiper mySwiper">
                <div class="menu__content swiper-wrapper">
                <?php
                $get_category = mysqli_query($conn, "SELECT * FROM category");

                foreach ($get_category as $category_row) {
                $encryptedCategoryId = urlencode(base64_encode($category_row['category_id']));
                ?>
                    <a href="catalog?id=<?php echo $encryptedCategoryId; ?>" class="menu__card swiper-slide">
                        <div class="menu__image">
                            <img src="./assets/images/<?php echo $category_row['categoty_thumbnail']; ?>" alt="">
                        </div>
                        <div class="menu__name">
                            <h3><?php echo ucwords($category_row['category_title']); ?></h3>
                        </div>
                    </a>
                <?php
                }
                ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    <input type="hidden" name="" id="cartCount" value="<?php echo $cartCount; ?>">
    <!-- UPDATES SECTION -->
    <section class="updates" id="updates">
        <h3 class="title-header">Updates</h3>
        <div class="row">
            <?php
            $get_updates = mysqli_query($conn, "SELECT * FROM updates ORDER BY updates_id DESC");

            foreach($get_updates as $updates) {
            ?>
            <!-- UPDATE 1 -->
            <div class="col">
                <div class="image-cont">
                    <img src="./assets/images/<?php echo $updates['updates_image'] ?>" alt="">
                </div>
                <div class="details">
                    <h4>Posted on <?php echo $updates['updates_date']; ?></h4>
                    <h5><?php echo $updates['updates_text']; ?></h5>
                </div>
            </div>
            <?php } ?>
        </div> 
        <div id="load-more">
            <input type="submit" class="load-more" value="LOAD MORE">
        </div>
    </section>

    <div class="image_popup">
        <img src="./assets/images/62a6782ac0b3f.jpg" alt="">
    </div>

    <!-- FEEDBACK SECTION -->
    <section class="feedbacks" id="feedbacks">
        <h3 class="title-header">FEEDBACKS</h3>
        <div class="feedbacks__cont">
            <!-- FEEDBACK 2 -->
            <?php
            $get_feedback = mysqli_query($conn, "SELECT * FROM feedback ORDER BY id DESC");

            foreach($get_feedback as $feedback) {
                $email = $feedback['email'];

                $get_info = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email' LIMIT 1");

                $row = mysqli_fetch_array($get_info);

                $username = $row['username'];
                $pfp = $row['user_profile_image'];
                $name = $row['name'];
            ?>
            <div class="feedbacks__card">
                <div class="feedbacks__top">
                    <div class="feedbacks__user-profile">
                        <div class="feedbacks__user-profile__image">
                            <img class="img" src="./assets/images/<?php echo $pfp; ?>">
                        </div>
                        <div class="feedbacks__name-user">
                            <h4><?php echo $name; ?></h4>
                            <h5><?php echo $username ?></h5>
                        </div>
                    </div>

                    <div class="feedbacks__rate">
                        <?php
                        $count = $feedback['quality_score'];

                        for($i = 0; $i < $count; $i++)
                        {
                        ?>
                        <i class='bx bxs-star'></i>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="feedbacks__comments">
                    <h5><?php echo $feedback['feedback'] ?></h5>
                </div>
            </div>
            <?php
            }
            ?>
            <!-- FEEDBACK 3
            <div class="feedbacks__card">
                <div class="feedbacks__top">
                    <div class="feedbacks__user-profile">
                        <div class="feedbacks__user-profile__image">
                            <img class="img" src="./assets/images/Mark.jpg">
                        </div>
                        <div class="feedbacks__name-user">
                            <h4>Mark Ryan Jancorda</strong>
                                <h5>@markryan.jancorda</h5>
                        </div>
                    </div>

                    <div class="feedbacks__rate">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                    </div>
                </div>
                <div class="feedbacks__comments">
                    <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates quos error reiciendis
                        pariatur
                        voluptate eos, mollitia sit explicabo corrupti dolores, fugiat saepe ad nulla ut!</h5>
                </div>
            </div>
             -->
            <!-- FEEDBACK 4 
            <div class="feedbacks__card">
                <div class="feedbacks__top">

                    <div class="feedbacks__user-profile">
                        <div class="feedbacks__user-profile__image">
                            <img class="img" src="./assets/images/Jovy.jpg">
                        </div>
                        <div class="feedbacks__name-user">
                            <h4>Jovelyn Ocampo</strong>
                                <h5>@jovelyn.ocampo</h5>
                        </div>
                    </div>

                    <div class="feedbacks__rate">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                    </div>
                </div>
                <div class="feedbacks__comments">
                    <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates quos error reiciendis
                        pariatur
                        voluptate eos, mollitia sit explicabo corrupti dolores, fugiat saepe ad nulla ut!</h5>
                </div>
            </div>
            -->
        </div>
        <div id="load-more-feedbacks">
            <input type="submit" class="load-more-feedbacks" value="LOAD MORE">
        </div>
    </section>

    <?php
    if(isset($_SESSION['cancelled'])) {
        echo "
            <script>
                $('#toast').addClass('active');
                $('.progress').addClass('active');
                $('#toast-icon').removeClass(
                    'fa-solid fa-triangle-exclamation').addClass(
                    'fa-solid fa-check warning');
                $('.text-1').text('Success!');
                $('.text-2').text('Order cancelled successfully!');
                setTimeout(() => {
                    $('#toast').removeClass('active');
                    $('.progress').removeClass('active');
                }, 5000);
            </script>
        ";
        unset($_SESSION['cancelled']);
    }

    if(isset($_SESSION['checkout'])) {
        echo "
            <script>
                $('#toast').addClass('active');
                $('.progress').addClass('active');
                $('#toast-icon').removeClass(
                    'fa-solid fa-triangle-exclamation').addClass(
                    'fa-solid fa-check warning');
                $('.text-1').text('Success!');
                $('.text-2').text('The order confirmation has been sent to your email account and mobile number!');
                setTimeout(() => {
                    $('#toast').removeClass('active');
                    $('.progress').removeClass('active');
                }, 5000);
            </script>
        ";
        unset($_SESSION['checkout']);
    }
    ?>



    <?php include './includes/footer.php';?>

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

        $(window).on('load', function() {
            $(document).ready(function() {
                if (window.location.href.indexOf("tracking") > -1) {
                    $('.tracking_wrapper').addClass('active');
                    document.getElementById('backgroundOverlay').classList.add('active');

                    document.getElementById('backgroundOverlay').addEventListener('click', function() {
                        document.getElementById('backgroundOverlay').classList.remove('active');
                        tracking_form.classList.remove('active');
                    })
                }
            });
        })

        document.querySelectorAll('.image-cont img').forEach(image => {
                image.onclick = () => {
                    document.querySelector('.image_popup').style.display = 'flex';
                    document.querySelector('.image_popup img').src = image.getAttribute('src');
                }
            });

            document.querySelector('.image_popup').onclick = () => {
                document.querySelector('.image_popup').style.display = 'none';
            };
    </script>
</body>

</html>