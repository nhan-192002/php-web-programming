<?php
    $alert = "kiểm tra mail để kích hoạt tài khoản của bạn";

    $email = $mysqli->real_escape_string($_GET['email']);
    $token = $mysqli->real_escape_string($_GET['token']);

    function base_url() {
        // Lấy URL cơ bản từ server
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';
        return $protocol . $domainName;
    }
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        
        include 'PHPMailer/src/Exception.php';
        include 'PHPMailer/src/PHPMailer.php';
        include 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);

    try {
        //Server settings
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'nhanit192002@gmail.com';                     //SMTP username
        $mail->Password   = 'racv cnxn faym qujv';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('nhanit192002@gmail.com', 'Verify account');
        $mail->addAddress($_GET['email']);     //Add a recipient
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
        $mail->Subject = 'Check account';
        $mail->Body    = base_url()."WebPHP/index.php?pages=login&email=$email&token=$token";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>


<script>
    var alertMessage = "<?php echo addslashes($alert); ?>";
    window.location = "index.php?pages=login&alert=" + encodeURIComponent(alertMessage);
</script>