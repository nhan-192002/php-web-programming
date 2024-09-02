<?php
include("../../config/config.php");

$check_mail = $mysqli->real_escape_string($_GET['checkmail']);

$sql_email = "SELECT * FROM user WHERE email='$check_mail' LIMIT 1";
$result_email = mysqli_query($mysqli, $sql_email);

if (mysqli_num_rows($result_email) > 0) {
    echo "no"; // Địa chỉ đã có người sử dụng
} else {
    echo "yes"; // Địa chỉ email hợp lệ
}
?>
