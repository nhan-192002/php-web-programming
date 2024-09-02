<?php 
    include('../../../config/config.php');

    if (isset($_GET['action']) && $_GET['action'] == 'load-orders') {

        $sql_table_order = "SELECT * FROM paymentcart  ORDER BY id_pay DESC;";
        $query_table_order = mysqli_query($mysqli, $sql_table_order);

        echo    '<thead>
                    <tr>
                        <th>Payment method</th>
                        <th>Total</th>
                        <th>Note</th>
                        <th>Order ID</th>
                        <th>trans ID</th>
                        <th>Order details</th>
                        <th>confirm</th>
                        <th>Date Time</th>
                    </tr>
                </thead>
                <tbody>';
            
        while ($row = mysqli_fetch_array($query_table_order)) { 
            echo    '<tr class="odd gradeX">
                        <td>' . $row['pay'] . '</td>
                        <td>' . number_format($row['total'], 0, ",", ".") . ' VND</td>
                        <td>' . $row['note'] . '</td>
                        <td>' . $row['orderId'] . '</td>
                        <td>' . $row['transId'] . '</td>
                        <td>' . $row['date_time'] . '</td>
                        <td>';
                        if ($row['confirm'] =='0') {
                            echo '<button class="btn btn-primary" onclick="confirm_order(' . $row['id_pay'] . ')" type="button">Order confirm</button>';
                        } else {
                            echo 'đơn hàng đã xác nhận';
                        }
                    echo '</td>
                        <td><button class="btn btn-primary" onclick="order_details('.$row['id_pay'].','.$row['id_user'].')" type="button">Order details</button></td>
                    </tr>';
        }
        echo '</tbody>';
    }elseif (isset($_GET['id_pay']) && isset($_GET['action']) && $_GET['action'] == 'load-order-details') {
        $id_pay = $mysqli->real_escape_string($_GET['id_pay']);

        $sql_table_order_details = "SELECT * FROM cart 
                                    INNER JOIN product ON cart.id_product = product.id_product
                                    -- INNER JOIN paymentcart ON cart.id_pay = paymentcart.id_pay
                                    WHERE cart.id_pay = '$id_pay' 
                                    ORDER BY cart.id_product DESC;";
        $query_table_order = mysqli_query($mysqli, $sql_table_order_details);

        echo    '<thead>
                    <tr>
                        <th><button class="btn btn-primary" onclick="back_order_details()" type="button">back</button> Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>';
            
        while ($row = mysqli_fetch_array($query_table_order)) { 
            echo    '<tr class="odd gradeX">
                        <td>' . $row['name_product'] . '</td>
                        <td><img src="pages/product/uploads/'.$row['img_product'].'" alt="đang tải ảnh..." width="250" height="out"></td>
                        <td>' . number_format($row['price_product'], 0, ",", ".") . ' VND</td>
                        <td>' . $row['quantity'] . '</td>
                    </tr>';
        }
        echo '</tbody>';                    
            
    }

    // if(isset($_GET['action']) && $_GET['action'] =='load-user-orders' && isset($_GET['id_pay_orders'])){
    //     $id_pay_orders = $mysqli->real_escape_string($_GET['id_pay_orders']);   

    //     $sql_account = "SELECT * FROM paymentcart INNER JOIN user ON paymentcart.id_user = user.id WHERE paymentcart.id_pay='$id_pay_orders' LIMIT 1";
    //     $result_account = mysqli_query($mysqli, $sql_account);

    //     if (mysqli_num_rows($result_account) > 0) {
    //         while ($row = mysqli_fetch_array($result_account)) {
    //             echo '<div class="card-body">
    //                     <div class="row">
    //                         <div class="col-sm-3">
    //                             <p class="mb-0">Name:</p>
    //                         </div>
    //                         <div class="col-sm-9">
    //                             <p class="mb-0">'.isset($row['name_order'])?$row['name_order']:$row['name'].'</p>
    //                         </div>
    //                     </div>
    //                     <div class="row">
    //                         <div class="col-sm-3">
    //                             <p class="mb-0">Email:</p>
    //                         </div>
    //                         <div class="col-sm-9">
    //                             <p class="mb-0">'.$row['email'].'</p>
    //                         </div>
    //                     </div>
    //                     <div class="row">
    //                         <div class="col-sm-3">
    //                             <p class="mb-0">Phone:</p>
    //                         </div>
    //                         <div class="col-sm-9">
    //                             <p class="mb-0">'.isset($row['phone_order'])?$row['phone_order']:$row['phone'].'</p>
    //                         </div>
    //                     </div>  
    //                     <div class="row">
    //                         <div class="col-sm-3">
    //                             <p class="mb-0">Address:</p>
    //                         </div>
    //                         <div class="col-sm-9">
    //                             <p class="mb-0">'.isset($row['address_order'])?$row['address_order']:$row['address'].'</p>
    //                         </div>
    //                     </div>
    //                 </div>';
    //         }
    //     }
    // }

    if (isset($_GET['action']) && $_GET['action'] == 'load-user-orders' && isset($_GET['id_pay_orders'])) {
        $id_pay_orders = $mysqli->real_escape_string($_GET['id_pay_orders']);   
    
        $sql_account = "SELECT * FROM paymentcart INNER JOIN user ON paymentcart.id_user = user.id WHERE paymentcart.id_pay='$id_pay_orders' LIMIT 1";
        $result_account = mysqli_query($mysqli, $sql_account);
    
        if (!$result_account) {
            echo "Lỗi truy vấn: " . $mysqli->error;
            exit;
        }
    
        if (mysqli_num_rows($result_account) > 0) {
            while ($row = mysqli_fetch_array($result_account)) {
                $name = $row['name_order']!='' ? htmlspecialchars($row['name_order']) : htmlspecialchars($row['name']);
                $phone = $row['phone_order']!='' ? htmlspecialchars($row['phone_order']) : htmlspecialchars($row['phone']);
                $address = $row['address_order']!='' ? htmlspecialchars($row['address_order']) : htmlspecialchars($row['address']);
                $confirm = $row['confirm']=='0' ? htmlspecialchars('Đơn hàng chưa xác nhận') : htmlspecialchars('Đơn hàng đã xác nhận');
                
                echo '<div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Name:</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">' . $name . '</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email:</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">' . htmlspecialchars($row['email']) . '</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phone:</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">' . $phone . '</p>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Address:</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">' . $address . '</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">confirm:</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">' . $confirm . '</p>
                            </div>
                        </div>
                    </div>';
            }
        }
    }

    if(isset($_POST['id_pay_confirmOrder'])){
        $id_pay_cofirmOrder = $mysqli->real_escape_string($_POST['id_pay_confirmOrder']);

        $result_check = mysqli_query($mysqli, "SELECT confirm FROM paymentcart WHERE id_pay='$id_pay_cofirmOrder'");
        $row_check = mysqli_fetch_assoc($result_check);
        $new_status = ($row_check['confirm'] == 1) ? 0 : 1;
        
        $sql_update = "UPDATE paymentcart SET confirm='$new_status' WHERE id_pay='$id_pay_cofirmOrder'";
        $result_update = mysqli_query($mysqli, $sql_update);
    
        if ($result_update && mysqli_affected_rows($mysqli) > 0) {
            echo 'xác nhận đơn hàng thành công';
        } else {
            echo "Thao tác thất bại";
        }
    }

?>
