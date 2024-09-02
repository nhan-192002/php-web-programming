<?php 
    include_once('../../../config/config.php');

    if (isset($_POST['search'])) {
        $search = $mysqli->real_escape_string($_POST['search']);
        $sql_table_product = "SELECT * FROM product WHERE name_product LIKE '%".$search."%'";
    } elseif (isset($_GET['id_category'])) {
        $id_category = $mysqli->real_escape_string($_GET['id_category']);
        $sql_table_product = "SELECT * FROM category INNER JOIN product ON category.id_category = product.id_category 
                                WHERE product.id_category='$id_category' ORDER BY id_product DESC;";
    } else {

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $begin = ($page == '' || $page == 1) ? 0 : ($page * 4) - 4;

        $sql_table_product = "SELECT * FROM category INNER JOIN product ON category.id_category = product.id_category 
                                ORDER BY id_product DESC LIMIT $begin, 4";
    }
    
    $query_table_product = mysqli_query($mysqli, $sql_table_product);
    
    if(isset($_GET['category'])){
        $category = $mysqli->real_escape_string($_GET['category']); 
        echo    '<div>
                    <h1 id="button-submit">'.$category.'</h1>
                </div>';
    }else{echo "<h1><br></h1>";} 

    if (mysqli_num_rows($query_table_product) > 0) {
        while($row = mysqli_fetch_array($query_table_product)){ 
            echo '<div id="product" class="col-sm-12 col-md-6 col-lg-3 ftco-animate d-flex">
                    <div class="product d-flex flex-column">
                        <a onclick="detailproduct(' . $row['id_product'] . ')" class="img-prod"><img class="img-fluid" src="../Admin-WebPHP/pages/product/uploads/'.$row['img_product'].'" alt="Colorlib Template"></a>
                        <div id="product-text" class="text py-3 pb-4 px-3">
                            <div class="d-flex">
                                <div class="cat">
                                    <span>Mã: '.$row['id_product'].'</span>
                                </div>
                            </div>
                            <h3><a>'.$row['name_product'].'</a></h3>
                            <div class="pricing">
                                <p class="price"><span>Giá: '.number_format($row['price_product'], 0, ',', '.').' VND</span></p>
                            </div>
                            <div id="product-text" class="action">
                                <p id="button-cart" class="bottom-area d-flex">
                                    <button 
                                        id="button-input" 
                                        onclick="add_cart_product('.$row['id_product'].')" 
                                        class="btn btn-black py-3 px-5 mr-2">
                                        Thêm giỏ hàng
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>';
        }
    } else { 
        echo '<p id="text-heading" style="color: red;">Không có sản phẩm</p>'; 
    }
?>
