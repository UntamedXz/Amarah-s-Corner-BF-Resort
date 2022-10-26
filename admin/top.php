<div id="preloader"></div>

<!-- SIDEBAR -->
<section id="sidebar">
    <div class="logo__details">
        <img src="../assets/images/official_logo_crop.png" alt="logo">
        <h1>Amarah's Corner</h1>
    </div>
    <ul class="side-menu">
        <li><a href="index" class="active"><i class='bx bxs-dashboard icon'></i>Dashboard</a></li>
        <li class="divider" data-text="store">Store</li>
        <li>
            <a href="store-open-time"><i class='bx bxs-time icon'></i>Open Hours Time</a>
        </li>
        <li class="divider" data-text="social">Social</li>
        <li>
            <a href="updates"><i class='bx bx-edit icon'></i>Updates</a>
        </li>
        <li><a href="chatbot"><i class='bx bx-chat icon'></i>Chatbot</a></li>
        <li><a href="feedback-list"><i class='bx bx-chat icon'></i>Feedback</a></li>
        <li class="divider" data-text="categories">Categories</li>
        <li>
        <li><a href="category"><i class='bx bxs-category icon'></i>Category</a></li>
        <li><a href="subcategory"><i class='bx bxs-category-alt icon'></i>Sub Category</a></li>
        </li>
        <li class="divider" data-text="product">Product</li>
        <li>
        <li><a href="product"><i class='bx bxs-bowl-hot icon'></i>Products</a></li>
        <li class="divider" data-text="orders">orders</li>
        <li>
            <a href="order"><i class='bx bxs-cart icon'></i>Orders</a>
        </li>
        <li>
            <a href="order-pending"><i class='bx bxs-cart icon'></i>Pending</a>
        </li>
        <li>
            <a href="order-confirmed"><i class='bx bxs-cart icon'></i>Confirmed</a>
        </li>
        <li>
            <a href="order-preparing"><i class='bx bxs-cart icon'></i>Preparing</a>
        </li>
        <li>
            <a href="to-be-received"><i class='bx bxs-cart icon'></i>To be Received</a>
        </li>
        <li>
            <a href="order-delivered"><i class='bx bx-package icon'></i>Order Delivered</a>
        </li>
        <li>
            <a href="order-cancelled"><i class='bx bx-package icon'></i>Order Cancelled</a>
        </li>
        <li class="divider" data-text="settings">settings</li>
        <li>
            <a href="users"><i class='bx bxs-user-circle icon'></i>Users</a>
            <!-- <a href="#"><i class='bx bxs-palette icon'></i>Home Appearance</a>
            <a href="#"><i class='bx bxs-cog icon'></i>Admin Settings</a> -->
        </li>
    </ul>
</section>
<!-- SIDEBAR -->

<!-- NAVBAR -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class="bx bx-menu toggle-sidebar"></i>
        <form action="#" class="search-form">
            <div class="form-group">
                <input type="text" placeholder="Search here...">
                <i class="bx bx-search icon"></i>
            </div>
        </form>
        <div class="right">
            <div class="icons">
                <a href="#" id="search-btn" class="nav-link">
                    <i class="bx bx-search icon"></i>
                </a>
                <a href="#" class="nav-link notif">
                    <i class="bx bxs-bell"></i>
                    <span class="badge">5</span>
                    <ul class="notif-list">
                        <li>Hi</li>
                        <li>Gago</li>
                    </ul>
                </a>
            </div>
            <span class="divider"></span>
            <div class="profile">
                <img style="border: 2px solid #ffaf08;" id="profileIcon" src="">
                <ul class="profile-link">
                    <li><a href="profile"><i class="bx bxs-user-circle icon"></i>Profile</a></li>
                    <li><a href="./functions/logout"><i class="bx bxs-log-out-circle"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- NAVBAR -->

    <input type="hidden" id="profileIconCheck" value="<?php echo $userProfileIcon; ?>">

    <script>
        $(window).on('load', function() {
            if($('#profileIconCheck').val() == '') {
                $('#profileIcon').attr("src","../assets/images/no_profile_pic.png");
            } else {
                $('#profileIcon').attr("src","../assets/images/" + $('#profileIconCheck').val());
            }
        })

        const bell = document.querySelector('.bxs-bell');
        const notif_list = document.querySelector('.notif-list');

        bell.addEventListener('click', function() {
            notif_list.classList.toggle('show');
        })
    </script>

    <div id="overlay" class="hide"></div>