<?php
session_start();
require_once "./includes/database_conn.php";

$product_link = $_GET['link'];
$id = $_GET['id'];

$product_id = $_GET['id'];

if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    $user_id = '';
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
    <title>Amarah's Corner - BF Resort Las Piñas</title>

    <style>
    body {
        background: url(./assets/images/background.png) no-repeat;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 100vh;
    }
    </style>
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
    if(isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        if($alert == 'success') {
            echo "
            <script>
                $('#toast').addClass('active');
                $('.progress').addClass('active');
                $('#toast-icon').removeClass('fa-solid fa-triangle-exclamation').addClass('fa-solid fa-check warning');
                $('.text-1').text('Success!');
                $('.text-2').text('Item added to cart successfully!');
                setTimeout(() => {
                $('#toast').removeClass('active');
                $('.progress').removeClass('active');
                }, 5000);
            </script>
            ";
            unset($_SESSION['alert']);
        }
    } else {
        $alert = '';
    }
    ?>

    <!-- MENU SECTION -->
    <section class="menu" id="menu">
        <h3 class="title-header">Menu</h3>
        <div class="menu__container">
            <div class="menu__wrapper swiper mySwiper">
                <div class="menu__content swiper-wrapper">
                <?php
                $get_category = mysqli_query($conn, "SELECT * FROM category");

                foreach ($get_category as $category_row) {
                $category = $category_row['category_id'];
                ?>
                    <a href="catalog?category=<?php echo $category . '&page=1'; ?>" class="menu__card swiper-slide">
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

    <form action="" id="cart">
        <?php
    $getProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_slug = '$product_link' AND product_id = $id");

    foreach ($getProduct as $row) {
    ?>
        <section class="product-details">
            <div class="product-details__wrapper">
                <div class="left">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $row['product_id']; ?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                    <?php
                if (!empty($row['product_img1'])) {
                ?>
                    <div class="img-container">
                        <img src="./assets/images/<?php echo $row['product_img1']; ?>" alt="">
                    </div>
                    <?php
                } else {
                ?>
                    <div class="no-img-container">
                        <img src="./assets/images/image_not_available-yellow.png" alt="">
                    </div>
                    <?php
                }
                ?>
                    <div class="product-details">
                        <h1 class="product-title">
                            <?php echo $row['product_title']; ?>
                        </h1>
                        <span class="price"><b>P<span class="priceValue"><?php echo $row['product_price']; ?></span>
                            </b></span>
                        <span class="desc">
                            <?php
                            echo ucwords($row['product_desc']);
                        ?>
                        </span>
                    </div>
                </div>
                <div class="right">
                    <?php
                $get_attribute_info = mysqli_query($conn, "SELECT * FROM product_attribute WHERE product_id = $product_id");
                $get_category_id = mysqli_query($conn, "SELECT category_id FROM product WHERE product_id = $product_id");

                $fetched_category_id = mysqli_fetch_array($get_category_id);
                $category_id = $fetched_category_id['category_id'];

                $get_category_name = mysqli_query($conn, "SELECT * FROM category WHERE category_id = $category_id");

                $fetched_category_name = mysqli_fetch_array($get_category_name);
                $category_name = $fetched_category_name['category_title'];

                foreach($get_attribute_info as $attr_info) {
                    $attribute_id = $attr_info['attribute_id'];
                    
                ?>
                    <div class="form-group variation">
                        <span class="<?php echo $attr_info['attribute_id']; ?>">Choose your <?php echo $category_name . " " . $attr_info['attribute_name']; ?></span>
                        <div class="radio-tile-group">
                            <?php
                        $get_variation_info = mysqli_query($conn, "SELECT * FROM product_variation WHERE product_id = $product_id AND attribute_id = $attribute_id AND product_price IS NOT NULL");
                        
                        if(mysqli_num_rows($get_variation_info) > 0) {
                            foreach($get_variation_info as $variation_info) {
                            ?>
                                <div class="input-container">
                                    <input class="attribute" data-price="<?php echo $variation_info['product_price']; ?>"
                                        type="radio" name="radio[<?php echo $variation_info['attribute_id']; ?>]"
                                        id="<?php echo $variation_info['variation_id']; ?>"
                                        value="<?php echo $attr_info['attribute_name'] . ': ' . $variation_info['variation_value'];?>"
                                        required>
                                    <div class="radio-tile">
                                        <label
                                            for="<?php echo $variation_info['variation_id']; ?>"><?php echo $variation_info['variation_value']; ?></label>
                                        <span class="price">P <span
                                                class="each_price"><?php echo $variation_info['product_price']; ?></span></span>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <script>
                                $('.<?php echo $attr_info['attribute_id']; ?>').css('display', 'none');
                            </script>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                    <div class="form-group">
                        <span>Special Instructions (Optional)</span>
                        <textarea class="instruction" type="text" name="special_instructions"
                            id="special_instructions"></textarea>
                    </div>
                </div>
            </div>
        </section>
        <?php
}
?>

        <div class="product-footer">
            <div class="product-footer__wrapper">
                <div class="qty-container">
                    <div class="prev qtyBtn">-</div>
                    <div class="next qtyBtn">+</div>
                    <input class="number-spinner" type="number" name="qty" id="qty" value="1" min="1">
                </div>
                <div class="total-box">
                    <div class="total">
                        <span class="totalText">Total</span>
                        <span class="totalPrice">P<span class="totalPriceSpan"></span></span>
                    </div>
                    <div class="btn-container">
                        <button type="submit" id="addToCart">ADD TO CART</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <?php include './includes/cart-count.php' ?>
    <script src="./assets/js/script.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('.prev').on('click', function() {
            var prev = $(this).closest('.qty-container').find('input').val();

            if (prev == 1) {
                var a = 1;
                $(this).closest('.qty-container').find('input').val(a);
            } else {
                var prevVal = prev - 1;
                $(this).closest('.qty-container').find('input').val(prevVal);
            }
        });

        $('.next').on('click', function() {
            var next = $(this).closest('.qty-container').find('input').val();

            if (next == 100) {
                $(this).closest('.qty-container').find('input').val('100');
            } else {
                var nextVal = ++next;
                $(this).closest('.qty-container').find('input').val(nextVal);
            }
        });

        $(document).on("change", ".attribute", function() {
            var sum = 0;
            $(".attribute:checked").each(function() {
                sum += +$(this).data('price');
            })
            $('.priceValue').text(parseFloat(sum).toFixed(2));

            var qty = parseFloat($('.number-spinner').val()).toFixed(2);
            var multiply = qty * sum;
            $('.totalPriceSpan').text(parseFloat(multiply).toFixed(2));
        })

        $(".qtyBtn").on('click', function() {
            var total = parseFloat($('.number-spinner').val()).toFixed(2);
            var price = parseFloat($('.priceValue').text()).toFixed(2);

            var sum = parseFloat(total * price).toFixed(2);
            $('.totalPriceSpan').text(sum);
        });

        $('.totalPriceSpan').text($('.priceValue').text());
    })
    </script>

    <script>
    $('#cart').on('submit', function(e) {
        e.preventDefault();
        var userId = $('#user_id').val();
        var price_value = $('.priceValue').text();
        // var product_id = $('#product_id').val();
        // var qty = $('.number-spinner').val();
        var form = new FormData(this);
        var total = $('.totalPriceSpan').text();
        form.append('total', total);
        form.append('price_value', price_value);
        form.append('add_to_cart', true);

        if (userId == '') {
            <?php
                $_SESSION['link_user'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" :
                    "http").
                "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
                ?>
            location.href = 'http://localhost/theserve-amarah-s-corner-bf-resort/login';
        } else {
            $.ajax({
                type: "POST",
                url: "./functions/crud/cart",
                data: form,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response == 'success') {
                        location.reload();
                    }
                    console.log(response);
                }
            })
        }
    })
    </script>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 'auto',
        spaceBetween: 15,
        centeredSlides: true,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    </script>

    <script>
    var loader = document.getElementById("preloader");

    window.addEventListener("load", function() {
        loader.style.display = "none";
    })

    $('select.dropdown').each(function() {

        var dropdown = $('<div />').addClass('dropdown selectDropdown');

        $(this).wrap(dropdown);

        var label = $('<span />').text($(this).attr('placeholder')).insertAfter($(this));
        var list = $('<ul />');

        $(this).find('option').each(function() {
            list.append($('<li />').append($('<a />').text($(this).text())));
        });

        list.insertAfter($(this));

        if ($(this).find('option:selected').length) {
            label.text($(this).find('option:selected').text());
            list.find('li:contains(' + $(this).find('option:selected').text() + ')').addClass('active');
            $(this).parent().addClass('filled');
        }

    });

    $(document).on('click touch', '.selectDropdown ul li a', function(e) {
        e.preventDefault();
        var dropdown = $(this).parent().parent().parent();
        var active = $(this).parent().hasClass('active');
        var label = active ? dropdown.find('select').attr('placeholder') : $(this).text();

        dropdown.find('option').prop('selected', false);
        dropdown.find('ul li').removeClass('active');

        dropdown.toggleClass('filled', !active);
        dropdown.children('span').text(label);

        if (!active) {
            dropdown.find('option:contains(' + $(this).text() + ')').prop('selected', true);
            $(this).parent().addClass('active');
        }

        dropdown.removeClass('open');
    });

    $('.dropdown > span').on('click touch', function(e) {
        var self = $(this).parent();
        self.toggleClass('open');
    });

    $(document).on('click touch', function(e) {
        var dropdown = $('.dropdown');
        if (dropdown !== e.target && !dropdown.has(e.target).length) {
            dropdown.removeClass('open');
        }
    });

    // light
    $('.switch input').on('change', function(e) {
        $('.dropdown, body').toggleClass('light', $(this).is(':checked'));
    });
    </script>
</body>

</html>