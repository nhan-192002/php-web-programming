<?php
    $sql_table_category = "SELECT * FROM category ORDER BY id_category DESC;";
    $query_table_category = mysqli_query($mysqli, $sql_table_category);
?>

                <div class="row">
                    <div class="col-md-12">
                        <h2>Table Categoty</h2>
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
                                                <th>ID Category</th>
                                                <th>Name Category</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($row = mysqli_fetch_array($query_table_category)){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $row['id_category'] ?></td>
                                                <td><?php echo $row['name_category'] ?></td>
                                                <td>
                                                <a id="button" href="index.php?pages=add-category&id_edit_category=<?php echo $row['id_category']; ?>">Edit</a>
                                                </td>
                                                <td>
                                                <a id="button" href="index.php?pages=add-category&id_delete_category=<?php echo $row['id_category'];?>">Delete</a>
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
                <!-- /. ROW  -->


        <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>