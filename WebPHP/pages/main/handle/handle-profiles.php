<?php
    include('../../../config/config.php');
    session_start();

    if(isset($_GET['action']) && $_GET['action']=='load_profiles'){

        if(isset($_SESSION['id_user'])){
            $id_user = $_SESSION['id_user'];
            $sql_account = "SELECT * FROM user WHERE id='$id_user' LIMIT 1";
            $result_account = mysqli_query($mysqli, $sql_account);

            if (mysqli_num_rows($result_account) > 0) {
                while ($row = mysqli_fetch_array($result_account)) {
                    echo '<div class="card mb-4">
                            <div class="card-body text-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                <h5 class="my-3">'.$row['name'].'</h5>
                                <div class="d-flex justify-content-center mb-2">
                                    <button onclick="logOut()" id="log-out" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Log Out</button>
                                    <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Edit Profiles</button>
                                    <button data-bs-toggle="modal" data-bs-target="#editPassword" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Edit Password</button>
                                </div>
                            </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Full Name</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">'.$row['name'].'</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Email</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">'.$row['email'].'</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Phone</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">'.$row['phone'].'</p>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Address</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">'.$row['address'].'</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }
            }
        }
    }

    if(isset($_GET['action']) && $_GET['action']=='load_cart_profiles'){

        if($_SESSION['id_user']){
            $id_user = $_SESSION['id_user'];
            // $sql_table_cart_profiles = "SELECT * FROM cart 
            //                             INNER JOIN product ON cart.id_product = product.id_product
            //                             INNER JOIN paymentcart ON cart.id_pay = paymentcart.id_pay
            //                             WHERE cart.id_user = '$id_user' 
            //                             ORDER BY cart.id_pay DESC;";
            $sql_table_cart_profiles = "SELECT * FROM paymentcart 
                                        WHERE id_user = '$id_user' 
                                        ORDER BY id_pay DESC;";
            $query_table_cart_profires = mysqli_query($mysqli, $sql_table_cart_profiles);
            if(mysqli_num_rows($query_table_cart_profires)>0){
                while($row = mysqli_fetch_array($query_table_cart_profires)){
                    echo '<tr onclick="openDetailCart('.$row['id_pay'].')">
                            <td>'.$row['pay'].'</td>
                            <td>'.number_format($row['total'], 0, ",", ".").' VND</td>
                            <td>'.$row['note'].'</td>
                            <td>'.$row['orderId'].'</td>
                            <td class="text-center">'.$row['transId'].'</td>
                            <td>'.$row['date_time'].'</td>
                        </tr>';
                }
            }    
        }
    }

    if(isset($_GET['action']) && $_GET['action']=='load_edit_profiles'){
        if($_SESSION['id_user']){
            $id_user = $_SESSION['id_user'];
            $sql_editProfiles = "SELECT * FROM user WHERE id='$id_user' LIMIT 1";
            $query_editProfiles = mysqli_query($mysqli, $sql_editProfiles);
            if(mysqli_num_rows($query_editProfiles)>0){
                while($row = mysqli_fetch_array($query_editProfiles)){
                    echo '<div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Profiles</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p id="text-heading" class="resurt" style="color: red;"></p>
                                <form>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input value="'.$row['name'].'" type="text" class="form-control" id="name" placeholder="Enter your name" autocomplete="name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">phone</label>
                                        <input value="'.$row['phone'].'" type="text" class="form-control" id="phone" placeholder="Enter your phone" autocomplete="tel">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">address</label>
                                        <input value="'.$row['address'].'" type="text" class="form-control" id="address" placeholder="Enter your address"   autocomplete="street-address">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="editProfiles()" type="button" class="btn btn-primary">Edit Profiles</button>
                            </div>';
                }
            }
        }
    }

    if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address'])) {
        if (isset($_SESSION['id_user'])) {
            $name = $mysqli->real_escape_string($_POST['name']);
            $phone = $mysqli->real_escape_string($_POST['phone']);
            $address = $mysqli->real_escape_string($_POST['address']);
            $id_user = $_SESSION['id_user'];
    
            $sql_editProfiles_form = "UPDATE user SET name='$name', phone='$phone', address='$address' WHERE id='$id_user'";
            $query_editProfiles_form = mysqli_query($mysqli, $sql_editProfiles_form);
    
            if ($query_editProfiles_form || mysqli_affected_rows($mysqli) > 0) {
                echo 'edit thành công';
            } else {
                echo 'edit thất bại!!';
            }
        }
    } 
    
    
    if (isset($_POST['oldPassword']) && isset($_POST['newPassword'])) {
        if (isset($_SESSION['id_user'])) {
            $id_user = $_SESSION['id_user'];
            $oldPassword = $mysqli->real_escape_string($_POST['oldPassword']);

            $sql_password = "SELECT * FROM user WHERE id='$id_user' LIMIT 1";
            $result_password = mysqli_query($mysqli, $sql_password);

            while($row = mysqli_fetch_array($result_password)){
                $oldPassword1 = $row['password'];
            }

            if (password_verify($oldPassword, $oldPassword1)) {
                $options = [
                    'cost' => 12, // Tăng độ mạnh của băm
                ];
                $newPassword = $mysqli->real_escape_string(password_hash($_POST['newPassword'], PASSWORD_BCRYPT, $options));
        
                $sql_editPassword = "UPDATE user SET password='$newPassword' WHERE id='$id_user'";
                $query_editPassword = mysqli_query($mysqli, $sql_editPassword);
        
                if ($query_editPassword && mysqli_affected_rows($mysqli) > 0) {
                    echo 'Sửa mật khẩu thành công';
                } else {
                    echo 'Sửa mật khẩu thất bại thất bại!!';
                }
            } else {
                echo 'mật khẩu cũ không chính xác';
            }
        }

        
    }

    if(isset($_GET['action'])=='load_detailCart' && isset($_GET['id_pay'])){
        $id_pay = $mysqli->real_escape_string($_GET['id_pay']);

        $sql_table_detail_cart = "SELECT * FROM cart 
                                    INNER JOIN product ON cart.id_product = product.id_product
                                    INNER JOIN paymentcart ON cart.id_pay = paymentcart.id_pay
                                    WHERE cart.id_pay = '$id_pay' 
                                    ORDER BY cart.id_pay DESC;";
        $query_table_detail_cart = mysqli_query($mysqli, $sql_table_detail_cart);
        if(mysqli_num_rows($query_table_detail_cart)>0){
            while($row = mysqli_fetch_array($query_table_detail_cart)){
                echo'
                    <tr>
                        <td>'.$row['name_product'].'</td>
                        <td><img src="../Admin-WebPHP/pages/product/uploads/'.$row['img_product'].'" alt="Product Image" width="200" height="200"></td>
                        <td>'.number_format($row['price_product'], 0, ",", ".").' VND</td>
                        <td class="text-center">'.$row['quantity'].'</td>
                        <td>'.number_format($row['price_product']*$row['quantity'], 0, ",", ".").' VND</td>
                        <td>'.$row['pay'].'</td>
                    </tr>
                ';
            }
        }
    }
    



?>