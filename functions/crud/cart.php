<?php
session_start();
require_once '../../includes/database_conn.php';

if(isset($_POST['map'])) {
    $long = $_POST['longitude'];
    $lat = $_POST['latitude'];

    $key = "pk_test_929096cd212d3fdf7baf925728e87cb3"; // put your lalamove API key here
    $secret = "sk_test_tr/l1Zg3PyBdu3OKgasoAdjHjFBLDFt35X6JCQhSXal85dTw6+oaTozfiIr6oXdP"; 
    // put your lalamove API secret here

    $time = time() * 1000;

    $baseURL = "https://rest.sandbox.lalamove.com"; // URl to Lalamove Sandbox API
    $method = 'POST';
    $path = '/v2/quotations';
    $region = 'PH_MNL';
    $lng = $_POST['longitude'];
    $lat = $_POST['latitude'];

    // $_SESSION['long'] =$lng;
    // $_SESSION['latt'] =$lat;


    // Please, find information about body structure and passed values here https://developers.lalamove.com/#get-quotation
    $body = '{
        "serviceType": "MOTORCYCLE",
        "specialRequests": [],
        "requesterContact": {
            "name": "Amarahs Corner",
            "phone": "0899183138"
        },
        "stops": [
            {
                "location": {
                    "lat": "14.4370461",
                    "lng": "120.9881286"
                },
                "addresses": {
                    "en_PH": {
                        "displayString": "Blk 5 Lot 71 JB Tan St., BF Resort Village, Las Piñas, 1740 Metro Manila",
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
                    "displayString": "address",
                    "market": "'.$region.'"
                }
            }
            }
    ],
    "deliveries": [
            {
                "toStop": 1,
                "toContact": {
                    "name": "customer",
                    "phone": "123123"
                },
            "remarks": "Do not take this order - SANDBOX CLIENT TEST"
            }
    ]
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
        CURLOPT_HEADER => false, // Enable this option if you want to see what headers Lalamove API returning in response
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => array(
            "Content-type: application/json; charset=utf-8",
            "Authorization: hmac ".$token, // A unique Signature Hash has to be generated for EVERY API call at the time of making such call.
            "Accept: application/json",
            "X-LLM-Market: {$region}" // Please note to which city are you trying to make API call
        ),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    $res = json_decode($response, JSON_OBJECT_AS_ARRAY);

    $distance = $res['distance']['text'];
    $delfee = $res['totalFee'];
    $delcurr = $res['totalFee'].$res['totalFeeCurrency'];

    // $_SESSION['dis'] =$distance;
    // $_SESSION['dfee'] =$delfee;
    if(isset($distance) || $distance == null) {
        echo $delfee;
    } else {
        echo 'Invalid address!';
    }
}

if(isset($_POST['update'])) {
    $price = $_POST['price'];
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $subtotal = $_POST['subtotal'];
    $user_id = $_POST['user_id'];

    $updateCart = mysqli_query($conn, "UPDATE cart SET product_qty = '$qty', product_total = '$subtotal' WHERE cart_id = $cart_id AND user_id = $user_id");
}

if(isset($_POST['delete_cart_item'])) {
    $cart_id = $_POST['cart_id'];

    $deleteCart = mysqli_query($conn, "DELETE FROM cart WHERE cart_id = $cart_id");

    if($deleteCart) {
        $_SESSION['alert'] = 'success';
        echo "success";
    }
}

if(isset($_POST['delete_all_cart'])) {
    $user_id = $_POST['user_id'];

    $delete = mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");

    if($delete) {
        $_SESSION['alert'] = 'success_all';
        echo "success";
    }
}

