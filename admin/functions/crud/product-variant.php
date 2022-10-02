<?php
session_start();
require_once '../../../includes/database_conn.php';

if (isset($_POST['variant_id_edit'])) {
    $variantId = $_POST['variant_id_edit'];

    $getVariant = mysqli_query($conn, "SELECT * FROM product_variant WHERE variant_id = $variantId");

    $result_array = array();
    while ($result = mysqli_fetch_assoc($getVariant)) {
        $result_array['variant_id'] = $result['variant_id'];
        $result_array['variant_title'] = $result['variant_title'];
    }

    echo json_encode($result_array);
}

if(isset($_POST['update_product_variant'])) {
    $update_variant_id = $_POST['update_variant_id'];
    $update_variant_title = strtoupper(mysqli_real_escape_string($conn, $_POST['update_variant_title']));

    $check_variant_title = mysqli_query($conn, "SELECT * FROM product_variant WHERE variant_title = '$update_variant_title'");

    if(!empty($update_variant_title)) {
        if(mysqli_num_rows($check_variant_title) > 0) {
            $check_variant_title = mysqli_query($conn, "SELECT * FROM product_variant WHERE variant_title = '$update_variant_title' AND variant_id = $update_variant_id");
        
            if(mysqli_num_rows($check_variant_title) == 1) {
                echo 'success';
            } else {
                echo 'already exist';
            }
        } else {
            $insert_variant_title = mysqli_query($conn, "UPDATE product_variant SET variant_title = '$update_variant_title' WHERE variant_id = $update_variant_id");
        
            if($insert_variant_title) {
                echo 'success';
            }
        }
    } else {
        echo 'empty';
    }
}

if(isset($_POST['insert_product_variant'])) {
    if(empty($_POST['insert_variant_title'])) {
        echo 'empty field';
    } else {
        $variantTitle =  strtoupper($_POST['insert_variant_title']);
    
        $check = mysqli_query($conn, "SELECT * FROM product_variant WHERE variant_title = '$variantTitle'");
    
        if(mysqli_num_rows($check) > 0) {
            echo 'title already exist';
        } else {
            $insertVariant = mysqli_query($conn, "INSERT INTO product_variant VALUES ('', '$variantTitle')");
    
            if($insertVariant) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }
}

if(isset($_POST['delete_product_variant'])) {
    if(!empty($_POST['delete_variant_id'])) {
        $deleteVariantId = $_POST['delete_variant_id'];
    
        $deleteVariant = mysqli_query($conn, "DELETE FROM product_variant WHERE variant_id = $deleteVariantId");
    
        if($deleteVariant) {
            echo 'deleted';
        }
    }
}