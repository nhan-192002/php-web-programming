<?php
    $sql_table_product = "SELECT * FROM category INNER JOIN product ON category.id_category = product.id_category ORDER BY id_product DESC;";
    $query_table_product = mysqli_query($mysqli, $sql_table_product);
?>


<div class="row">
    <div class="col-md-12">
        <h2>Table product</h2>  
        
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover"
                        id="dataTables-example">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Content</th>
                                <th>category</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = mysqli_fetch_array($query_table_product)){ ?>
                            <tr class="odd gradeX">
                                <td><?php echo $row['id_product'] ?></td>
                                <td><?php echo $row['name_product'] ?></td>
                                <td><?php echo $row['price_product'] ?></td>
                                <td><img src="pages/product/uploads/<?php echo $row['img_product'] ?>" alt="" width="300" height="out"></td>
                                <td><?php echo $row['content_product'] ?></td>
                                <td><?php echo $row['name_category'] ?></td>
                                <td>
                                <a id="button" href="index.php?pages=add-product&id_edit_product=<?php echo $row['id_product']; ?>">Edit</a> 
                                </td>
                                <td>
                                <a id="button" href="index.php?pages=add-product&id_delete_product=<?php echo $row['id_product']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>

