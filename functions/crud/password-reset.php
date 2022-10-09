<?php
session_start();
require_once '../../includes/database_conn.php';
require '../../vendor/autoload.php';

use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

if(isset($_POST['password_reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $vkey = md5(rand());

    $get_info = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email' LIMIT 1");

    if(mysqli_num_rows($get_info) > 0) {
        $row = mysqli_fetch_array($get_info);

        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_vkey = mysqli_query($conn, "UPDATE customers SET vkey = '$vkey' WHERE email = '$get_email' LIMIT 1");

        if($update_vkey) {
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "capstemp00@gmail.com",
                            'Name' => "Amarah's Pizza Corner",
                        ],
                        'To' => [
                            [
                                'Email' => "$get_email",
                                'Name' => "$get_name",
                            ],
                        ],
                        'Subject' => "Here is the status your order",
                        'HTMLPart' => '<style type="text/css">#outlook a { padding:0; }
                        body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
                        table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
                        img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
                        p { display:block;margin:13px 0; }</style><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
              @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                      .mj-column-per-67 { width:67% !important; max-width: 67%; }
              .mj-column-per-33 { width:33% !important; max-width: 33%; }
              .mj-column-per-100 { width:100% !important; max-width: 100%; }
                    }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-67 { width:67% !important; max-width: 67%; }
              .moz-text-html .mj-column-per-33 { width:33% !important; max-width: 33%; }
              .moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-67 { width:67% !important; max-width: 67%; }
              [owa] .mj-column-per-33 { width:33% !important; max-width: 33%; }
              [owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                    table.mj-full-width-mobile { width: 100% !important; }
                    td.mj-full-width-mobile { width: auto !important; }
                  }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><div class="mj-column-per-67 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:0px 0px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="margin: 10px 0;"></p></div></td></tr></tbody></table></div><div class="mj-column-per-33 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 0px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: right; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span style="font-size:13px;text-align:right;color:#55575d;font-family:Arial;line-height:22px;"><a href="[[PERMALINK]]" style="color:inherit;text-decoration:none;" target="_blank">View online version</a></span></p></div></td></tr></tbody></table></div></td></tr></tbody></table></div><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:23px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" data-testid="_EytIV4mUm_X" style="margin-top: 10px; margin-bottom: 10px; font-weight: normal;"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;font-size:23px;"><b>Welcome to Amarah\'s Corner - BF Resort, ' . $get_name . '</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" data-testid="Yb20wWlgw6m0" style="margin: 10px 0; margin-top: 10px;"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;">Only one more step to go!</span></p><p class="text-build-content" data-testid="Yb20wWlgw6m0" style="margin: 10px 0; margin-bottom: 10px;"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;">To verify your account information, just click the "Confirm email" button below to get started on savoring your food cravings with Amarah\'s Pizza Corner.</span></p></div></td></tr><tr><td align="left" vertical-align="middle" style="font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-las-pinas/password-change?vkey='. $vkey .'&email=' . $get_email . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="background-color:transparent;color:#070506;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:14px;">Confirm email</span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div></td></tr></tbody></table></div></div></body>',
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
            curl_setopt($ch, CURLOPT_USERPWD, "a42bfdf767ddb807f6aaf82282a24f7a:c58f5c7f72f66fdea695a4a6ceb4e219");
            $server_output = curl_exec($ch);
            curl_close($ch);
    
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                // Configure client
                echo 'Check email for password link!';
            }
        } else {
            echo 'Something went wrong!';
        }
    } else {
        echo 'No email found!';
    }
}