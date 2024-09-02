<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
    <!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/heroes/hero-5/assets/css/hero-5.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    


    <script src="bootstrap/AlertifyJS-master/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="bootstrap/AlertifyJS-master/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="bootstrap/AlertifyJS-master/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="bootstrap/AlertifyJS-master/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="bootstrap/AlertifyJS-master/build/css/themes/bootstrap.min.css"/>
</head>
<body>
    <div>
        <?php
            session_start();
            include("config/config.php");
            include("pages/banner/banner.php");
            include("pages/menu/menu.php");
            include("pages/main/main.php");
            // include("pages/login/login.php");
            // include("pages/register/register.php");
            include("pages/footer/footer.php");

        ?>
    </div>
</body>
</html>