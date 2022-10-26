<?php
session_start();
require_once '../../../includes/database_conn.php';

if(isset($_REQUEST['day_id_edit'])) {
    $day_id = $_REQUEST['day_id_edit'];
    $get_day_info = mysqli_query($conn, "SELECT * FROM open_hours WHERE day_id = $day_id");

    $day_info_edit = array();
    foreach($get_day_info as $day_info) {
        if($day_info['open_hour'] == null) {
            $day_info_edit['day_id'] = $day_info['day_id'];
        } else {
            $open_hour = date('H:i', strtotime($day_info['open_hour']));
            $close_hour = date('H:i', strtotime($day_info['close_hour']));
            $day_info_edit['day_id'] = $day_info['day_id'];
            $day_info_edit['open_hour'] = $open_hour;
            $day_info_edit['close_hour'] = $close_hour;
        }
    }

    echo json_encode($day_info_edit);
}

if(isset($_REQUEST['day_id_remove'])) {
    $day_id = $_REQUEST['day_id_remove'];

    $update_open_hours = mysqli_query($conn, "UPDATE open_hours SET open_hour = NULL, close_hour = NULL WHERE day_id = $day_id");

    if($update_open_hours) {
        echo 'success';
    }
}

if(isset($_POST['update_open_hour_time'])) {

    $day_id = $_POST['day_id'];
    $open_hour = date('h:i A', strtotime($_POST['open_hour']));
    $close_hour = date('h:i A', strtotime($_POST['close_hour']));

    $update_open_hours = mysqli_query($conn, "UPDATE open_hours SET open_hour = '$open_hour', close_hour = '$close_hour' WHERE day_id = $day_id");

    if($update_open_hours) {
        echo 'success';
    }
}