<?php
session_start();
require_once '../../includes/database_conn.php';

if (isset($_POST['map'])) {
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
                        "market": "' . $region . '"
                    }
                }
            },
            {
                "location": {
                    "lat": "' . $lat . '",
                    "lng": "' . $lng . '"
                },
            "addresses": {
                "en_PH": {
                    "displayString": "address",
                    "market": "' . $region . '"
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
    $token = $key . ':' . $time . ':' . $signature;

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $baseURL . $path,
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
            "Authorization: hmac " . $token, // A unique Signature Hash has to be generated for EVERY API call at the time of making such call.
            "Accept: application/json",
            "X-LLM-Market: {$region}", // Please note to which city are you trying to make API call
        ),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    $res = json_decode($response, JSON_OBJECT_AS_ARRAY);

    $distance = $res['distance']['text'];
    $delfee = $res['totalFee'];
    $delcurr = $res['totalFee'] . $res['totalFeeCurrency'];

    // $_SESSION['dis'] =$distance;
    // $_SESSION['dfee'] =$delfee;
    if (isset($distance) || $distance == null) {
        echo $delfee;
    } else {
        echo 'Invalid address!';
    }
}

if (isset($_POST['update'])) {
    $price = $_POST['price'];
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $subtotal = $_POST['subtotal'];
    $user_id = $_POST['user_id'];

    $updateCart = mysqli_query($conn, "UPDATE cart SET product_qty = '$qty', product_total = '$subtotal' WHERE cart_id = $cart_id AND user_id = $user_id");
}

if (isset($_POST['delete_cart_item'])) {
    $cart_id = $_POST['cart_id'];

    $deleteCart = mysqli_query($conn, "DELETE FROM cart WHERE cart_id = $cart_id");

    if ($deleteCart) {
        $_SESSION['alert'] = 'success';
        echo "success";
    }
}

if (isset($_POST['delete_all_cart'])) {
    $user_id = $_POST['user_id'];

    $delete = mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");

    if ($delete) {
        $_SESSION['alert'] = 'success_all';
        echo "success";
    }
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $userId = $_POST['user_id'];
    $qty = $_POST['qty'];
    $product_total_price = $_POST['price_value'];
    $total = $_POST['total'];
    $variation_value = $_POST['radio'] ?? null;
    $special_instructions = mysqli_real_escape_string($conn, $_POST['special_instructions']) ?? null;

    $getProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $product_id");

    while ($row = mysqli_fetch_array($getProduct)) {
        $productId = $row['product_id'];
        $categoryId = $row['category_id'];
        $subcategoryId = $row['subcategory_id'];
    }

    if ($variation_value == null) {
        $insertCart = mysqli_query($conn, "INSERT INTO cart (user_id, category_id, subcategory_id, product_id, product_qty, product_total, special_instructions, product_total_price) VALUES ($userId, $categoryId, NULLIF('$subcategoryId', ''), $productId, '$qty', '$total', NULLIF('$special_instructions', ''), '$product_total_price')");

        if ($insertCart) {
            $_SESSION['alert'] = 'success';
            echo 'success';
        }
    } else {
        $variation_implode = implode(' | ', $_POST['radio']);

        $insertCart = mysqli_query($conn, "INSERT INTO cart (user_id, category_id, subcategory_id, product_id, product_qty, product_total, special_instructions, variation_value, product_total_price) VALUES ($userId, $categoryId, NULLIF('$subcategoryId', ''), $productId, '$qty', '$total', NULLIF('$special_instructions', ''), NULLIF('$variation_implode', ''), '$product_total_price')");

        if ($insertCart) {
            $_SESSION['alert'] = 'success';
            echo 'success';
        }
    }
}

if (isset($_POST['cancel'])) {
    $order_id = $_POST['order_id'];

    $cancel_order = mysqli_query($conn, "DELETE FROM orders WHERE order_id = $order_id");

    if ($cancel_order) {
        $_SESSION['cancelled'] = true;
        echo 'success';
    }
}

if (isset($_POST['check_tracking'])) {
    $email = $_POST['email'];
    $order_id = $_POST['order-id'];

    $check = mysqli_query($conn, "SELECT customers.email, orders.order_id
    FROM orders
    INNER JOIN customers
    ON orders.user_id = customers.user_id
    WHERE orders.order_id = $order_id AND customers.email = '$email'");

    if (mysqli_num_rows($check) > 0) {
        $_SESSION['email'] = $email;
        echo "your-order?id=" . $order_id;
    } else {
        echo 'Invalid credentials!';
    }
}

if (isset($_POST['checkout_process'])) {
    date_default_timezone_set('Asia/Manila');
    $user_id = $_POST['user_id'];
    $billing_name = $_POST['billing_name'];
    $billing_phone = $_POST['billing_phone'];
    $email = $_POST['billing_email'];
    $province = $_POST['province_value'] ?? null;
    $city = $_POST['city_value'] ?? null;
    $barangay = $_POST['barangay_value'] ?? null;
    $block = $_POST['block'] ?? null;
    $payment = $_POST['payment'];
    $delivery = $_POST['deliver'];
    $screenshot = $_FILES['screenshot']['name'] ?? null;
    $screenshottmp = $_FILES['screenshot']['tmp_name'] ?? null;
    $reference = $_POST['reference'] ?? null;
    $shipping_value = $_POST['sf'];
    $order_total = $_POST['order_total_val'];
    $longitude = $_POST['lng'] ?? null;
    $latitude = $_POST['lat'] ?? null;
    $current_date = date('Y-m-d');
    $current_time = date('h:i A');
    $day = date('N');

    if ($payment == 2) {
        $imgExt = explode('.', $screenshot);
        $imgExt = strtolower(end($imgExt));

        $newImageName = uniqid() . '.' . $imgExt;
        move_uploaded_file($screenshottmp, '../../assets/images/' . $newImageName);

        $insert_orders = mysqli_query($conn, "INSERT INTO orders (user_id, payment_method, delivery_method, shipping_fee, longitude, latitude, screenshot_payment, reference, order_total, order_time, order_date, order_status, notified) VALUES ('$user_id', '$payment', '$delivery', NULLIF('$shipping_value', ''), NULLIF('$longitude', ''), NULLIF('$latitude', ''), '$newImageName', '$reference', '$order_total', '$current_time', '$current_date', '1', '0')");

        if ($insert_orders) {
            $order_id = mysqli_insert_id($conn);

            $get_order_status = mysqli_query($conn, "SELECT * FROM order_status");

            foreach ($get_order_status as $order_status) {
                $order_status_id = $order_status['order_status_id'];
                $insert_status_per_order_status = mysqli_query($conn, "INSERT INTO status_per_order_status (order_id, order_status_id, status_per_order_status) VALUES ('$order_id', '$order_status_id', '0')");
            }

            if ($insert_status_per_order_status) {
                $insert_order_address = mysqli_query($conn, "INSERT INTO order_address (order_id, billing_name, billing_number, block_street_building, province, city_municipality, barangay) VALUES ('$order_id', '$billing_name', '$billing_phone', NULLIF('$block', ''), NULLIF('$province', ''), NULLIF('$city', ''), NULLIF('$barangay', ''))");

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
                        $update_status_per_order_status = mysqli_query($conn, "UPDATE status_per_order_status SET status_per_order_status = '1' WHERE order_id = $order_id AND order_status_id = 1");
                        $_SESSION['order_id'] = $order_id;
                        $_SESSION['checkout'] = 'success';
                        echo 'success';
                    }
                }
            }
        }
    } else {
        $insert_orders = mysqli_query($conn, "INSERT INTO orders (user_id, payment_method, delivery_method, shipping_fee, longitude, latitude, order_total, order_time, order_date, order_status, notified) VALUES ('$user_id', '$payment', '$delivery', NULLIF('$shipping_value', ''), NULLIF('$longitude', ''), NULLIF('$latitude', ''), '$order_total', '$current_time', '$current_date', '1', '0')");

        if ($insert_orders) {
            $order_id = mysqli_insert_id($conn);

            $get_order_status = mysqli_query($conn, "SELECT * FROM order_status");

            foreach ($get_order_status as $order_status) {
                $order_status_id = $order_status['order_status_id'];
                $insert_status_per_order_status = mysqli_query($conn, "INSERT INTO status_per_order_status (order_id, order_status_id, status_per_order_status) VALUES ('$order_id', '$order_status_id', '0')");
            }

            if ($insert_status_per_order_status) {
                $insert_order_address = mysqli_query($conn, "INSERT INTO order_address (order_id, billing_name, billing_number, block_street_building, province, city_municipality, barangay) VALUES ('$order_id', '$billing_name', '$billing_phone', NULLIF('$block', ''), NULLIF('$province', ''), NULLIF('$city', ''), NULLIF('$barangay', ''))");

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
                        $update_status_per_order_status = mysqli_query($conn, "UPDATE status_per_order_status SET status_per_order_status = '1' WHERE order_id = $order_id AND order_status_id = 1");
                            $_SESSION['order_id'] = $order_id;
                            $_SESSION['checkout'] = 'success';
                            echo 'success';
                    }
                }
            }
        }
    }
}
