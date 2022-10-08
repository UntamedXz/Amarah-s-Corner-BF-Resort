<?php
session_start();
require_once '../../includes/database_conn.php';

if(isset($_POST['submit_feedback'])) {
    $rate = $_POST['rate'];
    $email = $_POST['email'];
    $token = $_POST['token'];
    $comment = $_POST['comment'] ?? null;

    $check_token = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email' AND vkey = '$token' LIMIT 1");

    if(mysqli_num_rows($check_token) > 0) {
        $insert_feedback = mysqli_query($conn, "INSERT INTO feedback (email, quality_score, feedback) VALUES ('$email', '$rate', NULLIF('$comment', ''))");

        if($insert_feedback) {
            $remove_token = mysqli_query($conn, "UPDATE customers SET vkey = NULL WHERE email = '$email'");

            if($remove_token) {
                echo 'success';
            }
        } else {
            echo 'success';
        }
    } else {
        echo 'success';
    }
}