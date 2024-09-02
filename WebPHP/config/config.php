<?php
    $mysqli = new mysqli("localhost","root","","internship_website");;

    if($mysqli->connect_error)
    {
        echo "kết nối thất bại" . $mysqli->connect_error;
        exit();
    }

    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = $_GET['lang'];
    }
    
    $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
    
    function loadLanguage($lang = 'vi') {
        $file = __DIR__ . "../languages/{$lang}.json";
        if (file_exists($file)) {
            $json = file_get_contents($file);
            return json_decode($json, true);
        }
        return [];
    }
    
    $translations = loadLanguage($lang);
    
?>