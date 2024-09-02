<?php 
    $alert='';
    if (isset($_GET['alert'])) {
        $alert = $mysqli->real_escape_string($_GET['alert']);
    }

    if(isset($_GET['id_edit_category'])){
        $show_category = $mysqli->real_escape_string($_GET['id_edit_category']);
        
        $sql_show_category = "SELECT * FROM category WHERE id_category='$show_category';";
        $query_show_category = mysqli_query($mysqli, $sql_show_category);

        if(mysqli_num_rows($query_show_category) >0){
            while($row = mysqli_fetch_array($query_show_category)){
                $form_category = $row['name_category'];
            }
        }
    }

    if(isset($_POST['reset-form-category'])){
        header("location: index.php?pages=add-category");
    }

    if (isset($_GET['id_delete_category'])) {
        $id_delete_category = $mysqli->real_escape_string($_GET['id_delete_category']);
        $sql_delete = "DELETE FROM category WHERE id_category = '$id_delete_category'";
        $query_delete = mysqli_query($mysqli, $sql_delete);
        if($query_delete){
            $alert = "xóa thành công danh mục id: $id_delete_category";
            header("Location: index.php?pages=add-category&alert=$alert");
        }

    }elseif(isset($_POST['add-category']) && isset($_GET['id_edit_category'])){
        $id_edit_category = $mysqli->real_escape_string($_GET['id_edit_category']);
        $name_category = $mysqli->real_escape_string($_POST['name_category']);

        $sql_update = "UPDATE category SET name_category='$name_category' WHERE id_category='$id_edit_category'";
        $result_update = mysqli_query($mysqli, $sql_update);
        if ($result_update && mysqli_affected_rows($mysqli) > 0){
            $alert = "Sửa thành công danh mục id: $id_edit_category ($form_category)->($name_category)";
            header("Location: index.php?pages=add-category&alert=$alert");
        }else{
            $alert = "Sửa thất bại";
            header("Location: index.php?pages=add-category&alert=$alert");
        }


    }elseif(isset($_POST['add-category'])){
        $name_category = $mysqli->real_escape_string($_POST['name_category']);

        $sql_add_category = "INSERT INTO category(name_category) VALUE('".$name_category."')";
        $result_add_category = mysqli_query($mysqli, $sql_add_category);
        if ($result_add_category && mysqli_affected_rows($mysqli) > 0) {
            $alert = "thêm danh mục sản phẩm thành công";
        } else {
            $alert = "thêm danh mục sản phẩm Thất bại";
        }
    }
    
?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Categoty</h2>
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
                                <form role="form" method="POST">
                                    <div class="form-group">
                                        <label>Name Category</label>
                                        <input name="name_category" class="form-control" value="<?php echo isset($form_category)?$form_category:null ?>"/>
                                    </div>  
                                    <button name="add-category" type="submit" class="btn btn-default">Submit Button</button>
                                    <button name="reset-form-category" class="btn btn-primary">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("pages/category/table-category.php") ?>
    </div>
</div>
