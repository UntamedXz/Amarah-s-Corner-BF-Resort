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

if($cartCount < 1) {
    header("location: index");
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
    <link rel="stylesheet" href="./assets/css/backup.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
    <link href="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.skypack.dev/maplibre-gl/dist/maplibre-gl.css">
    <script
        src="https://api.jawg.io/libraries/jawg-places@latest/jawg-places.js?access-token=fW9beqQeuIqz2IrxTv2f38PTASuc89UjbVhsgZjPMewqFe6aFFsZbKliOzJMDFqg">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/maplibre-gl@1.15.2/dist/maplibre-gl.min.css">
    <script src="https://cdn.jsdelivr.net/npm/maplibre-gl@1.15.2/dist/maplibre-gl.min.js"></script>
</head>


<script>
$(document).ready(function() {
    $('#table_id').dataTable({
        responsive: true,
        scrollX: true,
    });
});
</script>
</script>


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
    <div class="checkout_overlay">
    </div>
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

    <div class="check">

    </div>

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

    <section class="checkout">
        <div class="checkout_wrapper">
            <div class="left_checkout_wrapper">
                <form action="" id="checkout_form">
                    <h1>Checkout</h1>
                    <?php
                    $province_db = '';
                    $city_db = '';
                    $barangay_db = '';
                    $block_db = '';
                    $get_info = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $user_id");

                    foreach ($get_info as $info) {
                    $province_db = $info['province'];
                    $city_db = $info['city_municipality'];
                    $barangay_db = $info['barangay'];
                    $block_db = $info['block_street_building'];
                    ?>
                    <span>Personal Information</span>
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                    <div class="group_form_group">
                        <div class="form_group left">
                            <span>Billing Fullname</span>
                            <input class="default" type="text" name="billing_name" id="fullname"
                                value="<?php echo $info['name'] ?>">
                            <span class="error-fullname" style="color: #dc3545;"></span>
                        </div>
                        <div class="form_group right">
                            <span>Phone Number</span>
                            <input class="default" type="tel"
                                onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="11"
                                name="billing_phone" id="phone_number" value="<?php echo $info['phone_number'] ?>">
                            <span class="error-phone_number" style="color: #dc3545;"></span>
                        </div>
                    </div>
                    <div class="form_group">
                        <span>Email Address</span>
                        <input class="default" type="text" name="billing_email" id="email" readonly
                            value="<?php echo $info['email'] ?>">
                        <span class="error-email_address" style="color: #dc3545;"></span>
                    </div>
                    <?php
}
?>
                    <span class="click_here"><a href="account">Click here</a> to update personal information</span>

                    <div class="payment-wrapper">
                        <span>Mode of Delivery</span>
                        <div class="option_wrapper">
                            <input type="radio" name="deliver" value="1" class="deliver" id="option-1-d" checked>
                            <input type="radio" name="deliver" value="2" class="deliver" id="option-2-d">
                            <input type="radio" name="deliver" value="3" class="deliver" id="option-3-d">
                            <label for="option-1-d" class="option option-1">
                                <div class="box"></div>
                                <span>Pick Up</span>
                            </label>
                            <label for="option-2-d" class="option option-2">
                                <div class="box"></div>
                                <span>Delivery via Lalamove</span>
                            </label>
                            <label for="option-3-d" class="option option-3">
                                <div class="box"></div>
                                <span>Delivery within BF</span>
                            </label>
                        </div>
                        <span class="error-deliver" style="color: #dc3545;"></span>
                    </div>

                    <div class="form_group pickup">
                        <span>Pick up time</span>
                        <input
                            style="border: 2px solid #07050639; border-radius: 5px;height: 25px; line-height: 25px; font-weight: 500; font-size: 14px; width: 100%; padding: 0 5px"
                            type="time" name="pickup_time" id="pickup_time">
                    </div>

                    <div class="group_form_group pin_button_container">
                        <button class="pin_button" type="button">UPDATE MY PIN</button>
                    </div>

                    <div class="map_container">
                        <div class="note">
                            <center>
                                <h4>Notice:</h4>
                                <p>Please double check if your pin corresponds to your current address such as
                                    incorrectly placing your pin location will incur additional charges</p>
                            </center>
                        </div>
                        <div id="map"></div>
                        <button type="button" class="close_map">Confirm</button>
                    </div>
                    <input type="hidden" name="lng" id="lng">
                    <input type="hidden" name="lat" id="lat">
                    <input type="hidden" name="sf" id="sf">

                    <div class="group_form_group address_div">
                        <div class="form_group">
                            <span>Province</span>
                            <select name="province" id="province">
                            </select>
                            <input type="hidden" name="province_value" id="province_value"
                                value="<?php echo $province_db; ?>">
                            <span class="error-province" style="color: #dc3545;"></span>
                        </div>
                        <div class="form_group">
                            <span>City</span>
                            <select name="city" id="city">
                            </select>
                            <input type="hidden" name="city_value" id="city_value" value="<?php echo $city_db; ?>">
                            <span class="error-city" style="color: #dc3545;"></span>
                        </div>
                    </div>
                    <div class="group_form_group address_div">
                        <div class="form_group">
                            <span>Barangay</span>
                            <select name="barangay" id="barangay">
                            </select>
                            <input type="hidden" name="barangay_value" id="barangay_value"
                                value="<?php echo $barangay_db; ?>">
                            <span class="error-barangay" style="color: #dc3545;"></span>
                        </div>
                        <div class="form_group">
                            <span>Block No., Bldg. & St. Name</span>
                            <input type="text" name="block" id="block"
                                value="<?php if($block_db != null) { echo $block_db; } ?>">
                            <span class="error-block" style="color: #dc3545;"></span>
                        </div>
                    </div>

                    <div class="payment-wrapper">
                        <span>Mode of Payment</span>
                        <div class="option_wrapper">
                            <input type="radio" value="1" name="payment" class="payment" id="option-1" checked>
                            <input type="radio" value="2" name="payment" class="payment" id="option-2">
                            <label for="option-1" class="option option-1">
                                <div class="box"></div>
                                <span>Cash on Delivery/Pick Up</span>
                            </label>
                            <label for="option-2" class="option option-2">
                                <div class="box"></div>
                                <span>Gcash</span>
                            </label>
                        </div>
                    </div>

                    <div class="gcash_payment">
                        <div class="img-container">
                            <img src="./assets/images/gcashqr.png" alt="">
                        </div>
                        <div class="content">
                            <div class="form_group">
                                <span>Screenshot of Payment:</span>
                                <input type="file" name="screenshot" accept=".jpg, .jpeg, .png" id="screenshot">
                                <span class="error-screenshot" style="color: #dc3545;"></span>
                            </div>
                            <div class="form_group">
                                <span>Reference No:</span>
                                <input type="text" name="reference" id="reference">
                                <span class="error-reference" style="color: #dc3545;"></span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="shipping_value" id="shipping_value">
                    <input type="hidden" name="order_total_val" id="order_total_val">

                    <button type="submit">COMPLETE PURCHASE</button>
                </form>
            </div>
            <div class="right_checkout_wrapper">
                <span class="order_title">YOUR ORDER</span>
                <hr>
                <?php
                $get_cart = mysqli_query($conn, "SELECT product.product_title, product.product_price, subcategory.subcategory_title, cart.product_total, cart.variation_value, product_qty, category.category_title, cart.special_instructions
                FROM cart
                LEFT JOIN product
                ON cart.product_id = product.product_id
                LEFT JOIN subcategory
                ON cart.subcategory_id = subcategory.subcategory_id
                LEFT JOIN category
                ON cart.category_id = category.category_id
                WHERE user_id = $user_id");

                foreach ($get_cart as $cart) {
                    $variation_value = explode(" | ", $cart['variation_value']);
                ?>
                <div class="form_group">
                    <div class="span_group">
                        <span class="product_title"><?php echo $cart['product_title']; ?></span>
                        <span
                            class="sub_category"><?php echo $cart['category_title'] . " - " . $cart['subcategory_title']; ?></span>
                        <?php foreach($variation_value as $vval) {
                        ?>
                        <span class="variation_value"><?php echo $vval; ?></span>
                        <?php
                        }

                        if($cart['special_instructions'] != null) {
                        ?>
                        <span class="variation_value">SPECIAL INSTRUCTIONS:
                            <?php echo $cart['special_instructions']; ?></span>
                        <?php
                        }
                        ?>
                        <span class="qty">x<?php echo $cart['product_qty']; ?></span>
                    </div>
                    <div class="total_span">
                        <span>P</span><span class="total_per_item"><?php echo $cart['product_total']; ?></span>
                    </div>
                </div>
                <?php
                }
                ?>
                <hr>
                <div class="form_group">
                    <span>Total Purchases</span>
                    <div class="total_span">
                        <span>P</span><span class="total_purchases get_total">199.00</span>
                    </div>
                </div>
                <div class="form_group">
                    <span>Shipping Fee</span>
                    <div class="total_span">
                        <span>P</span><span class="shipping_fee get_total">199.00</span>
                    </div>
                </div>
                <hr>
                <div class="form_group">
                    <span>Total</span>
                    <div class="total_span total_bold">
                        <span class="total_bold">P</span><span class="total_bold overall_total">0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include './includes/cart-count.php'?>
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
    </script>

    <script type="text/javascript">
    // CLOSE MAP MODAL
    $(document).on('click', '.close_map', function() {
        console.log('clicked');
        if ($('#sf').val().length == 0) {
            $('#toast').addClass('active');
            $('.progress').addClass('active');
            $('.text-1').text('Error!');
            $('.text-2').text('Invalid address!');
            setTimeout(() => {
                $('#toast').removeClass("active");
                $('.progress').removeClass("active");
            }, 5000);
        }
        $('.map_container').removeClass('active');
        $('.checkout_overlay').removeClass('active');
    })

    $(document).on('click', '.pin_button', function() {
        console.log('clicked');
        $('.map_container').addClass('active');
        $('.checkout_overlay').addClass('active');
    })

    // GET CITY
    $("#province").change(function() {
        $('#province_value').val($(this).val());
        $('#barangay').val('');
        $('#city_value').val('');
        $('#barangay_value').val('');
        $('#city').attr("disabled", false);
        var province_id = $(this).val();
        $.ajax({
            url: "./functions/crud/profile",
            type: "POST",
            data: {
                province_id: province_id,
                get_city: true,
            },
            success: function(data) {
                $('#city').html(data);
            }
        })
    })

    // GET BARANGAY
    $("#city").change(function() {
        $('#city_value').val($(this).val());
        $('#barangay_value').val('');
        $('#barangay').attr("disabled", false);
        var city_id = $(this).val();
        console.log(city_id);
        $.ajax({
            url: "./functions/crud/profile",
            type: "POST",
            data: {
                city_id: city_id,
                get_barangay: true,
            },
            success: function(data) {
                $('#barangay').html(data);
            }
        })
    })

    $('#barangay').change(function() {
        $('#barangay_value').val($(this).val());
    })

    $('#pickup_time').change(function() {
        <?php
            if(isset($_POST['pickup_time'])) {
                $pickup_time = $_POST['pickup_time'];
                date_default_timezone_set('Asia/Manila');
                $day = date('N');
                $time = date('H:i', strtotime($pickup_time));

                $get_time_db = mysqli_query($conn, "SELECT * FROM open_hours WHERE day_id = $day");

                $get_time = mysqli_fetch_array($get_time_db);


                $open_time = $get_time['open_hour'];
                $start_time = date('H:i', strtotime($open_time));
                $close_time = $get_time['close_hour'];
                $end_time = date('H:i', strtotime($close_time));

                $status = 'closed';

                if($start_time > $end_time) {
                    if($start_time < $time && $time > $end_time) {
                        $status = 'open';
                        echo $status;
                    } else {
                        $status = 'closed';
                        echo $status;
                    }
                } else {
                    if($start_time < $time && $time < $end_time) {
                        $status = 'open';
                        echo $status;
                    } else {
                        $status = 'closed';
                        echo $status;
                    }
                }
            }
        ?>
    })

    // MODE OF DELIVERY VALUE
    $(window).on('load', function() {
        if ($('input[name="deliver"]:checked').val() == 2) {
            $('.address_div').css('display', 'flex');
            $('.pin_button_container').css('display', 'flex');
        } else if ($('input[name="deliver"]:checked').val() == 1) {
            $('.address_div').css('display', 'none');
            $('.pin_button_container').css('display', 'none');
        } else if ($('input[name="deliver"]:checked').val() == 3) {
            $('.address_div').css('display', 'flex');
            $('.pin_button_container').css('display', 'none');
        }
    })

    $('input[type=radio][name=deliver]').change(function(e) {
        e.preventDefault();
        if ($('input[name="deliver"]:checked').val() == 2) {
            $('.address_div').css('display', 'flex');
            $('.map_container').addClass('active');
            $('.checkout_overlay').addClass('active');
            $('.pin_button_container').css('display', 'flex');

            var prov_db = "<?php echo $province_db ?>";
            var city_db = "<?php echo $city_db ?>";

            $.ajax({
                url: "./functions/crud/profile",
                type: "POST",
                data: {
                    get_all_prov: true,
                },
                success: function(data) {
                    $('#province').html(data);
                    $('#province').val('<?php echo $province_db; ?>');
                    $('#province_value').val('<?php echo $province_db; ?>');
                }
            })

            $.ajax({
                url: "./functions/crud/profile",
                type: "POST",
                data: {
                    prov_db: prov_db,
                    get_all_city: true,
                },
                success: function(data) {
                    $('#city').html(data);
                    $('#city').val('<?php echo $city_db; ?>');
                    $('#city_value').val('<?php echo $city_db; ?>');
                }
            })

            $.ajax({
                url: "./functions/crud/profile",
                type: "POST",
                data: {
                    city_db: city_db,
                    get_all_brgy: true,
                },
                success: function(data) {
                    $('#barangay').html(data);
                    $('#barangay').val('<?php echo $barangay_db; ?>');
                    $('#barangay_value').val('<?php echo $barangay_db; ?>');
                }
            })

            $('#block').val('<?php echo $block_db; ?>');
            $('#province').attr('disabled', false);
            $('#city').attr('disabled', false);
            $('#barangay').attr('disabled', false);

        } else if ($('input[name="deliver"]:checked').val() == 1) {
            $('.address_div').css('display', 'none');
            $('.map_container').removeClass('active');
            $('.checkout_overlay').removeClass('active');
            $('.pin_button_container').css('display', 'none');
            $('#province').val('');
            $('#province_value').val('');
            $('#city').val('');
            $('#city_value').val('');
            $('#barangay').val('');
            $('#barangay_value').val('');
            $('#block').val('');
        } else if ($('input[name="deliver"]:checked').val() == 3) {
            $('.address_div').css('display', 'flex');
            $('.map_container').removeClass('active');
            $('.checkout_overlay').removeClass('active');
            $('.pin_button_container').css('display', 'none');

            var prov_db = '1376';
            var city_db = '137604';
            var brgy_db = '137604007';

            $.ajax({
                url: "./functions/crud/profile",
                type: "POST",
                data: {
                    get_all_prov: true,
                },
                success: function(data) {
                    $('#province').html(data);
                    $('#province').val(prov_db);
                    $('#province_value').val(prov_db);
                }
            })

            $.ajax({
                url: "./functions/crud/profile",
                type: "POST",
                data: {
                    prov_db: prov_db,
                    get_all_city: true,
                },
                success: function(data) {
                    $('#city').html(data);
                    $('#city').val(city_db);
                    $('#city_value').val(city_db);
                }
            })

            $.ajax({
                url: "./functions/crud/profile",
                type: "POST",
                data: {
                    city_db: city_db,
                    get_all_brgy: true,
                },
                success: function(data) {
                    $('#barangay').html(data);
                    $('#barangay').val(brgy_db);
                    $('#barangay_value').val(brgy_db);
                }
            })

            $('#block').val('');
            $('#province').attr('disabled', true);
            $('#city').attr('disabled', true);
            $('#barangay').attr('disabled', true);
        }
    })

    // GET TOTAL
    $(window).on('load', function() {

        var delivery_opt = $('input[name=deliver]:checked').val();
        $('.shipping_fee').text('0.00');

        var overall_total = 0;
        $('.total_per_item').each(function() {
            var subtotal = parseFloat($(this).text());
            overall_total += subtotal;
        })

        $('.total_purchases').text(parseFloat(overall_total).toFixed(2));

        var total_purchases = $('.total_purchases').text();
        var shipping_fee = $('.shipping_fee').text();
        var sum = parseFloat(total_purchases) + parseFloat(shipping_fee);

        $('.overall_total').text(parseFloat(sum).toFixed(2));
        $('#order_total_val').val(parseFloat(sum).toFixed(2));
    })

    $('.deliver').on('change', function() {
        var delivery_opt = $('input[name=deliver]:checked').val();
        var df = $('#sf').val();
        if (delivery_opt == "2") {
            if (df = "NaN") {
                $('.shipping_fee').text(parseFloat(0).toFixed(2));
                $('#shipping_value').val(parseFloat(0).toFixed(2));
            } else {
                $('.shipping_fee').text(parseFloat(df).toFixed(2));
                $('#shipping_value').val(parseFloat(df).toFixed(2));
            }
        } else {
            $('.shipping_fee').text(parseFloat(0).toFixed(2));
            $('#shipping_value').val(parseFloat(0).toFixed(2));
        }

        var total_purchases = $('.total_purchases').text();
        var shipping_fee = $('.shipping_fee').text();
        var sum = parseFloat(total_purchases) + parseFloat(shipping_fee);

        $('.overall_total').text(parseFloat(sum).toFixed(2));
        $('#order_total_val').val(parseFloat(sum).toFixed(2));
    })

    $('.payment').on('change', function() {
        var payment_opt = $('input[name=payment]:checked').val();

        if (payment_opt == "2") {
            $('.gcash_payment').css("display", "flex");
        } else {
            $('.gcash_payment').css("display", "none");
        }
    })

    // SUBMIT CHECKOUT
    $('#checkout_form').on('submit', function(e) {
        e.preventDefault();
        var delivery_opt = $('input[name=deliver]:checked').val();

        if (delivery_opt == 2) {
            if ($('#sf').val().length == 0) {
                $('#toast').addClass('active');
                $('.progress').addClass('active');
                $('.text-1').text('Error!');
                $('.text-2').text('Invalid pin address!');
                setTimeout(() => {
                    $('#toast').removeClass("active");
                    $('.progress').removeClass("active");
                }, 5000);
            } else {
                if ($.trim($('#fullname').val().length) == 0) {
                    $('.error-fullname').text('Input fullname!');
                } else {
                    $('.error-fullname').text('');
                }

                if ($.trim($('#phone_number').val()).length < 11) {
                    $('.error-phone_number').text('Complete phone number first!');
                } else {
                    $('.error-phone_number').text('');
                }

                if ($.trim($('#block').val().length) == 0) {
                    $('.error-block').text('Input Block No/Building/Street No!');
                } else {
                    $('.error-block').text('');
                }

                if ($.trim($('#province').val().length) == 0) {
                    $('.error-province').text('Input Province!');
                } else {
                    $('.error-province').text('');
                }

                if ($.trim($('#city').val().length) == 0) {
                    $('.error-city').text('Input City!');
                } else {
                    $('.error-city').text('');
                }

                if ($.trim($('#barangay').val().length) == 0) {
                    $('.error-barangay').text('Input barangay!');
                } else {
                    $('.error-barangay').text('');
                }

                if ($('.gcash_payment').css("display") == "flex") {
                    if ($.trim($('#screenshot').val().length) == 0) {
                        $('.error-screenshot').text('Upload payment screenshot!');
                    } else {
                        var imgExt = $('#screenshot').val().split('.').pop().toLowerCase();

                        if ($.inArray(imgExt, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                            $('.error-screenshot').text('File not supported');
                        } else {
                            var imgSize = $('#screenshot')[0].files[0].size;

                            if (imgSize > 10485760) {
                                $('.error-screenshot').text('File too large');
                            } else {
                                $('.error-screenshot').text('');
                            }
                        }
                    }

                    if ($.trim($('#reference').val().length) == 0) {
                        $('.error-reference').text('Input reference!');
                    } else {
                        $('.error-reference').text('');
                    }
                } else {
                    $('.error-screenshot').text('');
                    $('.error-reference').text('');
                }

                if ($('.error-fullname').text() != '' || $('.error-phone_number').text() != '' || $(
                        '.error-block').text() != '' || $('.error-province').text() != '' || $('.error-city')
                    .text() != '' || $('.error-barangay').text() != '' || $('.error-screenshot').text() != '' ||
                    $('.error-reference').text() != '') {
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
                    // form.append('province_value', $('#province option:selected').text());
                    // form.append('city_value', $('#city option:selected').text());
                    // form.append('barangay_value', $('#barangay option:selected').text());
                    form.append('checkout_process', true);
                    $.ajax({
                        type: "POST",
                        url: "./functions/crud/cart",
                        data: form,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            if (response == 'success') {
                                window.location.href = "index";
                            }
                            console.log(response);
                        }
                    })
                }
            }
        } else if (delivery_opt == 1) {
            if ($.trim($('#fullname').val().length) == 0) {
                $('.error-fullname').text('Input fullname!');
            } else {
                $('.error-fullname').text('');
            }

            if ($.trim($('#phone_number').val()).length < 11) {
                $('.error-phone_number').text('Complete phone number first!');
            } else {
                $('.error-phone_number').text('');
            }

            if ($('.gcash_payment').css("display") == "flex") {
                if ($.trim($('#screenshot').val().length) == 0) {
                    $('.error-screenshot').text('Upload payment screenshot!');
                } else {
                    var imgExt = $('#screenshot').val().split('.').pop().toLowerCase();

                    if ($.inArray(imgExt, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                        $('.error-screenshot').text('File not supported');
                    } else {
                        var imgSize = $('#screenshot')[0].files[0].size;

                        if (imgSize > 10485760) {
                            $('.error-screenshot').text('File too large');
                        } else {
                            $('.error-screenshot').text('');
                        }
                    }
                }

                if ($.trim($('#reference').val().length) == 0) {
                    $('.error-reference').text('Input reference!');
                } else {
                    $('.error-reference').text('');
                }
            } else {
                $('.error-screenshot').text('');
            }

            if ($('.error-fullname').text() != '' || $('.error-phone_number').text() != '' || $(
                    '.error-screenshot').text() != '' || $('.error-reference').text() != '') {
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
                form.append('checkout_process', true);
                $.ajax({
                    type: "POST",
                    url: "./functions/crud/cart",
                    data: form,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response == 'success') {
                            window.location.href = "index";
                        }
                        console.log(response);
                    }
                })
            }
        } else {
            if ($.trim($('#fullname').val().length) == 0) {
                $('.error-fullname').text('Input fullname!');
            } else {
                $('.error-fullname').text('');
            }

            if ($.trim($('#phone_number').val()).length < 11) {
                $('.error-phone_number').text('Complete phone number first!');
            } else {
                $('.error-phone_number').text('');
            }

            if ($.trim($('#block').val().length) == 0) {
                $('.error-block').text('Input Block No/Building/Street No!');
            } else {
                $('.error-block').text('');
            }

            if ($.trim($('#province').val().length) == 0) {
                $('.error-province').text('Input Province!');
            } else {
                $('.error-province').text('');
            }

            if ($.trim($('#city').val().length) == 0) {
                $('.error-city').text('Input City!');
            } else {
                $('.error-city').text('');
            }

            if ($.trim($('#barangay').val().length) == 0) {
                $('.error-barangay').text('Input barangay!');
            } else {
                $('.error-barangay').text('');
            }

            if ($('.gcash_payment').css("display") == "flex") {
                if ($.trim($('#screenshot').val().length) == 0) {
                    $('.error-screenshot').text('Upload payment screenshot!');
                } else {
                    var imgExt = $('#screenshot').val().split('.').pop().toLowerCase();

                    if ($.inArray(imgExt, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                        $('.error-screenshot').text('File not supported');
                    } else {
                        var imgSize = $('#screenshot')[0].files[0].size;

                        if (imgSize > 10485760) {
                            $('.error-screenshot').text('File too large');
                        } else {
                            $('.error-screenshot').text('');
                        }
                    }
                }

                if ($.trim($('#reference').val().length) == 0) {
                    $('.error-reference').text('Input reference!');
                } else {
                    $('.error-reference').text('');
                }
            } else {
                $('.error-screenshot').text('');
                $('.error-reference').text('');
            }

            if ($('.error-fullname').text() != '' || $('.error-phone_number').text() != '' || $('.error-block')
                .text() != '' || $('.error-province').text() != '' || $('.error-city').text() != '' || $(
                    '.error-barangay').text() != '' || $('.error-screenshot').text() != '' || $(
                    '.error-reference').text() != '') {
                $('#toast').addClass('active');
                $('.progress').addClass('active');
                $('.text-1').text('Error!');
                $('.text-2').text('Fill all required fields!');
                setTimeout(() => {
                    $('#toast').removeClass("active");
                    $('.progress').removeClass("active");
                }, 5000);
            } else {
                $('#province').attr('disabled', 'false');
                $('#city').attr('disabled', 'false');
                $('#barangay').attr('disabled', 'false');
                var form = new FormData(this);
                form.append('checkout_process', true);
                $.ajax({
                    type: "POST",
                    url: "./functions/crud/cart",
                    data: form,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#province').attr('disabled', 'false');
                        $('#city').attr('disabled', 'false');
                        $('#barangay').attr('disabled', 'false');
                        $(':input[type="submit"]').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response == 'success') {
                            window.location.href = "index";
                        }
                        console.log(response);
                    }
                })
            }
        }

    });

    var map = new maplibregl.Map({
        container: 'map', // container id
        style: 'https://api.maptiler.com/maps/streets-v2/style.json?key=FhKrOmteMEqBErh5pfgf', // style URL
        center: [120.9881286, 14.4370461], // starting position [lng, lat]
        zoom: 15 // starting zoom
    });

    var marker = new maplibregl.Marker({
            color: "#FFAF08",
            scale: 1.2,
            draggable: true
        })
        .setLngLat([120.9881286, 14.4370461])
        .addTo(map);

    map.addControl(new JawgPlaces.MapLibre({
        searchOnTyping: true,
        marker: {
            anchor: 'center',
            iconUrl: 'https://i.ibb.co/drNqF46/Untitled-2.png',
            show: true,
        }
    }));

    function onDragEnd() {
        var lngLat = marker.getLngLat();
        document.getElementById('lng').value = lngLat.lng;
        document.getElementById('lat').value = lngLat.lat;

        var longitude = lngLat.lng;
        var latitude = lngLat.lat;

        $.ajax({
            type: "POST",
            url: "./functions/crud/cart",
            data: {
                'map': true,
                'longitude': longitude,
                'latitude': latitude,
            },
            success: function(response) {
                var str = response;
                if (str.includes("Warning")) {
                    console.log('invalid address');
                    $('#sf').val('');
                    $('.shipping_fee').text('0.00');
                    var total_purchases = $('.total_purchases').text();
                    var shipping_fee = $('.shipping_fee').text();
                    var sum = parseFloat(total_purchases) + parseFloat(shipping_fee);
                } else {
                    $('#sf').val(response);
                    $('.shipping_fee').text(parseFloat(response).toFixed(2));
                    var total_purchases = $('.total_purchases').text();
                    var shipping_fee = $('.shipping_fee').text();
                    var sum = parseFloat(total_purchases) + parseFloat(shipping_fee);

                    $('.overall_total').text(parseFloat(sum).toFixed(2));
                    $('#order_total_val').val(parseFloat(sum).toFixed(2));
                    console.log(response);
                }
            }
        })
    }
    marker.on('dragend', onDragEnd);

    var bounds = [
        [120.939988, 14.386594], // [west, south]
        [121.058464, 14.498885] // [east, north]
    ];
    map.setMaxBounds(bounds);
    map.addControl(new NavigationControl());
    </script>
</body>

</html>