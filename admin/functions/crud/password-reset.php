<?php
session_start();
require_once '../../../includes/database_conn.php';
use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['password_reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $vkey = md5(rand());

    $get_info = mysqli_query($conn, "SELECT * FROM admin WHERE admin_email = '$email' LIMIT 1");

    if(mysqli_num_rows($get_info) > 0) {
        $row = mysqli_fetch_array($get_info);

        $get_name = $row['admin_name'];
        $get_email = $row['admin_email'];

        $update_vkey = mysqli_query($conn, "UPDATE admin SET vkey = '$vkey' WHERE admin_email = '$get_email' LIMIT 1");

        if($update_vkey) {
            $to = $get_email;
            $subject = "Password reset link";
            $body = "<center>
            <img src='./assets/images/official_logo_crop.png' alt='' style='width: 250px;'>
        </center>
        <p>Click the button to reset your password</p>
        <a style='background-color: #ffaf08; padding: 5px 10px; text-decoration: none; text-transform: uppercase; color: #070506; font-weight: 700;' href='http://localhost/theserve-amarah-s-corner-las-pinas/admin/password-change?vkey=$vkey&email=$get_email'>Reset Password</a>";
            $from = "untamedandromeda@gmail.com";
            $password = "qvphqsivkcgocaes";

            // Ignore from here
            require_once '../../../includes/PHPMailer.php';
            require_once '../../../includes/SMTP.php';
            require_once '../../../includes/Exception.php';
            $mail = new PHPMailer();

            // To Here

            //SMTP Settings
            $mail->isSMTP();
            // $mail->SMTPDebug = 3;  Keep It commented this is used for debugging
            $mail->Host = "smtp.gmail.com"; // smtp address of your email
            $mail->SMTPAuth = true;
            $mail->Username = $from;
            $mail->Password = $password;
            $mail->Port = 587; // port
            $mail->SMTPSecure = "tls"; // tls or ssl
            $mail->smtpConnect([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]);

            //Email Settings
            $mail->isHTML(true);
            $mail->setFrom($from);
            $mail->addAddress($to); // enter email address whom you want to send
            $mail->Subject = ("$subject");
            $mail->Body = $body;
            if ($mail->send()) {
                echo "Check email for password link!";
            } else {
                echo "Something is wrong: <br><br>" . $mail->ErrorInfo;
            }
        } else {
            echo 'Something went wrong!';
        }
    } else {
        echo 'No email found!';
    }
}