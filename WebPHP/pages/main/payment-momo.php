<?php
session_start();
header('Content-type: text/html; charset=utf-8');


function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}


$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
// $orderInfo = $_POST['address'];
// $amount = $_POST['total'];

$orderInfo ='ID đơn hàng: '. $_SESSION['payment']['id_cart'];
$amount = $_SESSION['payment']['total'] ;

// $orderInfo = 'đà nẵng';
// $amount = '100000';

$orderId = time() ."";
$redirectUrl = "http://localhost/WebPHP/index.php?pages=profiles&";
$ipnUrl = "http://localhost/WebPHP/index.php?pages=profiles&";
$extraData = "";


    $requestId = time() . "";
    $requestType = "payWithATM";
    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature);
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json
    var_dump($result); // display the API response
    var_dump($jsonResult); // display the decoded JSON data
    //Just a example, please check more in there

   
// if (isset($jsonResult['message']) && $jsonResult['message'] === 'Yêu cầu bị từ chối vì số tiền giao dịch nhỏ hơn số tiền tối thiểu cho phép là 10000 VND hoặc lớn hơn số tiền tối đa cho phép là 50000000 VND.') {
//     echo $jsonResult['message'];
//     // Chuyển hướng đến trang khác
//     header('Location: ../../views/user_views/checkout.php?errormomo='.urlencode('The request is rejected because the transaction amount is less than the minimum allowed amount of VND 10,000 or greater than the maximum allowable amount of VND 50 million.'));
//   } else if (isset($jsonResult['payUrl'])) {
//     // Chuyển hướng đến trang thanh toán
    header('Location: ' . $jsonResult['payUrl']);
//   }

?>