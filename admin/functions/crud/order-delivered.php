<?php
session_start();
require_once '../../../includes/database_conn.php';

if (isset($_POST['order_id_view'])) {
    $order_id_view = $_POST['order_id_view'];

    $checkOrder = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = $order_id_view");

    $encryptedId = urlencode(base64_encode($order_id_view));

    if(mysqli_num_rows($checkOrder) > 0) {
        echo "view-order-delivered?id=" . $encryptedId;
    }
}