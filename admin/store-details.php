<?php
require_once '../includes/database_conn.php';
?>

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