<?php
session_start();
require_once '../../../includes/database_conn.php';

if (isset($_REQUEST['id'])) {
    $feedback_id = $_REQUEST['id'];
    $get_feedback = mysqli_query($conn, "SELECT * FROM feedback WHERE id = '$id'");

    $result_array = array();
    while ($result = mysqli_fetch_assoc($get_feedback)) {
        $result_array['id'] = $result['id'];
        $result_array['email'] = $result['email'];
        $result_array['quality_score'] = $result['quality_score'];
        $result_array['customer_feedback'] = $result['customer_feedback'];
        }

    echo json_encode($result_array);
}

if(isset($_POST['delete_feedback'])) {
    $id = $_POST['delete_feedback'];

    $get_chat = mysqli_query($conn, "SELECT * FROM feedback WHERE id = $id");

    $delete_chat = mysqli_query($conn, "DELETE FROM feedback WHERE id = $id");

    if($delete_chat) {
        echo 'success';
        unlink('../../../assets/images/' . $updates_image);
    }
}                       