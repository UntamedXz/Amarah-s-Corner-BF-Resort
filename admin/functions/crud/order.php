<?php
session_start();
require_once '../../../includes/database_conn.php';

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    $checkOrder = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = $order_id");

    $encryptedId = urlencode(base64_encode($order_id));

    if(mysqli_num_rows($checkOrder) > 0) {
        echo "view-edit-orders?id=" . $encryptedId;
    }
}

if(isset($_POST['delete_order'])) {
    if (!empty($_POST['delete_order_id'])) {
        $delete_order = $_POST['delete_order_id'];
    
        $get_order = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = $delete_order");
    
        $screenshot = '';
    
        while ($row = mysqli_fetch_array($get_order)) {
            $screenshot = $row['screenshot_payment'];
        }
    
        if (!empty($screenshot)) {
            $delete_order = mysqli_query($conn, "DELETE FROM orders WHERE order_id = $delete_order");
    
            if ($delete_order) {
                echo 'deleted';
                unlink('../../assets/images/' . $screenshot);
            }
        } else {
            $delete_order = mysqli_query($conn, "DELETE FROM orders WHERE order_id = $delete_order");
    
            if ($delete_order) {
                echo 'deleted';
            }
        }
    }    
}