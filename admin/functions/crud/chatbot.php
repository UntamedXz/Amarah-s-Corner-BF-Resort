<?php
session_start();
require_once '../../../includes/database_conn.php';

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $get_chatbot = mysqli_query($conn, "SELECT * FROM chatbot WHERE id = '$id'");

    $result_array = array();
    while ($result = mysqli_fetch_assoc($get_chatbot)) {
        $result_array['id'] = $result['id'];
        $result_array['messages'] = $result['messages'];
        $result_array['response'] = $result['response'];
    }

    echo json_encode($result_array);
}


if(isset($_POST['update_chat'])) {
    $id = $_POST['id'];
    $messages = mysqli_real_escape_string($conn, $_POST['messages']);
    $response = mysqli_real_escape_string($conn, $_POST['reponse']);

    $get_old_update = mysqli_query($conn, "SELECT * FROM chatbot WHERE id = $id");

    $row = mysqli_fetch_array($get_old_update);

}

if(isset($_POST['add_chat'])) {
    $add_id = $_POST['add_id'];
    $add_messages = mysqli_real_escape_string($conn, $_POST['add_messages']);
    $add_response = mysqli_real_escape_string($conn, $_POST['add_reponse']);

    $get_old_update = mysqli_query($conn, "SELECT * FROM chatbot WHERE id = $add_id");

    $row = mysqli_fetch_array($get_old_update);

}
if(isset($_POST['delete_chat'])) {
    $id = $_POST['delete_chat'];

    $get_chat = mysqli_query($conn, "SELECT * FROM chatbot WHERE id = $id");

    $delete_chat = mysqli_query($conn, "DELETE FROM chatbot WHERE id = $id");

    if($delete_chat) {
        echo 'success';
    }
}                       