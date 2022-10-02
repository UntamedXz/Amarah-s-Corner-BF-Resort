<?php
session_start();
require_once '../../../includes/database_conn.php';

if(isset($_POST['delete'])) {
    $adminId = $_POST['admin_id'];
    $OldProfileImg = $_POST['OldProfileImg'];

    $deleteProfileImg = mysqli_query($conn, "UPDATE admin SET profile_image = NULL WHERE admin_id = $adminId");

    unlink('../../../assets/images/' . $OldProfileImg);

    if($deleteProfileImg) {
        echo 'success';
    }
}

if(isset($_POST['update_profile_picture'])) {
    $image = $_FILES['profile_pic']['name'];
    $image_tmp = $_FILES['profile_pic']['tmp_name'];
    $oldImage = $_POST['old_profile_pic'];
    $adminId = $_POST['admin_id'];

    $checkAdminInfo = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = $adminId");

    $row = mysqli_fetch_array($checkAdminInfo);

    $oldImgDatabase = $row['profile_image'];

    if($oldImgDatabase == '') {
        $imgExt = explode('.', $image);
        $imgExt = strtolower(end($imgExt));

        $newImageName = uniqid() . '.' . $imgExt;
        move_uploaded_file($image_tmp, '../../../assets/images/' . $newImageName);

        $updateProfileImg = mysqli_query($conn, "UPDATE admin SET profile_image = '$newImageName' WHERE admin_id = $adminId");

        if($updateProfileImg) {
            echo 'success';
        }
    } else {
        $imgExt = explode('.', $image);
        $imgExt = strtolower(end($imgExt));

        $newImageName = uniqid() . '.' . $imgExt;
        move_uploaded_file($image_tmp, '../../assets/images/' . $newImageName);
        unlink('../../../assets/images/' . $oldImageDatabase);

        $updateProfileImg = mysqli_query($conn, "UPDATE admin_id SET profile_image = '$newImageName' WHERE admin_id = $adminId");

        if($updateProfileImg) {
            echo 'success';
        }
    }
}

if(isset($_POST['update_profile_details'])) {
    $admin_id = $_POST['profile_details_id'];
    $name = ucwords(mysqli_real_escape_string($conn, $_POST['admin_name']));
    $username = mysqli_real_escape_string($conn, $_POST['admin_username']);

    $updateProfileDetails = mysqli_query($conn, "UPDATE admin SET admin_name = '$name', admin_username = '$username' WHERE admin_id = $admin_id");

    if($updateProfileDetails) {
        $_SESSION['admin_profile'] = 'success';
        echo 'success';
    }
}

if(isset($_POST['update_contact'])) {
    $admin_id = $_POST['profile_details_id'];
    $phone_num = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $email = mysqli_real_escape_string($conn, $_POST['contact-email']);

    $get_old_email = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = $admin_id");

    $row = mysqli_fetch_array($get_old_email);

    $old_email = $row['admin_email'];

    if($email == $old_email) {
        $updateContact = mysqli_query($conn, "UPDATE admin SET admin_phone_number = '$phone_num' WHERE admin_id = $admin_id");

        if($updateContact) {
            $_SESSION['admin_contact'] = 'success';
            echo 'success';
        }
    } else {
        $check_if_email_exist = mysqli_query($conn, "SELECT * FROM admin WHERE admin_email = '$email'");

        if(mysqli_num_rows($check_if_email_exist) > 0) {
            $_SESSION['admin_contact'] = 'failed';
            echo 'failed';
        } else {
            $updateContact = mysqli_query($conn, "UPDATE admin SET admin_phone_number = '$phone_num', admin_email = '$email' WHERE admin_id = $admin_id");

            if($updateContact) {
                $_SESSION['admin_contact'] = 'success';
                echo 'success';
            }
        }
    }
}

if(isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $admin_id = $_POST['password_id'];
    $new_hash_password = password_hash($new_password, PASSWORD_DEFAULT);

    $get_user_password = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = $admin_id");

    $row = mysqli_fetch_array($get_user_password);

    $user_old_password = $row['admin_password'];

    if(password_verify($old_password, $user_old_password)) {
        if($new_password == $confirm_password) {
            $update_password = mysqli_query($conn, "UPDATE admin SET admin_password = '$new_hash_password' WHERE admin_id = $admin_id");

            if($update_password) {
                $_SESSION['admin_password'] = 'success';
                echo 'success';
            }
        } else {
            echo 'password not matched!';
        }
    } else {
        echo 'wrong password';
    }
}