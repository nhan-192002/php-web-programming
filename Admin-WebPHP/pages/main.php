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
            case 'add-category':
                include_once 'pages/category/add-category.php';
                break;
            
            case 'table-category':
                include_once 'pages/category/table-category.php';
                break;

            case 'add-product':
                include_once 'pages/product/add-product.php';
                break;

            case 'table-product':
                include_once 'pages/product/table-product.php';
                break;

            case 'table-user':
                include_once 'pages/user/table-user.php';
                break;

            case 'table-orders':
                include_once 'pages/orders/table-orders.php';
                break;
            
            default:
                include_once 'pages/login/login.php';
                break;
        }
    ?>
</div>