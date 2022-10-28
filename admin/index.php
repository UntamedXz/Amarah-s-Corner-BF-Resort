<?php
session_start();
if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] != true) {
    header("Location: ./login");
} else {
    $admin_id = $_SESSION['admin_id'];
}
require_once '../includes/database_conn.php';

$get_admin_info = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = $admin_id");

$info = mysqli_fetch_array($get_admin_info);

$userProfileIcon = $info['profile_image'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700;800&family=Poppins:wght@200;300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/admin.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <!-- Montserrat Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <title>Admin Dashboard</title>

    <script>
    function loadDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200 && this.responseText == "New order!") {
                Notification.requestPermission().then(perm => {
                    if (perm === "granted") {
                        const notification = new Notification("Amarah's Corner - BF Resort", {
                            body: this.responseText,
                            icon: "../assets/images/official_logo_crop.png",
                            tag: "New order!",
                        })
                        $('#audioBox')[0].play();
                        notification.addEventListener("click", function(e) {
                            e.preventDefault();
                            location.href =
                                "http://localhost/theserve-amarah-s-corner-bf-resort/admin/order-pending";
                        })
                    }
                })
            }
        };
        xhttp.open("GET", "./functions/get-order-notif.php", true);
        xhttp.send();
    }

    function load_orders_activity() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("orders_activity").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "orders-activity.php", true);
        xhttp.send();
    }

    function load_store_details() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("store_details").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "store-details.php", true);
        xhttp.send();
    }

    setInterval(function() {
        loadDoc();
        load_orders_activity();
        load_store_details();
    }, 3000);
    </script>
    <style>
    .chartBox {
        display: flex;
        padding: 20px;
        border-radius: 20px;
        background: black;
        color: #ffaf08;
    }

    .vertical-menu {
        width: 200px;
    }

    .vertical-menu a {
        background-color: black;
        color: #ffaf08;
        display: block;
        border: 1px solid #ffaf08;
        margin: 10px;
        padding: 12px;
        text-decoration: none;
    }

    .vertical-menu a:hover {
        background-color: #ccc;
    }

    .vertical-menu a.active {
        background-color: #ffaf08;
        color: black;
    }
    </style>

</head>

<body>
    <?php include 'top.php';?>

    <audio id="audioBox">
        <source src="../assets/sounds/New Notification.mp3" type="audio/mpeg" />
    </audio>

    <main>
        <h1 class="title">Dashboard</h1>
        <ul class="breadcrumbs">
            <li><a href="index">Home</a></li>
        </ul>
        <section class="dashboard">
            <div class="wrapper">
                <h1>Orders Activity</h1>
                <div class="boxes__container" id="orders_activity">
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">Pending</span>
                            <?php
                        $get_pending_count = mysqli_query($conn, "SELECT COUNT(order_id)
                        FROM orders
                        WHERE order_status = 1;");

                        $pending = mysqli_fetch_array($get_pending_count);
                        ?>
                            <span class="count"><?php echo $pending['COUNT(order_id)']; ?></span>
                        </div>
                    </div>
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">Confirmed</span>
                            <?php
                        $get_confirmed_count = mysqli_query($conn, "SELECT COUNT(order_id)
                        FROM orders
                        WHERE order_status = 2;");

                        $confirmed = mysqli_fetch_array($get_confirmed_count);
                        ?>
                            <span class="count"><?php echo $confirmed['COUNT(order_id)']; ?></span>
                        </div>
                    </div>
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-fire-burner"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">Preparing</span>
                            <?php
                        $get_preparing_count = mysqli_query($conn, "SELECT COUNT(order_id)
                        FROM orders
                        WHERE order_status = 3;");

                        $preparing = mysqli_fetch_array($get_preparing_count);
                        ?>
                            <span class="count"><?php echo $preparing['COUNT(order_id)']; ?></span>
                        </div>
                    </div>
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-boxes-packing"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">To be Received</span>
                            <?php
                        $get_to_be_received_count = mysqli_query($conn, "SELECT COUNT(order_id)
                        FROM orders
                        WHERE order_status = 4;");

                        $to_be_received = mysqli_fetch_array($get_to_be_received_count);
                        ?>
                            <span class="count"><?php echo $to_be_received['COUNT(order_id)']; ?></span>
                        </div>
                    </div>
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-check-to-slot"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">Completed</span>
                            <?php
                        $get_completed_count = mysqli_query($conn, "SELECT COUNT(order_id)
                        FROM orders
                        WHERE order_status = 5;");

                        $completed = mysqli_fetch_array($get_completed_count);
                        ?>
                            <span class="count"><?php echo $completed['COUNT(order_id)']; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrapper">
                <h1>Store Details</h1>
                <div class="boxes__container" id="store_details">
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-sack-dollar"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">Total Sales</span>
                            <?php

                        $get_total_sales = mysqli_query($conn, "SELECT SUM(order_total)
                        FROM orders WHERE order_status = 5;");

                        $total_sales = mysqli_fetch_array($get_total_sales);
                        ?>
                            <span class="count">P <span
                                    class="total_sales"><?php echo number_format($total_sales['SUM(order_total)'], 2); ?></span></span>
                        </div>
                    </div>
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">Sales Today</span>
                            <?php
                            date_default_timezone_set('Asia/Manila');
                            $date = date('F j, Y');

                        $get_sales_today = mysqli_query($conn, "SELECT SUM(order_total)
                        FROM orders
                        WHERE order_date
                        LIKE '$date%' AND order_status = 5");

                        $sales_today = mysqli_fetch_array($get_sales_today);
                        ?>
                            <span class="count">P <span
                                    class="sales_today"><?php echo number_format($sales_today['SUM(order_total)'], 2); ?></span></span>
                        </div>
                    </div>
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-pizza-slice"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">Products</span>
                            <?php
                        $get_products_count = mysqli_query($conn, "SELECT COUNT(product_id)
                        FROM product;");

                        $products = mysqli_fetch_array($get_products_count);
                        ?>
                            <span class="count"><?php echo $products['COUNT(product_id)']; ?></span>
                        </div>
                    </div>
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">Categories</span>
                            <?php
                        $get_category_count = mysqli_query($conn, "SELECT COUNT(category_id)
                        FROM category;");

                        $category = mysqli_fetch_array($get_category_count);
                        ?>
                            <span class="count"><?php echo $category['COUNT(category_id)']; ?></span>
                        </div>
                    </div>
                    <div class="box">
                        <div class="icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="title__count">
                            <span class="title">Customers</span>
                            <?php
                        $get_customer_count = mysqli_query($conn, "SELECT COUNT(user_id)
                        FROM customers;");

                        $customer = mysqli_fetch_array($get_customer_count);
                        ?>
                            <span class="count"><?php echo $customer['COUNT(user_id)']; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="graph__wrapper">
                <h1>Sales Graph</h1>
                <div class="container">
                    <div class="chartBox">
                        <canvas id="myChart"></canvas>
                    </div>
                    <div class="chartBox">
                        <div class="vertical-menu">
                            <a href="#" class="active">BEST SELLERS</a>
                            <a href="#">Cheesy Pizza</a>
                            <a href="#">Creamy Pasta</a>
                            <a href="#">Milk Tea</a>
                            <a href="#">Buffalo Wings</a>
                            <a href="#">Hot Coffee</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'bottom.php'?>
    <!-- Scripts -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // setup 
    const data = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Weekly Sales',
            data: [18, 12, 6, 9, 12, 3, 9],
            backgroundColor: [
                '#ffaf08',
            ],
        }]
    };

    // config 
    const config = {
        type: 'bar',
        data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // render init block
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
    </script>

</body>

</html>