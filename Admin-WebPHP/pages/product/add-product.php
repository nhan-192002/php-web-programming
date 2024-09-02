<?php
    $alert='';
    if (isset($_GET['alert'])) {
        $alert = $mysqli->real_escape_string($_GET['alert']);
    }

    if(isset($_GET['id_edit_product'])){
        $show_product = $mysqli->real_escape_string($_GET['id_edit_product']);
        
        $sql_show_product = "SELECT * FROM product WHERE id_product='$show_product';";
        $query_show_product = mysqli_query($mysqli, $sql_show_product);

        if(mysqli_num_rows($query_show_product) >0){
            while($row = mysqli_fetch_array($query_show_product)){
                $name_edit_product = $row['name_product'];
                $price_edit_product = $row['price_product'];
                $image_edit_product = $row['img_product'];
                $content_edit_product = $row['content_product'];
                $category_edit_product = $row['id_category'];
            }
        }
    }

    if(isset($_POST['reset-form-product'])){
        header("location: index.php?pages=add-product");
    }
   
    $sql_table_product = "SELECT * FROM category ORDER BY id_category DESC;";
    $query_table_product = mysqli_query($mysqli, $sql_table_product);

    if (isset($_GET['id_delete_product'])) {
        $id_delete_product = $mysqli->real_escape_string($_GET['id_delete_product']);
        $sql_delete = "DELETE FROM product WHERE id_product = '$id_delete_product'";
        $query_delete = mysqli_query($mysqli, $sql_delete);
        if($query_delete){
            $alert = "xóa thành công sản phẩm id: $id_delete_product";
            header("Location: index.php?pages=add-product&alert=$alert");
        }
    }
    elseif(isset($_POST['add-product']) && isset($_GET['id_edit_product'])){
        if(isset($_FILES['image_product']) && $_FILES['image_product']['error'] == UPLOAD_ERR_OK)
        {
            $id_edit_product = $mysqli->real_escape_string($_GET['id_edit_product']);

            $name_product = $mysqli->real_escape_string($_POST['name_product']);
            $price_product = $mysqli->real_escape_string($_POST['price_product']);
            $content_product = $mysqli->real_escape_string($_POST['content_product']);
            $category = $mysqli->real_escape_string($_POST['category']); 
            
            // Xử lý tải lên hình ảnh
            $image_product = $_FILES['image_product']['name'];
            $image_product_tmp = $_FILES['image_product']['tmp_name'];
            $image_product = time().'_'.$image_product;

            $sql_update = "UPDATE product SET name_product='$name_product',price_product='$price_product',img_product='$image_product',content_product='$content_product',id_category='$category' WHERE id_product='$id_edit_product'";
            $result_update = mysqli_query($mysqli, $sql_update);
            if ($result_update && mysqli_affected_rows($mysqli) > 0){
                move_uploaded_file($image_product_tmp,'pages/product/uploads/'.$image_product);
                $alert = "Sửa thành công sản phẩm img";
                header("Location: index.php?pages=add-product&alert=$alert");
            }else{
                $alert = "Sửa thất bại img";
                header("Location: index.php?pages=add-product&alert=$alert");
            }
        }else{
            $id_edit_product = $mysqli->real_escape_string($_GET['id_edit_product']);

            $name_product = $mysqli->real_escape_string($_POST['name_product']);
            $price_product = $mysqli->real_escape_string($_POST['price_product']);
            $content_product = $mysqli->real_escape_string($_POST['content_product']);
            $category = $mysqli->real_escape_string($_POST['category']); 

            $sql_update = "UPDATE product SET name_product='$name_product',price_product='$price_product',content_product='$content_product',id_category='$category' WHERE id_product='$id_edit_product'";
            $result_update = mysqli_query($mysqli, $sql_update);
            if ($result_update && mysqli_affected_rows($mysqli) > 0){
                $alert = "Sửa thành công sản phẩm";
                header("Location: index.php?pages=add-product&alert=$alert");
            }else{
                header("Location: index.php?pages=add-product");
            }
        }
    }
    elseif(isset($_POST['add-product'])) {
        $name_product = $mysqli->real_escape_string($_POST['name_product']);
        $price_product = $mysqli->real_escape_string($_POST['price_product']);
        $content_product = $mysqli->real_escape_string($_POST['content_product']);
        $category = $mysqli->real_escape_string($_POST['category']); 
        
        // Xử lý tải lên hình ảnh
        $image_product = $_FILES['image_product']['name'];
        $image_product_tmp = $_FILES['image_product']['tmp_name'];
        $image_product = time().'_'.$image_product;

        $sql_add_product = "INSERT INTO product (name_product, price_product, img_product, content_product, id_category) VALUES ('$name_product', '$price_product', '$image_product', '$content_product', '$category')";
	    $result_add_product = mysqli_query($mysqli,$sql_add_product);

        if ($result_add_product && mysqli_affected_rows($mysqli) > 0) {
            move_uploaded_file($image_product_tmp,'pages/product/uploads/'.$image_product);
            $alert = "thêm sản phẩm thành công";
            header("Location: index.php?pages=add-product&alert=$alert");
        } else {
            $alert = "thêm sản phẩm Thất bại";
            header("Location: index.php?pages=add-product&alert=$alert");
        }
    }
?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>product</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row" style="margin: auto;justify-content: center;display: flex;">
                            <div class="col-md-9">
                                <p style="color: #f00;"><?php echo $alert ? $alert : null ?></p>
                                <form method="POST" enctype="multipart/form-data" role="form">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input value="<?php echo isset($name_edit_product)?$name_edit_product:null ?>" name="name_product" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Pice</label>
                                        <input value="<?php echo isset($price_edit_product)?$price_edit_product:null ?>" name="price_product" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="image_product" class="form-control" />
                                        <?php 
                                            if (isset($image_edit_product)) {
                                                echo '<img src="pages/product/uploads/' . htmlspecialchars($image_edit_product, ENT_QUOTES, 'UTF-8') . '" alt="" width="200" height="auto">';
                                            } else {
                                                echo '';
                                            }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea name="content_product" class="form-control" rows="3"><?php echo isset($content_edit_product)?$content_edit_product:null ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>category</label>
                                        <select id="mySelect" class="form-control" name="category">
                                            <?php while($row = mysqli_fetch_array($query_table_product)){?>
                                                <option value="<?php echo $row['id_category'] ?>"><?php echo $row['name_category'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button name="add-product" type="submit" class="btn btn-default">Submit Button</button>
                                    <button name="reset-form-product" class="btn btn-primary">Cancel</button>

                                </form>
                               


                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Form Elements -->
            </div>
        </div>
        <?php include("pages/product/table-product.php") ?>
    </div>
</div>
<script>
    document.getElementById('mySelect').value = '<?php echo isset($category_edit_product)? $category_edit_product:null ?>'; // Đặt giá trị của tùy chọn mặc định
</script>