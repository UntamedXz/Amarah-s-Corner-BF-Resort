<?php
require_once './includes/database_conn.php';
if(isset($_GET['vkey'])) {
    // Process Verification
    $vkey = $_GET['vkey'];

    $check_vkey = mysqli_query($conn, "SELECT verified, vkey FROM customers WHERE verified = 0 AND vkey = '$vkey' LIMIT 1");

    if(mysqli_num_rows($check_vkey) == 1) {
        // Validate email
        $update = mysqli_query($conn, "UPDATE customers SET verified = 1, vkey = NULL WHERE vkey = '$vkey' LIMIT 1");

        if($update) {
            header('location: verified');
        } else {
            echo 'Something went wrong.';
        }
    } else {
        echo "This account invalid or already verified";
    }
} else {
    die("Something went wrong!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>