if(isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $userId = $_POST['user_id'];
    $qty = $_POST['qty'];
    $product_total_price = $_POST['price_value'];
    $total = $_POST['total'];
    $variation_value = $_POST['radio'] ?? null;
    $special_instructions = mysqli_real_escape_string($conn, $_POST['special_instructions']) ?? null;

    $getProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $product_id");

    while($row = mysqli_fetch_array($getProduct)) {
        $productId = $row['product_id'];
        $categoryId = $row['category_id'];
        $subcategoryId = $row['subcategory_id'];
    }

    if($variation_value == NULL) {
        $insertCart = mysqli_query($conn, "INSERT INTO cart (user_id, category_id, subcategory_id, product_id, product_qty, product_total, special_instructions, product_total_price) VALUES ($userId, $categoryId, NULLIF('$subcategoryId', ''), $productId, '$qty', '$total', NULLIF('$special_instructions', ''), '$product_total_price')");

        if($insertCart) {
            $_SESSION['alert'] = 'success';
            echo 'success';
        }
    } else {
        $variation_implode = implode(' | ',$_POST['radio']);
        
        $insertCart = mysqli_query($conn, "INSERT INTO cart (user_id, category_id, subcategory_id, product_id, product_qty, product_total, special_instructions, variation_value, product_total_price) VALUES ($userId, $categoryId, NULLIF('$subcategoryId', ''), $productId, '$qty', '$total', NULLIF('$special_instructions', ''), NULLIF('$variation_implode', ''), '$product_total_price')");

        if($insertCart) {
            $_SESSION['alert'] = 'success';
            echo 'success';
        }
    }
}

if(isset($_POST['cancel'])) {
    $order_id = $_POST['order_id'];

    $cancel_order = mysqli_query($conn, "DELETE FROM orders WHERE order_id = $order_id");

    if($cancel_order) {
        $_SESSION['cancelled'] = true;
        echo 'success';
    }
}

