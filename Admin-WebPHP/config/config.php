<?php
    $mysqli = new mysqli("localhost","root","","internship_website");;

    if($mysqli->connect_error)
    {
        echo "kết nối thất bại" . $mysqli->connect_error;
        exit();
    }
?>