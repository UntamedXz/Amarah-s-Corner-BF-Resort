<?php

require_once "../../includes/database_conn.php";

$get_new_orders = mysqli_query($conn, "SELECT * FROM orders WHERE notified = 0");

if(mysqli_num_rows($get_new_orders) > 0) {
    echo "New order!";
}