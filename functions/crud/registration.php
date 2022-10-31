<?php
session_start();
require_once '../../includes/database_conn.php';
require '../../vendor/autoload.php';

use SMSGatewayMe\Client\Model\SendMessageRequest;

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

$checkRegEmail = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$reg_email'");
$checkRegUsername = mysqli_query($conn, "SELECT * FROM customers WHERE username = '$reg_username'");

if (mysqli_num_rows($checkRegUsername) > 0) {
    if (mysqli_num_rows($checkRegEmail) > 0) {
        $check_email = mysqli_fetch_array($checkRegUsername);
        if($check_email['email'] == $reg_email) {
            if ($check_email['verified'] == 0) {
                $vkey_db = $check_email['vkey'];
                $body = [
                    'Messages' => [
                        [
                            'From' => [
                                'Email' => "amarahscorner.bfresort@gmail.com",
                                'Name' => "Amarah's Pizza Corner - BF Resort",
                            ],
                            'To' => [
                                [
                                    'Email' => "$reg_email",
                                    'Name' => "$reg_name",
                                ],
                            ],
                            'Subject' => "Email confirmation",
                            'HTMLPart' => '<style type="text/css">#outlook a { padding:0; }
                        body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
                        table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
                        img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
                        p { display:block;margin:13px 0; }</style><!--[if mso]>
                      <noscript>
                      <xml>
                      <o:OfficeDocumentSettings>
                        <o:AllowPNG/>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                      </xml>
                      </noscript>
                      <![endif]--><!--[if lte mso 11]>
                      <style type="text/css">
                        .mj-outlook-group-fix { width:100% !important; }
                      </style>
                      <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
              @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                      .mj-column-per-100 { width:100% !important; max-width: 100%; }
                    }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                    table.mj-full-width-mobile { width: 100% !important; }
                    td.mj-full-width-mobile { width: auto !important; }
                  }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 style="text-align:left; margin-top: 10px; margin-bottom: 10px; font-weight: normal;"><span style="font-size:23px;letter-spacing:normal;text-align:left;color:#000000;font-family:Poppins;"><b>Welcome to Amarah\'s Corner - BF Resort, ' . $reg_name . '</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: left; margin: 10px 0; margin-top: 10px;"><span style="line-height:22px;font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Poppins;">Only one more step to go!</span></p><p style="text-align: left; margin: 10px 0; margin-bottom: 10px;"><span style="line-height:22px;font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Poppins;">To verify your account information, just click the "Confirm email" button below to get started on savoring your food cravings with Amarah\'s Pizza Corner.</span></p></div></td></tr><tr><td align="left" vertical-align="middle" style="font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/verify.php?vkey=' . $vkey_db . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="font-size:14px;text-align:left;background-color:transparent;color:#070506;font-family:Poppins;">Confirm email</span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>',
                        ],
                    ],
                ];
    
                $ch = curl_init();
    
                curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json')
                );
                curl_setopt($ch, CURLOPT_USERPWD, "8ea9955361adc59aea3b7f23487b4e6d:72df21bb7f7cb69d689555039c4e3edf");
                $server_output = curl_exec($ch);
                curl_close($ch);
    
                $response = json_decode($server_output);
                if ($response->Messages[0]->Status == 'success') {
                    // Configure client
                    echo 'Check email for verification!';
                }
            } else {
                echo 'Email already exist!';
            }
        } else {
            echo 'Username already exist!';
        }
    }
} else {
    if (mysqli_num_rows($checkRegEmail) > 0) {
        $check_verified = mysqli_fetch_array($checkRegEmail);
        if ($check_verified['verified'] == 0) {
            $vkey_db = $check_verified['vkey'];
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "amarahscorner.bfresort@gmail.com",
                            'Name' => "Amarah's Pizza Corner - BF Resort",
                        ],
                        'To' => [
                            [
                                'Email' => "$reg_email",
                                'Name' => "$reg_name",
                            ],
                        ],
                        'Subject' => "Email confirmation",
                        'HTMLPart' => '<style type="text/css">#outlook a { padding:0; }
                    body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
                    table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
                    img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
                    p { display:block;margin:13px 0; }</style><!--[if mso]>
                  <noscript>
                  <xml>
                  <o:OfficeDocumentSettings>
                    <o:AllowPNG/>
                    <o:PixelsPerInch>96</o:PixelsPerInch>
                  </o:OfficeDocumentSettings>
                  </xml>
                  </noscript>
                  <![endif]--><!--[if lte mso 11]>
                  <style type="text/css">
                    .mj-outlook-group-fix { width:100% !important; }
                  </style>
                  <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
          @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                  .mj-column-per-100 { width:100% !important; max-width: 100%; }
                }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                table.mj-full-width-mobile { width: 100% !important; }
                td.mj-full-width-mobile { width: auto !important; }
              }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 style="text-align:left; margin-top: 10px; margin-bottom: 10px; font-weight: normal;"><span style="font-size:23px;letter-spacing:normal;text-align:left;color:#000000;font-family:Poppins;"><b>Welcome to Amarah\'s Corner - BF Resort, ' . $reg_name . '</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: left; margin: 10px 0; margin-top: 10px;"><span style="line-height:22px;font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Poppins;">Only one more step to go!</span></p><p style="text-align: left; margin: 10px 0; margin-bottom: 10px;"><span style="line-height:22px;font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Poppins;">To verify your account information, just click the "Confirm email" button below to get started on savoring your food cravings with Amarah\'s Pizza Corner.</span></p></div></td></tr><tr><td align="left" vertical-align="middle" style="font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/verify.php?vkey=' . $vkey_db . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="font-size:14px;text-align:left;background-color:transparent;color:#070506;font-family:Poppins;">Confirm email</span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>',
                    ],
                ],
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
            );
            curl_setopt($ch, CURLOPT_USERPWD, "8ea9955361adc59aea3b7f23487b4e6d:72df21bb7f7cb69d689555039c4e3edf");
            $server_output = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                // Configure client
                echo 'Check email for verification!';
            }
        } else {
            echo 'Email already exist!';
        }
    } else {
        $insertReg = mysqli_query($conn, "INSERT INTO customers (name, username, email, password, phone_number, user_birthday, user_gender, vkey) VALUES ('$reg_name', '$reg_username', '$reg_email', '$hashed_pass', '$reg_phone_number', '$reg_bday', '$reg_gender', '$vkey')");
        if ($insertReg) {
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "amarahscorner.bfresort@gmail.com",
                            'Name' => "Amarah's Pizza Corner - BF Resort",
                        ],
                        'To' => [
                            [
                                'Email' => "$reg_email",
                                'Name' => "$reg_name",
                            ],
                        ],
                        'Subject' => "Email confirmation",
                        'HTMLPart' => '<style type="text/css">#outlook a { padding:0; }
                        body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
                        table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
                        img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
                        p { display:block;margin:13px 0; }</style><!--[if mso]>
                      <noscript>
                      <xml>
                      <o:OfficeDocumentSettings>
                        <o:AllowPNG/>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                      </xml>
                      </noscript>
                      <![endif]--><!--[if lte mso 11]>
                      <style type="text/css">
                        .mj-outlook-group-fix { width:100% !important; }
                      </style>
                      <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
              @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                      .mj-column-per-100 { width:100% !important; max-width: 100%; }
                    }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                    table.mj-full-width-mobile { width: 100% !important; }
                    td.mj-full-width-mobile { width: auto !important; }
                  }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 style="text-align:left; margin-top: 10px; margin-bottom: 10px; font-weight: normal;"><span style="font-size:23px;letter-spacing:normal;text-align:left;color:#000000;font-family:Poppins;"><b>Welcome to Amarah\'s Corner - BF Resort, ' . $reg_name . '</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: left; margin: 10px 0; margin-top: 10px;"><span style="line-height:22px;font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Poppins;">Only one more step to go!</span></p><p style="text-align: left; margin: 10px 0; margin-bottom: 10px;"><span style="line-height:22px;font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Poppins;">To verify your account information, just click the "Confirm email" button below to get started on savoring your food cravings with Amarah\'s Pizza Corner.</span></p></div></td></tr><tr><td align="left" vertical-align="middle" style="font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/verify.php?vkey=' . $vkey . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="font-size:14px;text-align:left;background-color:transparent;color:#070506;font-family:Poppins;">Confirm email</span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>',
                    ],
                ],
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
            );
            curl_setopt($ch, CURLOPT_USERPWD, "8ea9955361adc59aea3b7f23487b4e6d:72df21bb7f7cb69d689555039c4e3edf");
            $server_output = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                // Configure client
                echo 'Check email for verification!';
            }
        }
    }
}
