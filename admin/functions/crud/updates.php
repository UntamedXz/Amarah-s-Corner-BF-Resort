<?php
session_start();
require_once '../../../includes/database_conn.php';

if (isset($_REQUEST['updates_id'])) {
    $updates_id = $_REQUEST['updates_id'];
    $get_updates = mysqli_query($conn, "SELECT * FROM updates WHERE updates_id = '$updates_id'");

    $result_array = array();
    while ($result = mysqli_fetch_assoc($get_updates)) {
        $result_array['updates_id'] = $result['updates_id'];
        $result_array['updates_text'] = $result['updates_text'];
        $result_array['updates_image'] = $result['updates_image'];
        $result_array['updates_date'] = $result['updates_date'];
    }

    echo json_encode($result_array);
}

if(isset($_POST['update_updates'])) {
    $update_id = $_POST['update_updates_id'];
    $update_text = mysqli_real_escape_string($conn, $_POST['update_updates_text']);
    $update_image = $_FILES['update_updates_image']['name'];
    $update_image_tmp = $_FILES['update_updates_image']['tmp_name'];

    $get_old_update = mysqli_query($conn, "SELECT * FROM updates WHERE updates_id = $update_id");

    $row = mysqli_fetch_array($get_old_update);

    $old_image = $row['updates_image'];

    if($_FILES['update_updates_image']['error'] == 4) {
        $updates_update = mysqli_query($conn, "UPDATE updates SET updates_text = '$update_text' WHERE updates_id = $update_id");

        if($updates_update) {
            echo 'success';
        }
    } else {
        $imgExt = explode('.', $update_image);
        $imgExt = strtolower(end($imgExt));

        $newImageName = uniqid() . '.' . $imgExt;

        move_uploaded_file($update_image_tmp, '../../../assets/images/' . $newImageName);

        $updates_update = mysqli_query($conn, "UPDATE updates SET updates_text = '$update_text', updates_image = '$newImageName' WHERE updates_id = $update_id");

        unlink('../../../assets/images/' . $old_image);

        if($updates_update) {
            echo 'success';
        }
    }
}

if(isset($_POST['insert_updates'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date('F j, Y');
    $updates_text = mysqli_real_escape_string($conn, $_POST['updates_text']);
    $updates_image = $_FILES['updates_image']['name'];
    $updates_image_tmp = $_FILES['updates_image']['tmp_name'];

    $imgExt = explode('.', $updates_image);
    $imgExt = strtolower(end($imgExt));

    $newImageName = uniqid() . '.' . $imgExt;

    move_uploaded_file($updates_image_tmp, '../../../assets/images/' . $newImageName);

    $insert_updates = mysqli_query($conn, "INSERT INTO updates (updates_text, updates_image, updates_date) VALUES ('$updates_text', '$newImageName', '$date')");

    if($insert_updates) {
        echo 'success';
    }
}

if(isset($_POST['delete_updates'])) {
    $updates_id = $_POST['delete_updates'];

    $get_updates = mysqli_query($conn, "SELECT * FROM updates WHERE updates_id = $updates_id");

        $updates_image = '';

        while($row = mysqli_fetch_array($get_updates)) {
            $updates_image = $row['updates_image'];
        }

    $delete_updates = mysqli_query($conn, "DELETE FROM updates WHERE updates_id = $updates_id");

    if($delete_updates) {
        echo 'success';
        unlink('../../../assets/images/' . $updates_image);
    }
}