<?php
session_start();
require_once './includes/database_conn.php';
if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false) {
    $_SESSION['link_user'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    header("Location: ./login");
}

$user_id = $_SESSION['id'];

$getAccountInfo = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = '$user_id'");

while($row = mysqli_fetch_array($getAccountInfo)) {
    $userId = $row['user_id'];
    $userProfileIcon = $row['user_profile_image'];
}

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

$res = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id");

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * 1;
$record = 1;
$record_db = mysqli_num_rows($res);
$page_number = ceil($record_db / $record);


$pageData = [
    'prevPage' => $page > 1 ? $page - 1 : false,
    'nextPage' => $page + 1 <= $page_number ? $page + 1 : false,
]
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
    <link rel="stylesheet" href="./assets/css/backup.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

</head>


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

<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var msg = urlParams.get('page'); //success
        console.log(msg);

        if(msg == 0) {
            location.href = "http://localhost/theserve-amarah-s-corner-bf-resort/order?page=1";
        }

        $('.page' + msg).addClass('active');
    })
</script>
</head>

<body>
    <div id="preloader"></div>

    <?php include './includes/navbar.php'; ?>
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

    
<section class="order">

<div class="order_header">
    <h1>ORDERS</h1>
</div>

<?php $get_current_order = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_id DESC LIMIT $offset, $record");

