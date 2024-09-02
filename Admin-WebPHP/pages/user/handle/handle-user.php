<?php 
include('../../../config/config.php');

if (isset($_GET['action']) && $_GET['action'] == 'load-user') {

    if(isset($_GET['filter'])){
        $filter_table = $mysqli->real_escape_string($_GET['filter']);
        $sql_table_user = "SELECT * FROM user ORDER BY $filter_table ASC;";
        $query_table_user = mysqli_query($mysqli, $sql_table_user);
    }else{
        $sql_table_user = "SELECT * FROM user ORDER BY id DESC;";
        $query_table_user = mysqli_query($mysqli, $sql_table_user);
    }

    while ($row = mysqli_fetch_array($query_table_user)) { 
        echo '
        <tr class="odd gradeX">
            <td>' . $row['id'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['name'] . '</td>
            <td>' . $row['address'] . '</td>
            <td>' . $row['phone'] . '</td>
            <td>';
                if ($row['check_account'] == 1) {
                    echo '<button class="btn btn-primary" onclick="userlock(' . $row['id'] . ')" type="button">User Lock</button>';
                } else {
                    echo '<button class="btn btn-primary" onclick="userlock(' . $row['id'] . ')" type="button">Unlock User</button>';
                }
            echo '</td>
        </tr>';
    } 
}

if (isset($_POST['id_user'])) {
    $id_user = $mysqli->real_escape_string($_POST['id_user']); 
    

    $result_check = mysqli_query($mysqli, "SELECT check_account FROM user WHERE id='$id_user'");
    $row_check = mysqli_fetch_assoc($result_check);
    $new_status = ($row_check['check_account'] == 1) ? 0 : 1;
    
    $sql_update = "UPDATE user SET check_account='$new_status' WHERE id='$id_user'";
    $result_update = mysqli_query($mysqli, $sql_update);

    if ($result_update && mysqli_affected_rows($mysqli) > 0) {
        echo ($new_status == 1) ? 'Unlock user thành công' : 'Khóa user thành công';
    } else {
        echo "Thao tác thất bại";
    }
}
?>
