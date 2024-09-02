<?php
include('../../../config/config.php');
session_start();

// if(isset($_GET['action']) && $_GET['action']=='load-payment'){
//     if(isset($_SESSION['id_user'])){
//         $id_user = $_SESSION['id_user'];
//         $sql_account = "SELECT * FROM user WHERE id='$id_user' LIMIT 1";
//         $result_account = mysqli_query($mysqli, $sql_account);

//         if (mysqli_num_rows($result_account) > 0) {
//             while ($row = mysqli_fetch_array($result_account)) {
//                 echo '
//                     <div class="mb-3">
//                         <label for="noteInput" class="form-label">Ghi chú</label>
//                         <textarea class="form-control" id="noteInput" placeholder="Ghi chú cho đơn hàng (không bắt buộc)"></textarea>
//                     </div>
//                     <div class="mb-3">
//                         <label for="addressInput" class="form-label">Tổng tiền thanh toán</label>
//                         <input value="'.number_format($_SESSION['total_payment'], 0, ",", ".").' VND" type="text" class="form-control" readonly>
//                         <input type="hidden" id="totalInput" value="'.$_SESSION['total_payment'].'">
//                     </div>
//                     <div class="mb-3">
//                         <label for="select-pay" class="form-label">Phương thức thanh toán</label>
//                         <select class="form-select" id="select-pay">
//                             <option value="" selected>Chọn phương thức thanh toán</option>
//                             <option value="COD">COD</option>
//                             <option value="MOMO">MOMO</option>
//                         </select>
//                     </div>
//                     <label for="toggle-inputs">
//                         <input type="checkbox" id="toggle-inputs"> Show additional inputs
//                     </label>
//                      <div style="display: none;">
//                         <input type="text" placeholder="Input 1"><br>
//                         <input type="text" placeholder="Input 2"><br>
//                         <input type="text" placeholder="Input 3"><br>
//                     </div>
//                     ';
//             }
//         }
//     }
// }

if(isset($_GET['action']) && $_GET['action']=='load-payment'){
    
    echo '
        
            <label for="addressInput" class="form-label">Tổng tiền thanh toán</label>
            <input value="'.number_format($_SESSION['total_payment'], 0, ",", ".").' VND" type="text" class="form-control" readonly>
            <input type="hidden" id="totalInput" value="'.$_SESSION['total_payment'].'">
        
        ';
}


if(isset($_POST['pay']) && isset($_POST['total'])){
        $pay = $mysqli->real_escape_string($_POST['pay']);
        $total = $mysqli->real_escape_string($_POST['total']);
        $note = $mysqli->real_escape_string($_POST['note']);
        $name_order = $mysqli->real_escape_string($_POST['name_order']);
        $phone_order = $mysqli->real_escape_string($_POST['phone_order']);
        $address_order = $mysqli->real_escape_string($_POST['address_order']);


        $_SESSION['payment']=array(
            'pay' => $pay,
            'total' => $total,
            'note' => $note,
            'name_order' => $name_order,
            'phone_order' => $phone_order,
            'address_order' => $address_order

        );
        echo $_POST['pay'];
}

if(isset($_POST['orderId']) && isset($_POST['transId'])){
    if (isset($_SESSION['cart']) && isset($_SESSION['payment'])) { 
        $id_userPay = $_SESSION['id_user'];
        $pay = $_SESSION['payment']['pay'];
        $total = $_SESSION['payment']['total'];
        $note = $_SESSION['payment']['note'];
        $name_order = $_SESSION['payment']['name_order'];
        $phone_order = $_SESSION['payment']['phone_order'];
        $address_order = $_SESSION['payment']['address_order'];
        $orderId = $mysqli->real_escape_string($_POST['orderId']);
        $transId = $mysqli->real_escape_string($_POST['transId']);
        $date_time = date('H:i:s d-m-Y');

        $sql_pay = "INSERT INTO paymentCart(id_user, pay, total, note, orderId, transId, name_order, phone_order, address_order, date_time) VALUES ('$id_userPay','$pay', '$total', '$note', '$orderId', '$transId', '$name_order', '$phone_order', '$address_order', '$date_time')";

        $quantity_pay = mysqli_query($mysqli, $sql_pay);

        $id_pay = $mysqli->insert_id;

        if($quantity_pay){
            
            foreach ($_SESSION['cart'] as $item) {
                $id_user = $_SESSION['id_user'];
                $id_product = $item['id_product'];
                $quantity = $item['quantity'];
                $insert_order = "INSERT INTO cart(id_user, id_pay, id_product, quantity) VALUES ('$id_user', '$id_pay', '$id_product', '$quantity')";
                $result = mysqli_query($mysqli, $insert_order);
            }
            unset($_SESSION['cart']);
            unset($_SESSION['payment']);
            echo 'thanh toán thành công';        
        }
    }else{
        echo 'thanh toán thất bại';
    }
} else if(isset($_POST['payment'])){
    if (isset($_SESSION['cart']) && isset($_SESSION['payment'])) { 
        $id_userPay = $_SESSION['id_user'];
        $pay = $_SESSION['payment']['pay'];
        $total = $_SESSION['payment']['total'];
        $note = $_SESSION['payment']['note'];
        $name_order = $_SESSION['payment']['name_order'];
        $phone_order = $_SESSION['payment']['phone_order'];
        $address_order = $_SESSION['payment']['address_order'];
        $orderId = rand(0000000000,9999999999);
        $date_time = date('H:i:s d-m-Y');

        $sql_pay = "INSERT INTO paymentCart(id_user, pay, total, note, orderId, name_order, phone_order, address_order, date_time) VALUES ('$id_userPay','$pay', '$total', '$note', '$orderId', '$name_order', '$phone_order' , '$address_order', '$date_time')";

        $quantity_pay = mysqli_query($mysqli, $sql_pay);

        $id_pay = $mysqli->insert_id;

        if($quantity_pay){
            
            foreach ($_SESSION['cart'] as $item) {
                $id_user = $_SESSION['id_user'];
                $id_product = $item['id_product'];
                $quantity = $item['quantity'];
                $insert_order = "INSERT INTO cart(id_user, id_pay, id_product, quantity) VALUES ('$id_user', '$id_pay', '$id_product', '$quantity')";
                $result = mysqli_query($mysqli, $insert_order);
            }
            unset($_SESSION['cart']);
            unset($_SESSION['payment']);
            echo 'đặt hàng thành công';     
        }
    }else{
        echo 'đặt hàng thất bại';
    }
}

?>