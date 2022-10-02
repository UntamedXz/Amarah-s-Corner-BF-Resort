<?php 
session_start();
require_once '../../includes/database_conn.php';

if(isset($_POST['delete_image'])) {
    $userId = $_POST['user_id'];
    $OldProfileImg = $_POST['OldProfileImg'];

    $deleteProfileImg = mysqli_query($conn, "UPDATE customers SET user_profile_image = NULL WHERE user_id = $userId");

    unlink('../../assets/images/' . $OldProfileImg);

    if($deleteProfileImg) {
        echo 'success';
    }
}

if(isset($_POST['update_profile_picture'])) {
    $image = $_FILES['profile_pic']['name'];
    $image_tmp = $_FILES['profile_pic']['tmp_name'];
    $oldImage = $_POST['old_profile_pic'];
    $userId = $_POST['user_id'];

    $checkCustomerInfo = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $userId");

    $row = mysqli_fetch_array($checkCustomerInfo);

    $oldImgDatabase = $row['user_profile_image'];

    if($oldImgDatabase == '') {
        $imgExt = explode('.', $image);
        $imgExt = strtolower(end($imgExt));

        $newImageName = uniqid() . '.' . $imgExt;
        move_uploaded_file($image_tmp, '../../assets/images/' . $newImageName);

        $updateProfileImg = mysqli_query($conn, "UPDATE customers SET user_profile_image = '$newImageName' WHERE user_id = $userId");

        if($updateProfileImg) {
            echo 'success';
        }
    } else {
        $imgExt = explode('.', $image);
        $imgExt = strtolower(end($imgExt));

        $newImageName = uniqid() . '.' . $imgExt;
        move_uploaded_file($image_tmp, '../../assets/images/' . $newImageName);
        unlink('../assets/images/' . $oldImageDatabase);

        $updateProfileImg = mysqli_query($conn, "UPDATE customers SET user_profile_image = '$newImageName' user_id = $userId");

        if($updateProfileImg) {
            echo 'success';
        }
    }
}

if(isset($_POST['update_profile_details'])) {
    $user_id = $_POST['profile_details_id'];
    $name = ucwords(mysqli_real_escape_string($conn, $_POST['customer_name']));
    $username = mysqli_real_escape_string($conn, $_POST['customer_username']);
    $bday = mysqli_real_escape_string($conn, $_POST['customer_bday']);
    $gender = $_POST['gender'];

    $updateProfileDetails = mysqli_query($conn, "UPDATE customers SET name = '$name', username = '$username', user_birthday = '$bday', user_gender = '$gender' WHERE user_id = $user_id");

    if($updateProfileDetails) {
        $_SESSION['profile'] = 'success';
        echo 'success';
    }
}

if(isset($_POST['update_contact'])) {
    $user_id = $_POST['profile_details_id'];
    $phone_num = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $email = mysqli_real_escape_string($conn, $_POST['contact-email']);

    $get_old_email = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $user_id");

    $row = mysqli_fetch_array($get_old_email);

    $old_email = $row['email'];

    if($email == $old_email) {
        $updateContact = mysqli_query($conn, "UPDATE customers SET phone_number = '$phone_num' WHERE user_id = $user_id");

        if($updateContact) {
            $_SESSION['contact'] = 'success';
            echo 'success';
        }
    } else {
        $check_if_email_exist = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");

        if(mysqli_num_rows($check_if_email_exist) > 0) {
            $_SESSION['contact'] = 'failed';
            echo 'failed';
        } else {
            $updateContact = mysqli_query($conn, "UPDATE customers SET phone_number = '$phone_num', email = '$email' WHERE user_id = $user_id");

            if($updateContact) {
                $_SESSION['contact'] = 'success';
                echo 'success';
            }
        }
    }
}

if(isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_POST['password_id'];

    $get_user_password = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $user_id");

    $row = mysqli_fetch_array($get_user_password);

    $user_old_password = $row['password'];

    if(password_verify($old_password, $user_old_password)) {
        if($new_password == $confirm_password) {
            $update_password = mysqli_query($conn, "UPDATE customers SET password = '$hashed_password' WHERE user_id = $user_id");

            if($update_password) {
                $_SESSION['password'] = 'success';
                echo 'success';
            }
        } else {
            echo 'password not matched!';
        }
    } else {
        echo 'wrong password';
    }
}