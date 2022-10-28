<?php
require_once '../includes/database_conn.php';
?>

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