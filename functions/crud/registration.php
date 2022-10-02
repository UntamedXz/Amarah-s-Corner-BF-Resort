<?php
session_start();
require_once '../../includes/database_conn.php';
use PHPMailer\PHPMailer\PHPMailer;

// REGISTER
$reg_name = mysqli_real_escape_string($conn, $_POST['reg-name']);
$reg_username = mysqli_real_escape_string($conn, $_POST['reg-username']);
$reg_email = mysqli_real_escape_string($conn, $_POST['reg-email']);
$reg_phone_number = mysqli_real_escape_string($conn, $_POST['reg-tel']);
$reg_gender = mysqli_real_escape_string($conn, $_POST['gender']);
$reg_bday = mysqli_real_escape_string($conn, $_POST['reg-bday']);
$reg_password = mysqli_real_escape_string($conn, $_POST['reg-password']);
$hashed_pass = password_hash($reg_password, PASSWORD_DEFAULT);
$vkey = md5(time() . $reg_username);

$checkRegEmail = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$reg_email' AND verified = 1");
$checkRegUsername = mysqli_query($conn, "SELECT * FROM customers WHERE username = '$reg_username' AND verified = 1");

if (mysqli_num_rows($checkRegUsername) > 0) {
    echo 'Username already exist!';
} else {
    if (mysqli_num_rows($checkRegEmail) > 0) {
        echo 'Email already exist!';
    } else {
        $insertReg = mysqli_query($conn, "INSERT INTO customers (name, username, email, password, phone_number, user_birthday, user_gender, vkey) VALUES ('$reg_name', '$reg_username', '$reg_email', '$hashed_pass', '$reg_phone_number', '$reg_bday', '$reg_gender', '$vkey')");
        if ($insertReg) {
            // echo 'Registered Successfully!';
            // Send Email

            $to = $reg_email;
            $subject = "Email Verification";
            $body = "<center>
            <img src='https://drive.google.com/file/d/1mkvBWVVMr2llD9e9Fs0UsIOWkhdnUc6J/view?usp=sharing' alt='' style='width: 250px;'>
        </center>
        <p>Click the button to register your account</p>
        <a style='background-color: #ffaf08; padding: 5px 10px; text-decoration: none; text-transform: uppercase; color: #070506; font-weight: 700;' href='http://localhost/theserve-amarah-s-corner-las-pinas/verify.php?vkey=$vkey'>Register Account</a>";
            $from = "untamedandromeda@gmail.com";
            $password = "qvphqsivkcgocaes";

            // Ignore from here
            require_once '../../includes/PHPMailer.php';
            require_once '../../includes/SMTP.php';
            require_once '../../includes/Exception.php';
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
                echo "Check email for verification!";
            } else {
                echo "Something is wrong: <br><br>" . $mail->ErrorInfo;
            }
        } else {
            echo 'Something went wrong!';
        }
    }
}