if(mysqli_num_rows($get_current_order) > 0) {
    foreach($get_current_order as $current_order) {
        $order_id = $current_order['order_id'];
        $get_delivery_mode = mysqli_query($conn, "SELECT delivery.delivery_title
        FROM delivery
        LEFT JOIN orders
        ON orders.delivery_method = delivery.delivery_id
        WHERE order_id = $order_id");

        $get_payment_method = mysqli_query($conn, "SELECT payment.payment_title
        FROM payment
        LEFT JOIN orders
        ON orders.payment_method = payment.payment_id
        WHERE order_id = $order_id");

        $get_address = mysqli_query($conn, "SELECT order_address.block_street_building, refbrgy.brgyDesc, refcitymun.citymunDesc, refprovince.provDesc
        FROM orders
        LEFT JOIN order_address
        ON orders.order_id = order_address.order_id
        LEFT JOIN order_status
        ON orders.order_status = order_status.order_status_id
        LEFT JOIN refbrgy
        ON order_address.barangay = refbrgy.brgyCode
        LEFT JOIN refcitymun
        ON order_address.city_municipality = refcitymun.citymunCode
        LEFT JOIN refprovince
        ON order_address.province = refprovince.provCode
        WHERE orders.order_id = $order_id");

        $delivery_mode_array = mysqli_fetch_array($get_delivery_mode);
        $payment_method_array = mysqli_fetch_array($get_payment_method);
        $address_array = mysqli_fetch_array($get_address);

        $delivery_mode = $delivery_mode_array['delivery_title'];
        $payment_method = $payment_method_array['payment_title'];
        $block = $address_array['block_street_building'];
        $brgy = $address_array['brgyDesc'];
        $city = $address_array['citymunDesc'];
        $province = $address_array['provDesc'];
        ?>
        <div class="container">
            <div class="hr-top"></div>
            <div class="order_id_wrapper">
                <span><strong>Order ID:</strong> #<?php echo $current_order['order_id'] ?></span><br>
            </div>
            <div class="layout">
                <div class="col col-main">
                    <span><strong>Order Date: </strong><br><?php echo $current_order['order_date'] . ' ' . $current_order['order_time'] ?></span><br>
                    <span><strong>Delivery Mode:</strong><br><?php echo $delivery_mode; ?></span><br>
                    <span><strong>Payment Mode:</strong><br><?php echo $payment_method; ?></span><br>
                    <span><strong>Address:</strong><br><?php if(($block == null) && ($brgy == null) && ($city == null) && ($province == null)) { echo 'Pick up'; } else { echo $block . ', ' . $brgy . ', ' . $city . ', ' . $province; } ?></span>
                </div>
                <div class="col col-complementary" role="complementary">
                    <span class="status_header">CURRENT STATUS</span>
                    <?php
                    if($current_order['delivery_method'] == '1') {
                        if($current_order['order_status'] == 1) {
                            ?>
                            <img class="status_pic" src="./assets/images/pickup_pending.png">
                            <?php
                        } else if($current_order['order_status'] == 2) {
                            ?>
                            <img class="status_pic" src="./assets/images/pickup_confirmed.png">
                            <?php
                        } else if($current_order['order_status'] == 3) {
                            ?>
                            <img class="status_pic" src="./assets/images/pickup_preparing.png">
                            <?php
                        } else if($current_order['order_status'] == 4) {
                            ?>
                            <img class="status_pic" src="./assets/images/ready_to_pickup.png">
                            <?php
                        } else if($current_order['order_status'] == 5) {
                            ?>
                            <img class="status_pic" src="./assets/images/pickup_completed.png">
                            <?php
                        }
                    } else {
                        if($current_order['order_status'] == 1) {
                            ?>
                            <img class="status_pic" src="./assets/images/delivery_pending.png">
                            <?php
                        } else if($current_order['order_status'] == 2) {
                            ?>
                            <img class="status_pic" src="./assets/images/delivery_confirmed.png">
                            <?php
                        } else if($current_order['order_status'] == 3) {
                            ?>
                            <img class="status_pic" src="./assets/images/delivery_preparing.png">
                            <?php
                        } else if($current_order['order_status'] == 4) {
                            ?>
                            <img class="status_pic" src="./assets/images/delivery_ready_to_deliver.png">
                            <?php
                        } else if($current_order['order_status'] == 5) {
                            ?>
                            <img class="status_pic" src="./assets/images/delivery_completed.png">
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="order_summary">
                <button class="myOrders" data-id="<?php echo $order_id; ?>">
                <i class='bx bx-chevron-down left_icon'></i> ORDER SUMMARY <i class='bx bx-chevron-down right_icon'></i>
                </button>
                <div id="myOrders" data-summary="<?php echo $order_id; ?>">
                    <div class="summary_wrapper">
                        <?php
                        $get_items = mysqli_query($conn, "SELECT product.product_title, subcategory.subcategory_title, category.category_title, order_items.qty, order_items.product_total, order_items.variation_value, order_items.special_instructions
                        FROM order_items
                        LEFT JOIN product
                        ON product.product_id = order_items.product_id
                        LEFT JOIN subcategory
                        ON order_items.subcategory_id = subcategory.subcategory_id
                        LEFT JOIN category
                        ON order_items.category_id = category.category_id
                        WHERE order_items.order_id = $order_id");

                        foreach($get_items as $items) {
                            $variation_value = explode(" | ", $items['variation_value']);
                            ?>
                            <div class="products">
                                <div class="menu_wrapper">
                                    <span class="menu_name"><?php echo $items['product_title']; ?></span>
                                    <span class="subcategory"><?php echo $items['category_title'] . ' - ' . $items['subcategory_title']; ?></span>
                                    <span class="product_qty">x<?php echo $items['qty']; ?></span>
                                </div>
                                <span class="price">P <?php echo $items['product_total']; ?></span>
                            </div>
                            <div class="hr-normal"></div>
                            <?php
                            if($items['special_instructions'] != null) {
                            ?>
                            <div class="products">
                                <span class="total">Special Instruction(s): </span>
                                <span class="instruction"><?php echo $items['special_instructions']; ?></span>
                            </div>
                            <div class="hr-normal"></div>
                            <?php
                            }
                        }

                        $get_total = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = $order_id");

                        foreach($get_total as $total) {

                            $totalDB = $total['order_total'];
                            $shipping = $total['shipping_fee'];
                            $subtotal = number_format((float)$totalDB - $shipping, 2, '.', '');
                            $vat = number_format((float)$subtotal * .12, 2, '.', '');
                            $overall_total_convert = number_format((float)$totalDB + $vat, 2, '.', '');

                            ?>
                            <div class="products">
                                <span class="total">Sub Total</span>
                                <span class="price">P <?php echo $subtotal; ?></span>
                            </div>
                            <div class="products">
                                <span class="total">VAT</span>
                                <span class="price">P <?php echo $vat; ?></span>
                            </div>
                            <div class="products">
                                <span class="total">Shipping Fee</span>
                                <span class="price">P <?php if($shipping == null) { echo '0.00'; } else { echo $shipping; } ?></span>
                            </div>
                            <div class="hr-normal"></div>
                            <div class="products">
                                <span class="overall_total">Total</span>
                                <span class="overall_price">P <?php echo $overall_total_convert; ?></span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="hr-bot"></div>
        </div>
        <?php
    }
    ?>
    <div class="pagination_container">
        <div class="pagination">
            <?php
            if($pageData['prevPage']) {
                ?>
                <a href="?<?php echo '&page=' . $pageData['prevPage'];?>">
                    <div class="button">
                        <i style="color: #ffaf08;" class="fa-solid fa-arrow-left-long icon"></i>
                        &nbsp;&nbsp;
                        <span>Previous</span>
                    </div>
                </a>
                <?php
            } else {

            }

            if($pageData['nextPage']) {
                ?>
                <a href="?<?php echo '&page=' . $pageData['nextPage']?>">
                    <div class="button">
                        <span>Next</span>
                        &nbsp;&nbsp;
                        <i style="color: #ffaf08;" class="fa-solid fa-arrow-right-long icon"></i>
                    </div>
                </a>
                <?php
            } else {
                
            }
            ?>
        </div>
    </div>
    <?php
} else {
    ?>
    <p style="color: black;">No current orders...</p>
    <?php
} ?>
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

    window.addEventListener("load", function() {
        loader.style.display = "none";
    })

    $(document).on('click', '.myOrders', function(e) {
        e.preventDefault();

        var id = $(this).data('id');

        console.log(id);

        if($('#myOrders[data-summary='+id+']').css('display') == 'none') {
            $('#myOrders[data-summary='+id+']').css('display', 'block');
            $('.left_icon').css('transform', 'rotate(180deg)');
            $('.right_icon').css('transform', 'rotate(-180deg)');
        } else {
            $('#myOrders[data-summary='+id+']').css('display', 'none');
            $('.left_icon').css('transform', 'rotate(0deg)');
            $('.right_icon').css('transform', 'rotate(0deg)');
        }
    })
    </script>
</body>

</html>