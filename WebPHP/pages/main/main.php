<div>
    <?php
        if(isset($_GET['pages']))
        {
            $pages = $_GET['pages'];
        }
        else
        {
            $pages = 'login';
        }

        switch ($pages) {
            case 'register':
                include_once 'pages/register/register.php';
                break;

            case 'send-email':
                include_once 'pages/register/send-email.php';
                break;

            case 'forgot-pw':
                include_once 'pages/forgot-pw/forgot-pw.php';
                break;
            
            case 'send-email-forgot-pw':
                include_once 'pages/forgot-pw/send-email-forgot-pw.php';
                break;

            case 'form-token':
                include_once 'pages/forgot-pw/form-token.php';
                break;

            case 'product':
                include_once 'pages/main/product.php';
                break;

            case 'detail-product':
                include_once 'pages/main/detail-product.php';
                break;

            case 'cart-product':
                include_once 'pages/main/cart-product.php';
                break;

            case 'handle-cart-product':
                include_once 'pages/main/handle-cart-product.php';
                break;

            case 'menu':
                include_once 'pages/menu/menu.php';
                break;

            // case 'handle-login':
            //     include_once 'pages/login/handle-login.php';
            //     break;

            case 'profiles':
                include_once 'pages/main/profiles.php';
                break;

            default:
                include_once 'pages/login/login.php';
                break;
        }
    ?>
</div>