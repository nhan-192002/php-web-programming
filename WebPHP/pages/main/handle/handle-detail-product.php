<?php
    include_once('../../../config/config.php');

    if(isset($_GET['id_product'])){
        $id_product = $mysqli->real_escape_string($_GET['id_product']);
        $sql_table_product = "SELECT * FROM category INNER JOIN product ON category.id_category = product.id_category 
                                WHERE product.id_product='$id_product' ORDER BY id_product DESC;";
        $query_table_product = mysqli_query($mysqli, $sql_table_product);

        if(mysqli_num_rows($query_table_product) >0){
            while($row = mysqli_fetch_array($query_table_product)){
                $name_category = $row['name_category'];
                $name_product = $row['name_product'];
                $price_product = $row['price_product'];
                $image_product = $row['img_product'];
                $content_product = $row['content_product'];
            }
            echo '<form method="POST">
                        <div class="wrapper row">
                            <div class="preview col-md-6">
                                    <div>
                                        <img src="../Admin-WebPHP/pages/product/uploads/'.$image_product.'" width="100%" height="out">
                                    </div>
                            </div>
                            <div class="details col-md-6">
                                <h3 class="product-title">'.$name_product.'</h3>
                                <h4 class="price">Giá: <span>'.number_format($price_product,0,',','.').'VND'.'</span></h4>
                                <p class="vote"><strong>100%</strong> hàng <strong>Chất lượng</strong>, đảm bảo
                                    <strong>Uy
                                        tín</strong>!</p>
                                <div class="form-group">
                                    <label for="soluong">Số lượng đặt mua:</label>
                                    <input type="number" class="form-control" id="quantity_product" name="quantity_product" value="1" min="1" max="100">
                                </div>
                                <div class="container-fluid">
                                    <br>
                                    <h3>Thông tin chi tiết về '.$name_product.'</h3>
                                    <div class="row">
                                        <div class="col">
                                            '.$content_product.'
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <input type="hidden" name="id_product" value="'.$id_product.'">
                                <div id="product-text" class="action">
                                    <p id="button-cart" class="bottom-area d-flex">
                                        <input id="button-input" class="btn btn-black py-3 px-5 mr-2 add-cart" type="submit" value="Thêm giỏ hàng">
                                    </p>
                                </div>
                            </div>

                        </div>
                    </form>';
        }
    }

    if(isset($_GET['action']) && $_GET['action']=='reviews-product'){
        echo '
            <div class="review-form">
                <form id="reviewForm" onsubmit="event.preventDefault(); submitReview();">
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea id="comment" name="comment" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Rating:</label>
                        <div class="star-rating">
                            <input type="radio" id="5-stars" name="rating" value="5" />
                            <label for="5-stars" class="star">&#9733;</label>
                            <input type="radio" id="4-stars" name="rating" value="4" />
                            <label for="4-stars" class="star">&#9733;</label>
                            <input type="radio" id="3-stars" name="rating" value="3" />
                            <label for="3-stars" class="star">&#9733;</label>
                            <input type="radio" id="2-stars" name="rating" value="2" />
                            <label for="2-stars" class="star">&#9733;</label>
                            <input type="radio" id="1-star" name="rating" value="1" />
                            <label for="1-star" class="star">&#9733;</label>
                        </div>
                    </div>
                    <button type="submit">Submit Review</button>
                </form>
            </div>
        ';
    }
?>