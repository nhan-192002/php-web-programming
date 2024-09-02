    
    <div class="container">
        <div id="button-submit" class="row">
            <!--   Kitchen Sink -->
            <div class="panel panel-default">
                <div>
                    <h1 id="button-submit">Cart</h1>
                </div>
                <div><br></div>
                <div id="display-cart">
                    
                </div>
            </div>
        </div>  
        

    <!-- The Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Kiểm tra thanh toán</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <p id="text-heading" class="resurt" style="color: red;"></p>
                    <div class="modal-body">
                        <form >
                            <div class="mb-3">
                                <label for="noteInput" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="noteInput" placeholder="Ghi chú cho đơn hàng (không bắt buộc)"></textarea>
                            </div>
                            <div id="display-payment" class="mb-3">

                            </div>
                            <div class="mb-3">
                                <label for="select-pay" class="form-label">Phương thức thanh toán</label>
                                <select class="form-select" id="select-pay">
                                    <option value="" selected>Chọn phương thức thanh toán</option>
                                    <option value="COD">COD</option>
                                    <option value="MOMO">MOMO</option>
                                </select>
                            </div>
                            <label for="toggle-inputs">
                                <input type="checkbox" id="toggle-inputs"> cập nhật lại thông tin giao hàng
                            </label>
                            <div class="mb-3" id="additional-inputs" style="display: none;">
                                <label for="noteInput" class="form-label">Tên nhận hàng</label>
                                <input type="text" class="form-control address" id="name_order" placeholder="name">
                                <label for="noteInput" class="form-label">Số điện thoại nhân hàng</label>
                                <input type="text" class="form-control address" id="phone_order" placeholder="phone">
                                <label for="noteInput" class="form-label">Địa chỉ nhận hàng</label>
                                <input type="text" class="form-control address" id="address_order" placeholder="address">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" onclick="payment()" class="btn btn-primary">Xác nhận thanh toán</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>

        $(document).ready(function() {
            loadCart();
        });
        $(document).ready(function () {
            load_payment();
        });

        function reset_payment(){
            load_payment();
        }

        function payment(){
            var id_user = $('#idUserInput').val();
            var note = $('#noteInput').val(); 
            var total = $('#totalInput').val();
            var pay = $('#select-pay').val();
            var name_order = $('#name_order').val();
            var phone_order = $('#phone_order').val();
            var address_order = $('#address_order').val();


            if (total.trim() === '0' || total.trim() === '') {
                $('.resurt').html('Chưa có sản phẩm trong giỏ hàng');
                return;
            }

            if (!pay) {
                $('.resurt').html('Vui lòng chọn phương thức thanh toán');
                return;
            }

            if(name_order!='' || phone_order!='' || address_order!=''){
                if(!name_order || !phone_order || !address_order){
                    $('.resurt').html('Vui lòng điền đầy đủ thông tin nhận hàng');
                    return;
                }
            }

            $('.resurt').html('Đang xử lý thanh toán...');

            $.ajax({
                type: "POST",
                url: "pages/main/handle/handle-payment.php",
                data: {
                    note : note,
                    total : total,
                    pay : pay,
                    name_order : name_order,
                    phone_order : phone_order,
                    address_order : address_order
                },
                dataType: "html",
                success: function (response) {
                    if (response.trim() === 'MOMO') {
                        window.location.href='pages/main/payment-momo.php'
                    }
                    if (response.trim() === 'COD'){
                        window.location.href='index.php?pages=profiles&payment='+response;
                        return;
                    }


                    // $('.resurt').html(response);
                }
            });

        }

        document.addEventListener('DOMContentLoaded', function() {
            var checkbox = document.getElementById('toggle-inputs');
            if (checkbox) {
                checkbox.addEventListener('change', function() {
                    var additionalInputs = document.getElementById('additional-inputs');
                    if (additionalInputs) {
                        if (this.checked) {
                            additionalInputs.style.display = 'block'; // Hiển thị các input
                        } else {
                            additionalInputs.style.display = 'none'; // Ẩn các input
                            document.getElementById('name_order').value = '';
                            document.getElementById('phone_order').value = '';
                            document.getElementById('address_order').value = '';
                        }
                    }
                    $('#exampleModal').modal('handleUpdate');
                });
            }
        });


        function subtract(id_product) {
            $.ajax({
                type: "POST",
                url: "pages/main/handle/handle-cart-product.php",
                data: { subtract: id_product },
                dataType: "html",
                success: function (response) {
                    loadCart();
                    load_payment();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                }
            });
        }

        function add(id_product) {
            $.ajax({
                type: "POST",
                url: "pages/main/handle/handle-cart-product.php",
                data: { add: id_product },
                dataType: "html",
                success: function (response) {
                    loadCart();
                    load_payment();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                }
            });
        }

        function delete_cart(id_product) {
            $.ajax({
                type: "POST",
                url: "pages/main/handle/handle-cart-product.php",
                data: { delete: id_product },
                dataType: "html",
                success: function (response) {
                    loadCart();
                    load_payment();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                }
            });
        }

            
        function load_payment() {
            $.ajax({
                type: "GET",
                url: "pages/main/handle/handle-payment.php",
                data: {action : 'load-payment'},
                dataType: "html",
                success: function (response) {
                    $('#display-payment').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                }
            });
        }
        function loadCart() {
            $.ajax({
                url: 'pages/main/handle/handle-cart-product.php',
                type: 'GET',
                data: { action: 'load_cart' },
                success: function(response) {
                    document.getElementById('display-cart').innerHTML = response;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                }
            });
        }

    </script>
