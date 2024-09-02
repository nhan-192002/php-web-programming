<?php
include("../../../config/config.php");
session_start();
$alert='';

if (isset($_GET['action']) && $_GET['action'] == 'load_cart') {
    display_cart();
    exit();
}

if (isset($_POST['delete'])) {
    $id_cart_product = $mysqli->real_escape_string($_POST['delete']);
    if (isset($_SESSION['cart'][$id_cart_product])) {
        unset($_SESSION['cart'][$id_cart_product]);
    }

    ob_start(); // Bắt đầu bộ đệm đầu ra
    display_cart();
    $cart_content = ob_get_clean(); // Lấy nội dung đã hiển thị từ bộ đệm và lưu vào biến

    echo $cart_content; // Trả về nội dung giỏ hàng
    exit();
}
elseif (isset($_POST['subtract'])) {
    $id_cart_product = $mysqli->real_escape_string($_POST['subtract']);
    
    if (isset($_SESSION['cart'][$id_cart_product]) && $_SESSION['cart'][$id_cart_product]['quantity'] > 1) {
        $_SESSION['cart'][$id_cart_product]['quantity'] -= 1;
    }

    // Trả về nội dung giỏ hàng sau khi cập nhật
    ob_start(); // Bắt đầu bộ đệm đầu ra
    display_cart();
    $cart_content = ob_get_clean(); // Lấy nội dung đã hiển thị từ bộ đệm và lưu vào biến

    echo $cart_content; // Trả về nội dung giỏ hàng
    exit();
}

elseif (isset($_POST['add'])) {
    $id_cart_product = $mysqli->real_escape_string($_POST['add']);
    
    if (isset($_SESSION['cart'][$id_cart_product])) {
        $_SESSION['cart'][$id_cart_product]['quantity'] += 1;
    }

    ob_start(); // Bắt đầu bộ đệm đầu ra
    display_cart();
    $cart_content = ob_get_clean(); // Lấy nội dung đã hiển thị từ bộ đệm và lưu vào biến

    echo $cart_content; // Trả về nội dung giỏ hàng
    exit();
} elseif (isset($_POST['quantity_product']) && isset($_POST['id_cart_product'])) {
    $id_cart_product = $mysqli->real_escape_string($_POST['id_cart_product']);
    $quantity_product = $mysqli->real_escape_string($_POST['quantity_product']);

    if (empty($quantity_product) || $quantity_product <= 0) {
        $quantity_product = 1;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$id_cart_product])) {
        $_SESSION['cart'][$id_cart_product]['quantity'] += $quantity_product;
    } else {
        $sql = "SELECT * FROM product WHERE id_product='$id_cart_product' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_array($query);

        $_SESSION['cart'][$id_cart_product] = array(
            'id_product' => $row['id_product'],
            'name_product' => $row['name_product'],
            'img_product' => $row['img_product'],
            'price_product' => $row['price_product'],
            'quantity' => $quantity_product
        );
    }


    echo 'thêm sản phẩm vào giỏ hàng thành công !';
    exit();
} elseif (isset($_POST['pay']) && $_POST['pay'] == 'pay_cart') {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $id_user = $_SESSION['id_user'];
            $id_product = $item['id_product'];
            $quantity = $item['quantity'];
            $insert_order = "INSERT INTO cart(id_user, id_product, quantity) VALUES ('$id_user', '$id_product', '$quantity')";
            $result = mysqli_query($mysqli, $insert_order);
            if ($result) {
                unset($_SESSION['cart']);
                echo 'thanh toán thành công';
            } else {
                echo "Error: " . mysqli_error($mysqli);
            }
        }
    }
    $alert = 'thêm sản phẩm vào giỏ hàng thành công !';

}
 else {

    exit();
}


function display_cart() {
    $total_payment = 0; // Khởi tạo biến tổng thanh toán

    if (isset($_SESSION['cart'])) {
        echo '
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Delete</th>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach ($_SESSION['cart'] as $id_product) {
                            $total = $id_product["price_product"] * $id_product["quantity"];
                            $total_payment += $total;
                            echo '
                            <tr>
                                <td><a class="quantity-left-minus btn" id="button" onclick="delete_cart('.$id_product["id_product"].')">x</a></td>
                                <td>'.$id_product["id_product"].'</td>
                                <td>'.$id_product["name_product"].'</td>
                                <td><img src="../Admin-WebPHP/pages/product/uploads/'.$id_product["img_product"].'" alt="Product Image" width="200" height="200"></td>
                                <td>'.number_format($id_product["price_product"], 0, ",", ".").' VND</td>
                                <td class="quantity">
                                    <div class="input-group mb-3">
                                        <a class="quantity-right-plus btn" onclick="subtract('.$id_product["id_product"].')">-</a>
                                        <input type="text" id="quantity" name="quantity" class="quantity form-control input-number" readonly value="'.$id_product["quantity"].'" min="1" max="100">
                                        <a class="quantity-left-minus btn" onclick="add('.$id_product["id_product"].')">+</a>
                                    </div>
                                </td>
                                <td>'.number_format($total, 0, ",", ".").' VND</td>
                            </tr>';
                        }
                        echo '
                    </tbody>
                </table>
            </div>
        </div>
        <div id="pay">
            <p>Tổng số tiền cần thanh toán là <br>'.number_format($total_payment, 0, ",", ".").' VND</p>
        </div>
        <div id="pay">';
            if (isset($_SESSION["id_user"])) {
                echo '<button type="button" onclick="reset_payment()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Open Payment Modal
                        </button>';
            } else {
                echo '<a id="button" href="index.php?pages=login">Đăng ký tài khoản</a>';
            }
            echo '
        </div>';
        $_SESSION['total_payment'] = $total_payment;
    }
}

?>