if(isset($_POST['check_tracking'])) {
    $email = $_POST['email'];
    $order_id = $_POST['order-id'];

    $check = mysqli_query($conn, "SELECT customers.email, orders.order_id
    FROM orders
    INNER JOIN customers
    ON orders.user_id = customers.user_id
    WHERE orders.order_id = $order_id AND customers.email = '$email'");

    if(mysqli_num_rows($check) > 0) {
        $_SESSION['email'] = $email;
        echo "your-order?id=" . $order_id;
    } else {
        echo 'Invalid credentials!';
    }
}

if(isset($_POST['checkout_process'])) {
    date_default_timezone_set('Asia/Manila');
    $user_id = $_POST['user_id'];
    $billing_name = $_POST['billing_name'];
    $billing_phone = $_POST['billing_phone'];
    $email = $_POST['billing_email'];
    $address = $_POST['address'] ?? null;
    $province = $_POST['province'] ?? null;
    $city = $_POST['city'] ?? null;
    $barangay = $_POST['barangay'] ?? null;
    $payment = $_POST['payment'];
    $delivery = $_POST['deliver'];
    $screenshot = $_FILES['screenshot']['name'] ?? null;
    $screenshottmp = $_FILES['screenshot']['tmp_name'] ?? null;
    $reference = $_POST['reference'] ?? null;
    $shipping_value = $_POST['sf'];
    $order_total = $_POST['order_total_val'];
    $longitude = $_POST['lng'] ?? null;
    $latitude = $_POST['lat'] ?? null;
    $date = date('F j, Y h:i A');
    $day = date('N');
    $time = date('h:i A');


    if ($payment == 2) {
        $imgExt = explode('.', $screenshot);
        $imgExt = strtolower(end($imgExt));

        $newImageName = uniqid() . '.' . $imgExt;
        move_uploaded_file($screenshottmp, '../../assets/images/' . $newImageName);

        $insert_orders = mysqli_query($conn, "INSERT INTO orders (user_id, payment_method, delivery_method, shipping_fee, longitude, latitude, screenshot_payment, reference, order_total, order_date, order_status, notified) VALUES ('$user_id', '$payment', '$delivery', NULLIF('$shipping_value', ''), NULLIF('$longitude', ''), NULLIF('$latitude', ''), '$newImageName', '$reference', '$order_total', '$date', '1', '0')");

        if ($insert_orders) {
            $order_id = mysqli_insert_id($conn);

            $insert_order_address = mysqli_query($conn, "INSERT INTO order_address (order_id, billing_name, billing_number, block_street_building, province, city_municipality, barangay) VALUES ('$order_id', '$billing_name', '$billing_phone', NULLIF('$address', ''), NULLIF('$province', ''), NULLIF('$city', ''), NULLIF('$barangay', ''))");

            if ($insert_order_address) {
                $get_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id");

                foreach ($get_cart as $row) {
                    $product_id = $row['product_id'];
                    $cart_id = $row['cart_id'];
                    $subcategory_id = $row['subcategory_id'];
                    $category_id = $row['category_id'];
                    $variation_value = $row['variation_value'];
                    $product_qty = $row['product_qty'];
                    $product_total = $row['product_total'];
                    $special_instructions = $row['special_instructions'];

                    $insert_order_list = mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, category_id, subcategory_id, variation_value, qty, product_total, special_instructions) VALUES ('$order_id', '$product_id', NULLIF('$category_id', ''), NULLIF('$subcategory_id', ''), NULLIF('$variation_value', ''), '$product_qty', '$product_total', NULLIF('$special_instructions', ''))");

                    if ($insert_order_list) {
                        $delete_cart_item = mysqli_query($conn, "DELETE FROM cart WHERE cart_id = $cart_id");
                    }
                }
                if ($delete_cart_item) {
                    $body = [
                        'Messages' => [
                            [
                                'From' => [
                                    'Email' => "capstemp00@gmail.com",
                                    'Name' => "Amarah's Pizza Corner",
                                ],
                                'To' => [
                                    [
                                        'Email' => "$email",
                                        'Name' => "$billing_name",
                                    ],
                                ],
                                'Subject' => "Here is the status your order",
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
                            <![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                            .mj-column-per-100 { width:100% !important; max-width: 100%; }
                            }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                            table.mj-full-width-mobile { width: 100% !important; }
                            td.mj-full-width-mobile { width: auto !important; }
                        }</style> <body style="word-spacing:normal;background-color:#F4F4F4;"><div style="display:none;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">Here is your order update status</div><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0owzv.mjt.lu/tplimg/0owzv/b/1y0lu/mz3o.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role`="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 style="text-align:left; margin-top: 10px; margin-bottom: 10px; font-weight: normal;"><span style="font-size:20px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;"><b>Hi ' . $billing_name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: left; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;">Here is the status of your order, as of now it is pending and awaiting the confirmation by one of our staffs. please sit back and relax as we take care of your order.</span></p></div></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:550px;"><img alt="" height="auto" src="https://0owzv.mjt.lu/tplimg/0owzv/b/1y0lu/mzgm.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="550"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: left; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;">If you have any concerns, </span><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;"><br></span><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;"><br></span><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;">you may contact us at "bfresortamarahscorner@gmail.com"</span></p></div></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span style="font-size:13px;letter-spacing:normal;text-align:center;color:#55575d;font-family:Arial;line-height:22px;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</span></p></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span style="font-size:13px;letter-spacing:normal;text-align:center;color:#55575d;font-family:Arial;line-height:22px;">   PH</span></p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>',
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
                        $_SESSION['order_id'] = $order_id;
                        $_SESSION['checkout'] = 'success';
                        echo 'success';
                    }
                }
            }
        }
    } else {
        $insert_orders = mysqli_query($conn, "INSERT INTO orders (user_id, payment_method, delivery_method, shipping_fee, longitude, latitude, order_total, order_date, order_status, notified) VALUES ('$user_id', '$payment', '$delivery', NULLIF('$shipping_value', ''), NULLIF('$longitude', ''), NULLIF('$latitude', ''), '$order_total', '$date', '1', '0')");

        if ($insert_orders) {
            $order_id = mysqli_insert_id($conn);

            $insert_order_address = mysqli_query($conn, "INSERT INTO order_address (order_id, billing_name, billing_number, block_street_building, province, city_municipality, barangay) VALUES ('$order_id', '$billing_name', '$billing_phone', NULLIF('$address', ''), NULLIF('$province', ''), NULLIF('$city', ''), NULLIF('$barangay', ''))");

            if ($insert_order_address) {
                $get_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id");

                foreach ($get_cart as $row) {
                    $product_id = $row['product_id'];
                    $cart_id = $row['cart_id'];
                    $category_id = $row['category_id'];
                    $subcategory_id = $row['subcategory_id'];
                    $variation_value = $row['variation_value'];
                    $product_qty = $row['product_qty'];
                    $product_total = $row['product_total'];
                    $special_instructions = $row['special_instructions'];

                    $insert_order_list = mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, category_id, subcategory_id, variation_value, qty, product_total, special_instructions) VALUES ('$order_id', '$product_id', NULLIF('$category_id', ''), NULLIF('$subcategory_id', ''), NULLIF('$variation_value', ''), '$product_qty', '$product_total', NULLIF('$special_instructions', ''))");

                    if ($insert_order_list) {
                        $delete_cart_item = mysqli_query($conn, "DELETE FROM cart WHERE cart_id = $cart_id");
                    }
                }
                if ($delete_cart_item) {
                    $body = [
                        'Messages' => [
                            [
                                'From' => [
                                    'Email' => "capstemp00@gmail.com",
                                    'Name' => "Amarah's Pizza Corner",
                                ],
                                'To' => [
                                    [
                                        'Email' => "$email",
                                        'Name' => "$billing_name",
                                    ],
                                ],
                                'Subject' => "Here is the status your order",
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
                            <![endif]--><style type="text/css">@media only screen and (min-width:480px) {
                            .mj-column-per-100 { width:100% !important; max-width: 100%; }
                            }</style><style media="screen and (min-width:480px)">.moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">[owa] .mj-column-per-100 { width:100% !important; max-width: 100%; }</style><style type="text/css">@media only screen and (max-width:480px) {
                            table.mj-full-width-mobile { width: 100% !important; }
                            td.mj-full-width-mobile { width: auto !important; }
                        }</style> <body style="word-spacing:normal;background-color:#F4F4F4;"><div style="display:none;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">Here is your order update status</div><div style="background-color:#F4F4F4;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 0px 0px 0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:600px;"><img alt="" height="auto" src="https://0owzv.mjt.lu/tplimg/0owzv/b/1y0lu/mz3o.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="600"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role`="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><h1 style="text-align:left; margin-top: 10px; margin-bottom: 10px; font-weight: normal;"><span style="font-size:20px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;"><b>Hi ' . $billing_name . '!</b></span></h1></div></td></tr><tr><td align="left" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: left; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;">Here is the status of your order, as of now it is pending and awaiting the confirmation by one of our staffs. please sit back and relax as we take care of your order.</span></p></div></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="center" style="font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:550px;"><img alt="" height="auto" src="https://0owzv.mjt.lu/tplimg/0owzv/b/1y0lu/mzgm.png" style="border:none;border-radius:px;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="550"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#ffffff" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: left; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;">If you have any concerns, </span><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;"><br></span><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;"><br></span><span style="font-size:13px;letter-spacing:normal;text-align:left;color:#55575d;font-family:Arial;">you may contact us at "bfresortamarahscorner@gmail.com"</span></p></div></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tbody></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0px 20px 0px;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td style="vertical-align:top;padding:0;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"><tbody><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span style="font-size:13px;letter-spacing:normal;text-align:center;color:#55575d;font-family:Arial;line-height:22px;">This e-mail has been sent to [[EMAIL_TO]], <a href="[[UNSUB_LINK_EN]]" style="color:inherit;text-decoration:none;" target="_blank">click here to unsubscribe</a>.</span></p></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;"><div style="font-family:Arial, sans-serif;font-size:13px;letter-spacing:normal;line-height:1;text-align:left;color:#000000;"><p style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span style="font-size:13px;letter-spacing:normal;text-align:center;color:#55575d;font-family:Arial;line-height:22px;">   PH</span></p></div></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body>',
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
                        $_SESSION['order_id'] = $order_id;
                        $_SESSION['checkout'] = 'success';
                        echo 'success';
                    }
                }
            }
        }
    }
}