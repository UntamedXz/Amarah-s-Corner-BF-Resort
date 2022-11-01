<?php
session_start();
require_once './includes/database_conn.php';
if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false) {
    header("Location: ./login");
}

$user_id = $_SESSION['id'];

$getAccountInfo = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = '$user_id'");

while ($row = mysqli_fetch_array($getAccountInfo)) {
    $userId = $row['user_id'];
    $userProfileIcon = $row['user_profile_image'];
}

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $getUserId = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $userId");
    $row = mysqli_fetch_array($getUserId);
    $userId = $row['user_id'];
    $userProfileIcon = $row['user_profile_image'];

    $getCartCount = mysqli_query($conn, "SELECT SUM(product_qty) FROM cart WHERE user_id = $userId");
    $rowCount = mysqli_fetch_array($getCartCount);
    $cartCount = $rowCount['SUM(product_qty)'];
} else {
    $cartCount = '0';
}

$res = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id");

$per_page = 1;
$page = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $page--;
    $page = $page * $per_page;
}
$record = mysqli_num_rows($res);
$page_number = ceil($record / $per_page);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/backup.css">
    <title>Amarah's Corner - BF Resort Las Piñas</title>

    <style>
    body {
        background: url(./assets/images/background.png) no-repeat;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: calc(100vh - 114px);
        color: #ffaf08;
        font-family: Poppins;

    }

    .status_pic {
        width: 100%;
    }

    /* Layout: */

    .col-main {
        flex: 1;
        border: 2px solid #ffaf08;
        border-radius: 5px;
        margin: 10px;
        ;
    }

    .col-complementary {
        flex: 2;
        text-align: center;
        font-weight: bold;
    }

    /* Responsive: */

    @media only screen and (min-width: 640px) {
        .layout {
            display: flex;
        }
    }

    /* etc */

    .order {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        padding-top: 20px;
        padding-bottom: 20px;
        gap: 20px;
    }

    .container {
        background: black;
        width: 50em;
        max-width: 94%;
        border-radius: 5px;
        padding: 20px;
    }

    .col {
        padding: 1em;
        margin: 0 2px 2px 0;
        background: black;
        border-radius: 5px;

    }

    .order_id_wrapper {
        width: 100%;
        padding: 1em;
    }

    .myOrders {
        width: 100%;
        background: #ffaf08;
        font-weight: bold;
        padding: 10px;
    }

    .order_summary {
        margin-top: 20px;
    }

    .hr-top {
        border: none;
        height: 10px;
        background: linear-gradient(-135deg, black 5px, transparent 0) 0 5px, linear-gradient(135deg, black 5px, #ffaf08 0) 0 5px;
        background-color: black;
        background-position: left bottom;
        background-repeat: repeat-x;
        background-size: 10px 10px;
    }

    .hr-bot {
        border: none;
        height: 10px;
        background: linear-gradient(-135deg, #ffaf08 5px, transparent 0) 0 5px, linear-gradient(135deg, #ffaf08 5px, black 0) 0 5px;
        background-color: #ffaf08;
        background-position: left bottom;
        background-repeat: repeat-x;
        background-size: 10px 10px;
    }

    .hr-normal {
        border: 1px solid #ffaf08;
    }

    #myOrders {
        display: none;
    }

    .price {
        text-align: right;
    }

    .overall_total {
        font-size: 20px;
        font-weight: bold;
    }

    .overall_price {
        font-size: 20px;
        font-weight: bold;
    }

    .instruction {
        font-weight: bold;
    }

    .products {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .products .menu_wrapper {
        display: flex;
        flex-direction: column;
    }

    .summary_wrapper {
        padding: 5px 10px;
    }

    .order_header {
        background-color: black;
        padding: 20px;
        width: 50em;
        max-width: 94%;
        border-radius: 5px;
    }

    .pagination_container {
        margin-top: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination_container .pagination {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .pagination_container .pagination a {
        text-decoration: none;
    }

    .pagination_container .pagination a .button {
        height: 30px;
        width: 40px;
        background-color: #ffaf08;
        border: 2px solid #070506;
        border-radius: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination_container .pagination a .button span {
        text-decoration: none;
        color: #070506;
        font-weight: 600;
    }

    .pagination_container .pagination a .button:hover {
        background-color: #070506;
    }

    .pagination_container .pagination a .button:hover span {
        color: #ffaf08;
        cursor: default;
    }

    .pagination_container .pagination a .button.active {
        background-color: #070506;
    }

    .pagination_container .pagination a .button.active span {
        color: #ffaf08;
    }
    </style>

    <script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var msg = urlParams.get('page'); //success
        console.log(msg);

        $('.page' + msg).addClass('active');
    })
    </script>
</head>

<body>
    <div id="preloader"></div>

    <?php include './includes/navbar.php';?>
    <input type="hidden" name="" id="cartCount" value="<?php echo $cartCount; ?>">

    <input type="hidden" id="profileIconCheck" value="<?php echo $userProfileIcon; ?>">

    <script>
    $(window).on('load', function() {
        if ($('#profileIconCheck').val() == '') {
            $('#profileIcon').attr("src", "./assets/images/no_profile_pic.png");
        } else {
            $('#profileIcon').attr("src", "./assets/images/" + $('#profileIconCheck').val());
        }
    })
    </script>

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

    <?php
$getProfileInfo = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $userId");

$rowInfo = mysqli_fetch_array($getProfileInfo);
$bday = strtotime($rowInfo['user_birthday']);
$str_bday = date("F j, Y", $bday);
?>

    <section class="order">

        <div class="order_header">
            <h1>ORDERS</h1>
        </div>

        <div class="container">
            <div class="hr-top"></div>
            <div class="order_id_wrapper">
                <span><strong>Order ID:</strong></span><br>
            </div>
            <div class="layout">
                <div class="col col-main">
                    <span><strong>Order Date:</strong></span><br>
                    <span><strong>Delivery Mode:</strong></span><br>
                    <span><strong>Payment Mode:</strong></span><br>
                    <span><strong>Address:</strong></span>
                </div>
                <div class="col col-complementary" role="complementary">
                    <span class="status_header">CURRENT STATUS</span>
                    <img class="status_pic" src="./assets/images/status.png">
                </div>
            </div>
            <div class="order_summary">
                <button class="myOrders" onclick="myOrders()">
                    <span style="text-align: left;">ORDER SUMMARY</span>
                    <span style="text-align: right;">>>></span></button>
                <div id=myOrders>
                    <div class="summary_wrapper">
                        <div class="products">
                            <div class="menu_wrapper">
                                <span class="menu_name">product_title</span>
                                <span class="subcategory">subcategory_title</span>
                                <span class="product_qty">x1</span>
                            </div>
                            <span class="price">P </span>
                        </div>
                        <div class="hr-normal"></div>
                        <div class="products">
                            <span class="total">Special Instruction(s): </span>
                            <span class="instruction">Party Cut please. thanks</span>
                        </div>
                        <div class="hr-normal"></div>
                        <div class="products">
                            <span class="total">Sub Total</span>
                            <span class="price">P </span>
                        </div>
                        <div class="products">
                            <span class="total">VAT</span>
                            <span class="price">P </span>
                        </div>
                        <div class="products">
                            <span class="total">Shipping Fee</span>
                            <span class="price">P </span>
                        </div>
                        <div class="hr-normal"></div>
                        <div class="products">
                            <span class="overall_total">Total</span>
                            <span class="overall_price">P </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr-bot"></div>
        </div>

        <div class="pagination_container">
            <div class="pagination">
                <?php
                            for($i = 1; $i <= $page_number; $i++) { ?>
                <a href="?page=<?php echo $i;?>">
                    <div class="button <?php echo 'page' . $i; ?>">
                        <span><?php echo $i; ?></span>
                    </div>
                </a>
                <?php } ?>
            </div>
        </div>
    </section>



    <script>
    var loader = document.getElementById("preloader");

    window.addEventListener("load", function() {
        loader.style.display = "none";
    })
    </script>
    <script>
    function myOrders() {
        var x = document.getElementById("myOrders");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
    </script>
</body>

</html>