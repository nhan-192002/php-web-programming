<?php
ob_start(); // Bật bộ đệm đầu ra
include("../../config/config.php");

$alert = '';
if (isset($_GET['alert'])) {
    $alert = $mysqli->real_escape_string($_GET['alert']);
}

if (isset($_GET['email']) && isset($_GET['token'])) {
    $check_mail = $mysqli->real_escape_string($_GET['email']);
    $check_token = $mysqli->real_escape_string($_GET['token']);
    $random_token = rand(0000, 9999);

    $sql_check = "SELECT * FROM user WHERE email='$check_mail' AND token='$check_token' LIMIT 1";
    $result_check = mysqli_query($mysqli, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        $sql_update = "UPDATE user SET check_account='1', token='$random_token' WHERE email='$check_mail' AND token='$check_token'";
        $result_update = mysqli_query($mysqli, $sql_update);

        echo $alert = "xác thực thành công";
        // header("Location: index.php?pages=login&alert=$alert");
        exit(); 
    } else {
        echo $alert = "Không thể xác thực tài khoản";
    }
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $password_sql = '';

    $sql_email = "SELECT * FROM user WHERE email='$email' LIMIT 1";
    $result_email = mysqli_query($mysqli, $sql_email);

    if (mysqli_num_rows($result_email) > 0) {
        while($row = mysqli_fetch_array($result_email)){
            $password_sql = $row['password'];
        }
        if (password_verify($password, $password_sql)) {
            $sql_account = "SELECT * FROM user WHERE email='$email' AND check_account='1' LIMIT 1";
            $result_account = mysqli_query($mysqli, $sql_account);
    
            if (mysqli_num_rows($result_account) > 0) {
                while ($row = mysqli_fetch_array($result_account)) {
                    session_start();
                    $_SESSION['id_user'] = $row['id'];
                    echo $alert = "Đăng nhập thành công";
                }
                exit();
            } else {
                echo $alert = "Tài Khoản chưa xác thực hoặc bị khóa";
            }
        } else {
            echo $alert = "Sai mật khẩu";
        }
    } else {
        echo $alert = "Email không tồn tại";
    }
}
ob_end_flush(); 
?>