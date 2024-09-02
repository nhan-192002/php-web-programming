<?php
include_once('../../config/config.php');
session_start();

if (isset($_GET['log_out'])) {
    unset($_SESSION['id_user']);
    echo json_encode(['status' => 'success']); // Trả về JSON
    exit();
}

// Phần còn lại của mã PHP để xử lý danh mục
$sql_table_category = "SELECT * FROM category ORDER BY id_category DESC;";
$query_table_category = mysqli_query($mysqli, $sql_table_category);


while($row = mysqli_fetch_array($query_table_category)){ 
    echo '<li><a class="dropdown-item" href="#" onclick="myFunction(\'' . $row['name_category'] . '\', ' . $row['id_category'] . ')">' . $row['name_category'] . '</a></li>';
}
?>
