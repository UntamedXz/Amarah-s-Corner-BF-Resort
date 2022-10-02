<?php
session_start();
require_once '../../../includes/database_conn.php';

if(isset($_POST['password-change'])) {
    $vkey = $_POST['vkey'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    $get_info = mysqli_query($conn, "SELECT * FROM admin WHERE admin_email = '$email' AND vkey = '$vkey'");

    if(mysqli_num_rows($get_info) == 1) {
        $update_password = mysqli_query($conn, "UPDATE admin SET admin_password = '$hashed_pass' WHERE admin_email = '$email'");

        if($update_password) {
            echo 'Password updated successfully!';
        } else {
            echo 'Something went wrong!';
        }
    } else {
        echo 'Invalid token!';
    }
}
?>