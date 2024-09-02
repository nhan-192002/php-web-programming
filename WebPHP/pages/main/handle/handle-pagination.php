<?php 
    include('../../../config/config.php');

    if($_GET['action']=='load_pagination'){

        $active = isset($_GET['active'])?$_GET['active']:1;

        $sql_trang = mysqli_query($mysqli,"SELECT * FROM product");
        $row_count = mysqli_num_rows($sql_trang);  
        $trang = ceil($row_count/4);

        for($i=1;$i<=$trang;$i++){
            echo '<li class="page-item '.($i == $active ? 'active' : '').'"><a class="page-link" onclick="pagination('.$i.')">'.$i.'</a></li>';
        }
        
    }
    
?>