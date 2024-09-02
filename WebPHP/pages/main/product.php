<script>
    $(document).ready(function () {
        
        display_product();
        display_pagination();
    });

    function display_product(){
        $.ajax({
            type: "GET",
            url: "pages/main/handle/handle-product.php",
            success: function(response) {
                $('#display').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
            }
        });
    }
    function pagination(i){
        $.ajax({
            type: "GET",
            url: "pages/main/handle/handle-product.php",
            data: {page:i},
            dataType: "html",
            success: function(response) {
                $('#display').html(response);
                display_pagination(i);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
            }
        });
    }

    function display_pagination(i){
        $.ajax({
            type: "GET",
            url: "pages/main/handle/handle-pagination.php",
            data: {action:'load_pagination', active:i},
            dataType: "HTML",
            success: function (response) {
                $('#display-pagination').html(response);
            }
        });
    }


    function detailproduct(id_product) {
        sessionStorage.removeItem('id_product');
        sessionStorage.setItem('id_product', id_product);
        window.location.href = 'index.php?pages=detail-product';
    }


    function add_cart_product(id_product){
        $.ajax({
            type: "POST",
            url: "pages/main/handle/handle-cart-product.php",
            data: { id_cart_product: id_product, quantity_product: '1' },
            dataType: "html",
            success: function (response) {
                // alert(response);
                alertify.message(response);
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
            }
        });
    }

</script>
<div class="container">
    <!-- <div><?php echo $translations["home"]["name"] ?></div> -->
    <div id="display" class="row">
    </div>
    <div id="pagination-product">
        <nav aria-label="Page navigation example">
            <ul class="pagination" id="display-pagination">

            </ul>
        </nav>
    </div>
</div>