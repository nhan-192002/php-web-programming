    <main role="main">
        <div class="container mt-4">
            <div class="card">
                <h3 class="textdisplay"></h3>
                <div class="container-fluid" id="display">
                    <!-- Nội dung sẽ được chèn ở đây bởi AJAX -->
                </div>
                <div class="reportProduct">
                    <div id="reviews-product">
                        
                    </div>

                    <div class="review-list">
                        <h2>Recent Reviews</h2>
                        <div id="reviews" class="reviews">
                            <p>nhân: sản phẩm tuyệt vời</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        $(document).ready(function () {
            reviews_product();
        });

        function reviews_product(){
            $.ajax({
                type: "GET",
                url: "pages/main/handle/handle-detail-product.php",
                data: {action:'reviews-product'},
                dataType: "html",
                success: function (response) {
                    $('#reviews-product').html(response);
                }
            });
        }

        $(document).ready(function () {
            var id_product = sessionStorage.getItem('id_product');
            $.ajax({
                type: "GET",
                url: "pages/main/handle/handle-detail-product.php",
                data: { id_product: id_product },
                success: function (response) {
                    $('#display').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                }
            });
        });

        $(document).on('click', '.add-cart', function (e) { 
            e.preventDefault(); // Ngăn không cho submit form
            var quantity_product = $('input[name=quantity_product]').val();
            var id_product_cart = $('input[name=id_product]').val();

            $.ajax({
                type: "POST",
                url: "pages/main/handle/handle-cart-product.php",
                data: { id_cart_product: id_product_cart, quantity_product: quantity_product },
                dataType: "html",
                success: function (response) {
                    alertify.message(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                }
            });
        });
        
    </script>