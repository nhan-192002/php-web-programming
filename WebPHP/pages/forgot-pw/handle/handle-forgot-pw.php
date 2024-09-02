<?php
include("../../../config/config.php");

function base_url() {
    // Lấy URL cơ bản từ server
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'] . '/';
    return $protocol . $domainName;
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include '../../../PHPMailer/src/Exception.php';
include '../../../PHPMailer/src/PHPMailer.php';
include '../../../PHPMailer/src/SMTP.php';

if (isset($_POST['email'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $random_token = rand(0000,9999);

    // Kiểm tra email trước
    $sql_email = "SELECT * FROM user WHERE email='$email' LIMIT 1";
    $result_email = mysqli_query($mysqli, $sql_email);

    if (mysqli_num_rows($result_email) > 0) {
        $sql_update = "UPDATE user SET token='$random_token' WHERE email='$email'";
        $result_update = mysqli_query($mysqli, $sql_update);
    
        $mail = new PHPMailer(true);
        try {
            //Server settings
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'nhanit192002@gmail.com';                     //SMTP username
            $mail->Password   = 'racv cnxn faym qujv';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
            //Recipients
            $mail->setFrom('nhanit192002@gmail.com', 'forgot account');
            $mail->addAddress($email);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('thanhnhan192002@gmail.com');
            // $mail->addBCC('bcc@example.com');
    
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
            //Content
            // $lijk = base_url()."index.php?pages=register&id=100";
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Reset Password';
            // $mail->Body    = base_url()."WebPHP/index.php?pages=form-token&email=$email&token=$random_token";
            $mail->Body = base_url() . "WebPHP/index.php?pages=form-token&" . urlencode("email=$email&token=$random_token");
    
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        echo "yes";
    } else {
        echo "Email không tồn tại";
    }
}

?>