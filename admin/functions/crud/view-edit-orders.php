<?php
session_start();
require_once '../../../includes/database_conn.php';
require '../../vendor/autoload.php';

use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

if(isset($_POST['update_status'])) {
    $selected = $_POST['selected_status'];
    $order_id = $_POST['order_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $token = md5(rand());

    $add_token = mysqli_query($conn, "UPDATE customers SET vkey = '$token' WHERE email = '$email'");

    $update = mysqli_query($conn, "UPDATE orders SET order_status = $selected WHERE order_id = $order_id");

    $get_delivery_method = mysqli_query($conn, "SELECT orders.delivery_method, delivery.delivery_title
    FROM delivery
    INNER JOIN orders
    ON orders.delivery_method = delivery.delivery_id
    WHERE order_id = $order_id");

    $row = mysqli_fetch_array($get_delivery_method);
    $delivery_method_id = $row['delivery_method'];

    
    $getdet = mysqli_query($conn, "SELECT * FROM orders WHERE order_id =$order_id");
    $getadd = mysqli_query($conn, "SELECT * FROM order_address WHERE order_id =$order_id");
    
    $row = mysqli_fetch_array($getdet);
    $row2 = mysqli_fetch_array($getadd);
    $lng = $row['longitude'];  
    $lat = $row['latitude'];  
    $fee = $row['shipping_fee'];  
    $add = $row2['block_street_building'];


    if ($selected == 1) {
        if($delivery_method_id == 1) {
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "amarahscorner.bfresort@gmail.com",
                            'Name' => "Amarah's Pizza Corner - BF Resort",
                        ],
                        'To' => [
                            [
                                'Email' => "$email",
                                'Name' => "$name",
                            ],
                        ],
                        'Subject' => "ORDER STATUS",
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
                      <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
              @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                      .mj-column-per-100 { width:100% !important; max-width: 100%; }
                    }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                    table.mj-full-width-mobile { width: 100% !important; }
                    td.mj-full-width-mobile { width: auto !important; }
                  }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l32zv/y47io.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Hi ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">Here is the status of your order, as of now it is pending and awaiting the confirmation by one of our staff. Please sit back and relax as we take care of your order.</span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:14px;"><b>Check Your Order</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>',
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
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        Here is the status of your order, as of now it is pending and awaiting the confirmation by one of our staff. Please sit back and relax as we take care of your order.
    
        Check your order here -> http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '
    
        - Amarah\'s Pizza Corner - BF Resort
    
        If you have any concerns, you may contact us at "amarahscorner.bfresort@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        } else {
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "amarahscorner.bfresort@gmail.com",
                            'Name' => "Amarah's Pizza Corner - BF Resort",
                        ],
                        'To' => [
                            [
                                'Email' => "$email",
                                'Name' => "$name",
                            ],
                        ],
                        'Subject' => "ORDER STATUS",
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
                      <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
              @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                      .mj-column-per-100 { width:100% !important; max-width: 100%; }
                    }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                    table.mj-full-width-mobile { width: 100% !important; }
                    td.mj-full-width-mobile { width: auto !important; }
                  }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l33jl/yo3u9.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Hi ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">Here is the status of your order, as of now it is pending and awaiting the confirmation by one of our staffs. Please sit back and relax as we take care of your order.</span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:14px;"><b>Check Your Order</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>',
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
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        Here is the status of your order, as of now it is pending and awaiting the confirmation by one of our staff. Please sit back and relax as we take care of your order.
    
        Check your order here -> http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '
    
        - Amarah\'s Pizza Corner - BF Resort
    
        If you have any concerns, you may contact us at "amarahscorner.bfresort@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        }
    } else if($selected == 2) {
        if($delivery_method_id == 1) {
            $body = [
                'Messages' => [
                    [
                    'From' => [
                        'Email' => "amarahscorner.bfresort@gmail.com",
                        'Name' => "Amarah's Pizza Corner - BF Resort"
                    ],
                    'To' => [
                        [
                            'Email' => "$email",
                            'Name' => "$name"
                        ]
                    ],
                    'Subject' => "ORDER STATUS",
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
                  <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
          @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                  .mj-column-per-100 { width:100% !important; max-width: 100%; }
                }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                table.mj-full-width-mobile { width: 100% !important; }
                td.mj-full-width-mobile { width: auto !important; }
              }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l3329/yow7g.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Hi ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">Here is the status of your order, as of now your order is already confirmed and now being managed by the staff. Please sit back and relax as we take care of your order.</span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:14px;"><b>Check Your Order</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>'
                    ]
                ]
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
            curl_close ($ch);
            
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        Here is the status of your order, as of now your order is already confirmed and now being managed by the staff. please sit back and relax as we take care of your order.
    
        Check your order here -> http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '
    
        - Amarah\'s Pizza Corner - BF Resort
    
        If you have any concerns, you may contact us at "bfresortamarahscorner@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        } else {
            $body = [
                'Messages' => [
                    [
                    'From' => [
                        'Email' => "amarahscorner.bfresort@gmail.com",
                        'Name' => "Amarah's Pizza Corner - BF Resort"
                    ],
                    'To' => [
                        [
                            'Email' => "$email",
                            'Name' => "$name"
                        ]
                    ],
                    'Subject' => "ORDER STATUS",
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
                  <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
          @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                  .mj-column-per-100 { width:100% !important; max-width: 100%; }
                }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                table.mj-full-width-mobile { width: 100% !important; }
                td.mj-full-width-mobile { width: auto !important; }
              }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l34u1/yo37m.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Hi ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">Here is the status of your order, as of now your order is already confirmed and now being managed by the staff. Please sit back and relax as we take care of your order.</span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:14px;"><b>Check Your Order</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>'
                    ]
                ]
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
            curl_close ($ch);
            
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        Here is the status of your order, as of now your order is already confirmed and now being managed by the staff. please sit back and relax as we take care of your order.
    
        Check your order here -> http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '
    
        - Amarah\'s Pizza Corner - BF Resort
    
        If you have any concerns, you may contact us at "bfresortamarahscorner@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        }
    } else if($selected == 3) {
        if($delivery_method_id == 1) {
            $body = [
                'Messages' => [
                    [
                    'From' => [
                        'Email' => "amarahscorner.bfresort@gmail.com",
                        'Name' => "Amarah's Pizza Corner"
                    ],
                    'To' => [
                        [
                            'Email' => "$email",
                            'Name' => "$name"
                        ]
                    ],
                    'Subject' => "ORDER STATUS",
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
                  <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
          @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                  .mj-column-per-100 { width:100% !important; max-width: 100%; }
                }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                table.mj-full-width-mobile { width: 100% !important; }
                td.mj-full-width-mobile { width: auto !important; }
              }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l333o/yoxxl.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Hi ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">Here is the status of your order, as of now your order is now being prepared by our staff and it should ready to pick up soon.</span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:14px;"><b>Check Your Order</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>'
                    ]
                ]
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
            curl_close ($ch);
            
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        Here is the status of your order, as of now your order is now being prepared by our staff and it should ready to pick up soon.
    
        Check your order here -> http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '
    
    
        - Amarah\'s Pizza Corner - BF Resort!
    
        If you have any concerns, you may contact us at "amarahscorner.bfresort@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        } else {
            $body = [
                'Messages' => [
                    [
                    'From' => [
                        'Email' => "amarahscorner.bfresort@gmail.com",
                        'Name' => "Amarah's Pizza Corner"
                    ],
                    'To' => [
                        [
                            'Email' => "$email",
                            'Name' => "$name"
                        ]
                    ],
                    'Subject' => "ORDER STATUS",
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
                  <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
          @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                  .mj-column-per-100 { width:100% !important; max-width: 100%; }
                }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                table.mj-full-width-mobile { width: 100% !important; }
                td.mj-full-width-mobile { width: auto !important; }
              }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l334z/yoxuy.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Hi ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">Here is the status of your order, as of now your order is being prepared by our staff and it should be handed to courier soon.</span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:14px;"><b>Check Your Order</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>'
                    ]
                ]
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
            curl_close ($ch);
            
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        Here is the status of your order, as of now your order is being prepared by our staff and it should be handed to courier soon.
    
        Check your order here -> http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '
    
    
        - Amarah\'s Pizza Corner - BF Resort!
    
        If you have any concerns, you may contact us at "amarahscorner.bfresort@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        }
    } else if($selected == 4) {    
        $key = "pk_test_929096cd212d3fdf7baf925728e87cb3"; // put your lalamove API key here
        $secret = "sk_test_tr/l1Zg3PyBdu3OKgasoAdjHjFBLDFt35X6JCQhSXal85dTw6+oaTozfiIr6oXdP"; // put your lalamove API secret here

        $time = time() * 1000;
        $baseURL = "https://rest.sandbox.lalamove.com"; // URl to Lalamove Sandbox API
        $method = 'POST';
        $path = '/v2/orders';
        $region = 'PH_MNL';

        $body = '{
        "serviceType": "MOTORCYCLE",
        "specialRequests": [],
        "requesterContact": {
        "name": "Amarah Pizza Corner",
        "phone": "0899183138"
        },
        "stops": [
        {
            "location": {
                "lat": "14.437238300580049",
                "lng": "120.99027438102536"
            },
            "addresses": {
                "en_PH": {
                    "displayString": "BF las pinas resort",
                    "market": "'.$region.'"
                }
            }
        },
        {
            "location": {
                "lat": "'.$lat.'",
                "lng": "'.$lng.'"
            },
           "addresses": {
               "en_PH": {
                   "displayString": "'.$add.'",
                   "market": "'.$region.'"
               }
           }
        }
        ],
        "deliveries": [
        {
            "toStop": 1,
            "toContact": {
                "name": "'.$name.'",
                "phone": "'.$number.'"
            },
           "remarks": "Do not take this order - SANDBOX CLIENT TEST"
        }
        ],
        "quotedTotalFee": {
        "amount": "'.$fee.'",
        "currency": "PHP"
        }
        }';

        $rawSignature = "{$time}\r\n{$method}\r\n{$path}\r\n\r\n{$body}";
        $signature = hash_hmac("sha256", $rawSignature, $secret);
        $startTime = microtime(true);
        $token = $key.':'.$time.':'.$signature;

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $baseURL.$path,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 3,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => false, 
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => array(
        "Content-type: application/json; charset=utf-8",
        "Authorization: hmac ".$token,
        "Accept: application/json",
        "X-LLM-Market: {$region}" 
        ),
        ));

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $res = json_decode($response, JSON_OBJECT_AS_ARRAY);
   
        if($delivery_method_id == 1) {
            $body = [
                'Messages' => [
                    [
                    'From' => [
                        'Email' => "amarahscorner.bfresort@gmail.com",
                        'Name' => "Amarah's Pizza Corner"
                    ],
                    'To' => [
                        [
                            'Email' => "$email",
                            'Name' => "$name"
                        ]
                    ],
                    'Subject' => "ORDER STATUS",
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
                  <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
          @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                  .mj-column-per-100 { width:100% !important; max-width: 100%; }
                }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                table.mj-full-width-mobile { width: 100% !important; }
                td.mj-full-width-mobile { width: auto !important; }
              }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l33iy/yo2gx.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Hi ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">Here is the status of your order, your order is now ready to pick up.</span></p><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">Address: <b>Blk 5 Lot 71 JB Tan St., BF Resort Village, Las Piñas, 1740 Metro Manila</b></span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:14px;"><b>Check Your Order</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>'
                    ]
                ]
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
            curl_close ($ch);
            
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        Here is the status of your order, as of now your order is being prepared by our staff and it should be handed to courier soon.
    
        Check your order here -> http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '
    
        - Amarah\'s Pizza Corner - BF Resort!
    
        If you have any concerns, you may contact us at "amarahscorner.bfresort@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        } else {
            $body = [
                'Messages' => [
                    [
                    'From' => [
                        'Email' => "amarahscorner.bfresort@gmail.com",
                        'Name' => "Amarah's Pizza Corner"
                    ],
                    'To' => [
                        [
                            'Email' => "$email",
                            'Name' => "$name"
                        ]
                    ],
                    'Subject' => "ORDER STATUS",
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
                  <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
          @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                  .mj-column-per-100 { width:100% !important; max-width: 100%; }
                }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                table.mj-full-width-mobile { width: 100% !important; }
                td.mj-full-width-mobile { width: auto !important; }
              }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l33i7/yo2vu.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Hi ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">Here is the status of your order, your order is now being handed to the courier and now on its way.</span></p><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">For Cash on Delivery (COD), please prepare an exact amount for your order.</span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:14px;"><b>Check Your Order</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>'
                    ]
                ]
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
            curl_close ($ch);
            
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        Here is the status of your order, your order is now being handed to the courier and now on its way.

        For Cash on Delivery (COD), please prepare an exact amount for your order.
    
        Check your order here -> http://localhost/theserve-amarah-s-corner-bf-resort/your-order?id=' . $order_id . '
    
        - Amarah\'s Pizza Corner - BF Resort!
    
        If you have any concerns, you may contact us at "amarahscorner.bfresort@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        }
    } else if($selected == 5) {
        if($delivery_method_id == 1) {
            $body = [
                'Messages' => [
                    [
                    'From' => [
                        'Email' => "amarahscorner.bfresort@gmail.com",
                        'Name' => "Amarah's Pizza Corner - BF Resort"
                    ],
                    'To' => [
                        [
                            'Email' => "$email",
                            'Name' => "$name"
                        ]
                    ],
                    'Subject' => "ORDER STATUS",
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
                  <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
          @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                  .mj-column-per-100 { width:100% !important; max-width: 100%; }
                }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                table.mj-full-width-mobile { width: 100% !important; }
                td.mj-full-width-mobile { width: auto !important; }
              }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l3348/yoxhy.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Thank you, ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">We look forward to serving you again next time.</span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/feedback?email='.$email.'&token='.$token.'" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Give us a feedback!</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>'
                    ]
                ]
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
            curl_close ($ch);
            
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        We look forward to serving you again next time.
    
        Give us a feedback here -> http://localhost/theserve-amarah-s-corner-bf-resort/feedback?email='.$email.'&token='.$token.'
    
        - Amarah\'s Pizza Corner - BF Resort
    
        If you have any concerns, you may contact us at "bfresortamarahscorner@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        } else {
            $body = [
                'Messages' => [
                    [
                    'From' => [
                        'Email' => "amarahscorner.bfresort@gmail.com",
                        'Name' => "Amarah's Pizza Corner - BF Resort"
                    ],
                    'To' => [
                        [
                            'Email' => "$email",
                            'Name' => "$name"
                        ]
                    ],
                    'Subject' => "ORDER STATUS",
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
                  <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Poppins);
          @import url(https://fonts.googleapis.com/css?family=Poppins);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                  .mj-column-per-100 { width:100% !important; max-width: 100%; }
                }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                table.mj-full-width-mobile { width: 100% !important; }
                td.mj-full-width-mobile { width: auto !important; }
              }</style></head><body style="word-spacing:normal;background-color:#F4F4F4;"><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l28l6/y1tk8.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:0px 0px 0px 0px;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:20px 20px 20px 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:560px;"><img alt="" height="auto" src="https://0t3yp.mjt.lu/tplimg/0t3yp/b/l33om/yoxqi.png" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="560"></td></tr></tbody></table></td></tr><tr><td align="left" style="background:transparent;font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 class="text-build-content" style="text-align:center;; margin-top: 10px; margin-bottom: 10px; font-weight: normal;" data-testid="_EytIV4mUm_X"><span style="font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Thank you, ' . $name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p class="text-build-content" style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;" data-testid="9Gm4dkWRh"><span style="color:#55575d;font-family:Poppins, Arial, Helvetica, sans-serif;font-size:13px;">We look forward to serving you again next time.</span></p></div></td></tr><tr><td align="center" vertical-align="middle" style="background:transparent;font-size:0px;padding:10px 25px 10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"><tbody><tr><td align="center" bgcolor="#ffaf08" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#ffaf08;" valign="middle"><a href="http://localhost/theserve-amarah-s-corner-bf-resort/feedback?email='.$email.'&token='.$token.'" style="display:inline-block;background:#ffaf08;color:#ffffff;font-family:Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:3px;" target="_blank"><span style="color:#000000;font-family:Poppins, Arial, Helvetica, sans-serif;"><b>Give us a feedback!</b></span></a></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</p></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:11px;letter-spacing:normal;line-height:22px;text-align:center;color:#000000;"><p style="margin: 10px 0;">   PH</p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>'
                    ]
                ]
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
            curl_close ($ch);
            
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                $config = Configuration::getDefaultConfiguration();
                $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTY1NDk1Mjk4NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjk1MDcxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.bWwiz3zNCvdWopCvhPaFe_RJKa2cvYJzu5HuxHE4Pps');
                $apiClient = new ApiClient($config);
                $messageClient = new MessageApi($apiClient);
    
                $sendMessageRequest1 = new SendMessageRequest([
                    'phoneNumber' => $number,
                    'message' => 'Hi ' . $name . '!
    
        We look forward to serving you again next time.
    
        Give us a feedback here -> http://localhost/theserve-amarah-s-corner-bf-resort/feedback?email='.$email.'&token='.$token.'
    
        - Amarah\'s Pizza Corner - BF Resort
    
        If you have any concerns, you may contact us at "bfresortamarahscorner@gmail.com"',
                    'deviceId' => 128642
                ]);
                
                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest1
                ]);
    
                if($sendMessageRequest1) {
                    $_SESSION['update'] = 'success';
                    echo 'success';
                }
            }
        }
    }
}