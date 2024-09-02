<?php
include("../../../config/config.php");

if(isset($_POST['email']) && isset($_POST['token'])) {
    $check_mail = $mysqli->real_escape_string($_POST['email']);
    $check_token = $mysqli->real_escape_string($_POST['token']);

    $sql_check= "SELECT * FROM user WHERE email='$check_mail' AND token='$check_token' LIMIT 1";
    $result_check = mysqli_query($mysqli, $sql_check);

    if (mysqli_num_rows($result_check)>0) {

        if (isset($_POST['email']) && isset($_POST['token'])) {
            // $password = $mysqli->real_escape_string(md5($_POST['password']));
            $options = [
                'cost' => 12, // Tăng độ mạnh của băm
            ];
            $password = $mysqli->real_escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT, $options));
            $rand_token = rand(0000,9999);
            
            $sql_update = "UPDATE user SET password='$password',token='$rand_token' WHERE email='$check_mail' AND token='$check_token'";
            $result_update = mysqli_query($mysqli, $sql_update);

            if ($result_update && mysqli_affected_rows($mysqli) > 0) {
                echo "yes";
            } else {
                echo "Reset Password Thất bại";
            }
        }

    } else {
         echo "Không thể đặt lại PassWord";
    }
}

?>