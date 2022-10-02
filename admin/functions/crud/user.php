<?php
session_start();
require_once '../../../includes/database_conn.php';

if(isset($_POST['insert_user'])) {
    $admin_name = mysqli_real_escape_string($conn, $_POST['insert_admin_name']);
    $admin_username = mysqli_real_escape_string($conn, $_POST['insert_admin_username']);
    $admin_password = mysqli_real_escape_string($conn, $_POST['insert_admin_password']);
    $admin_type = $_POST['admin_type'];
    $hashed_pass = password_hash($admin_password, PASSWORD_DEFAULT);

    $insert_user = mysqli_query($conn, "INSERT INTO admin (admin_name, admin_username, admin_password, admin_type) VALUES ('$admin_name', '$admin_username', '$hashed_pass', '$admin_type')");

    if($insert_user) {
        echo 'success';
    }
}

if(isset($_POST['delete_user'])) {
    $admin_id = $_POST['delete_admin_id'];
    $admin_id_loggedin = $_POST['admin_id'];

    if ($admin_id == $admin_id_loggedin) {
        echo 'failed';
    } else {
        $get_old_info = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = $admin_id");

        $row = mysqli_fetch_array($get_old_info);

        $image = $row['profile_image'];

        if ($image != '') {
            $delete_admin = mysqli_query($conn, "DELETE FROM admin WHERE admin_id = $admin_id");

            unlink('../../../assets/images/' . $image);
        } else {
            $delete_admin = mysqli_query($conn, "DELETE FROM admin WHERE admin_id = $admin_id");
        }

        if ($delete_admin) {
            echo 'success';
        }
    }
}