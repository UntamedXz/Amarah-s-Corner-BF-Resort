<?php
session_start();
require_once './includes/database_conn.php';

if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $getUserId = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = $user_id");
    $row = mysqli_fetch_array($getUserId);
    $userId = $row['user_id'];
    $userProfileIcon = $row['user_profile_image'];

    $getCartCount = mysqli_query($conn, "SELECT SUM(product_qty) FROM cart WHERE user_id = $userId");
    $rowCount = mysqli_fetch_array($getCartCount);
    $cartCount = $rowCount['SUM(product_qty)'];
} else {
    $cartCount = '0';
}
?>
<?php
// Put your key and secret here
$key = "pk_test_929096cd212d3fdf7baf925728e87cb3"; // put your lalamove API key here
$secret = "sk_test_tr/l1Zg3PyBdu3OKgasoAdjHjFBLDFt35X6JCQhSXal85dTw6+oaTozfiIr6oXdP"; 
// put your lalamove API secret here

$time = time() * 1000;

$baseURL = "https://rest.sandbox.lalamove.com"; // URl to Lalamove Sandbox API
$method = 'POST';
$path = '/v2/quotations';
$region = 'PH_MNL';
$lng = $_POST['Lng'];
$lat = $_POST['Lat'];

$_SESSION['long'] =$lng;
$_SESSION['latt'] =$lat;


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
                "lat": "14.551776",
                "lng": "121.016847"
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

$_SESSION['dis'] =$distance;
$_SESSION['dfee'] =$delfee;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/backup.css">
    <title>Amarah's Corner - BF Resort Las Piñas</title>

    <style>
        body {
            background: url(./assets/images/background.png) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100%;
        }
    </style>
</head>

<body>
    <div id="preloader"></div>

    <?php include './includes/navbar.php';?>
    <input type="hidden" name="" id="cartCount" value="<?php echo $cartCount; ?>">

    <input type="hidden" id="profileIconCheck" value="<?php echo $userProfileIcon; ?>">

    <script>
        $(window).on('load', function() {
            if($('#profileIconCheck').val() == '') {
                $('#profileIcon').attr("src","./assets/images/no_profile_pic.png");
            } else {
                $('#profileIcon').attr("src","./assets/images/" + $('#profileIconCheck').val());
            }
        })
    </script>

    <!-- TOAST -->
    <div class="toast" id="toast">
        <div class="toast-content" id="toast-content">
            <i id="toast-icon" class="fa-solid fa-triangle-exclamation warning"></i>

            <div class="message">
                <span class="text text-1" id="text-1"></span>
                <span class="text text-2" id="text-2"></span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>
        <div class="progress"></div>
    </div>

    <!-- LOGIN FORM -->
    <div class="login-form-container">
        <center>
    <form method="post" action="checkout">
    <table>
            <tr>
                <td><h4>Quoted Delivery Distance:</h4></td>
            </tr>
            <tr>
            <td><center><?php echo $_SESSION['dis']?></center></td>          
            </tr>
            <tr>
                <td><center><h4>Quoted Delivery Fee:</center></h4></td>                
            </tr>            
            <tr>            
            <td><center><?php echo $delcurr ?></center></td>            
            </tr>                        
            <tr>
                <td colspan="5" align="center">
                <input type="submit" value="Proceed"/>
                </td>
            </tr>
        </table>
    </form>   
    </center>
    </div>

    <?php include './includes/cart-count.php' ?>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js">
    </script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js">
    </script>
    <script src="./assets/js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
        // PRELOADER JS
        var loader = document.getElementById("preloader");

        window.addEventListener("load", function () {
            loader.style.display = "none";
            setTimeout(() => {
                document.querySelector(".toast").classList.remove("active");
            }, 5000);
        })
    </script>
</body>

</html>