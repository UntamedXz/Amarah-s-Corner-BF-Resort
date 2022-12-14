<!-- BACKGROUND OVERLAY -->
<div id="backgroundOverlay"></div>
<header class="header">
    <!-- NAVIGATION BAR 1 -->
    <div class="header-1">
        <a href="#" class="logo"><img src="./assets/images/official_logo.png" alt=""></a>
        <form action="#" class="search-form" id="search_form">
            <input type="text" name="search-input" id="search-input" placeholder="search here..." value="<?php if(isset($_GET['search'])) { echo $_GET['search']; } ?>">
            <label for="search-input" class="bx bx-search-alt-2"></label>
        </form>
        <div class="left">
            <div id="search-btn" class="bx bx-search-alt-2"></div>
            <a href="cart" class="nav-link">
                <i class="bx bxs-cart"></i>
                <span class="badge"></span>
            </a>
            <a href="login" id="login-btn" class="bx bxs-user loginBtn"></a>
            <div id="navbar" class="bx bx-menu-alt-right"></div>
            <div class="profile">
                <img id="profileIcon" src="" alt="">
                <ul class="profile-link">
                    <li><a href="account"><i class="fa-solid fa-circle-user"></i>Profile</a></li>

                    <li><a href="order?page=1"><i class="fa-solid fa-clock icon"></i>Orders</a></li>

                    <li><a href="./includes/logout"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- NAVIGATION BAR 2 -->
<nav class="custom-nav">
    <a href="index">home</a>
    <a href="index#menu">menu</a>
    <a href="index#updates">updates</a>
    <a href="index#feedbacks">feedback</a>
    <a href="index#footer">contact</a>
</nav>
<!-- MOBILE NAVIGATION MENU -->
<nav class="dropdown-nav">
    <div class="bx bxs-x-square" id="close-menu"></div>
    <a href="http://localhost/theserve-amarah-s-corner-las-pinas">home</a>
    <a href="index#menu">menu</a>
    <a href="index#updates">updates</a>
    <a href="index#feedbacks">feedback</a>
    <a href="index#footer">contact</a>
</nav>

<div class="tracking_wrapper">
    <span class="track_title">TRACK YOUR ORDER</span>
    <span class="error-all" style="color: #dc3545; font-weight: 600; font-size: 13px;"></span>
    <form id="tracking_form">
        <div class="form_group">
            <span>Email</span>
            <input type="email" id="email" name="email" required>
            <span class="error-email" style="color: #dc3545; font-weight: 600; font-size: 13px;"></span>
        </div>
        <div class="form_group">
            <span>Order ID</span>
            <input type="text" id="order-id" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                name="order-id" required>
            <span class="error-order-id" style="color: #dc3545; font-weight: 600; font-size: 13px;"></span>
        </div>
        <button form="tracking_form" type="submit">TRACK MY ORDER</button>
    </form>
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

<script>
$('#search_form').on('submit', function(e) {
    e.preventDefault();
    var search_input = $('#search-input').val();

    if (search_input != undefined && search_input != null) {
        window.location = 'search-result?search=' + search_input;
    }
})

// PROFILE DROPDOWN
const profile = document.querySelector('.profile');
const bell = document.querySelector('.notif');
const imgProfile = profile.querySelector('img');
const dropdownProfile = profile.querySelector('.profile-link');
const dropdownNotif = profile.querySelector('.notif-list');

imgProfile.addEventListener('click', function() {
    dropdownProfile.classList.toggle('show');
})

bell.addEventListener('click', function() {
    dropdownNotif.classList.toggle('show');
})

window.addEventListener('click', function(e) {
    if (e.target !== imgProfile) {
        if (e.target !== dropdownProfile) {
            if (dropdownProfile.classList.contains('show')) {
                dropdownProfile.classList.remove('show');
            }
        }
    }
})

const tracking = document.querySelector('#tracking');
const tracking_form = document.querySelector('.tracking_wrapper');

tracking.addEventListener('click', function() {
    tracking_form.classList.add('active');
    document.getElementById('backgroundOverlay').classList.add('active');
    document.querySelector('.search-form').classList.remove('active');
})

document.getElementById('backgroundOverlay').addEventListener('click', function() {
    document.getElementById('backgroundOverlay').classList.remove('active');
    tracking_form.classList.remove('active');
})

$('.close').on('click', function(e) {
    $('#toast').removeClass("active");
    $('.progress').removeClass("active");
})

$('#tracking_form').on('submit', function(e) {
    e.preventDefault();
    var form = new FormData(this);
    form.append('check_tracking', true);
    $.ajax({
        type: "POST",
        url: "./functions/crud/cart",
        contentType: false,
        cache: false,
        processData: false,
        data: form,
        success: function(response) {
            var str = response;
            if (str.includes("your-order?id")) {
                location.href = response;
                console.log(response);
            } else {
                $('.error-all').text('Invalid credentials!');
            }
        }
    })
})
</script>

<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
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



<?php include './includes/cart-count.php' ?>