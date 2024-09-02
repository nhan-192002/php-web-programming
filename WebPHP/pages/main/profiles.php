<section style="background-color: #eee;">
  <div class="container py-5">
    <div class="row">
    <!-- <button onclick="logOut()" id="log-out" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Log Out</button> -->

      <div id="display-profiles" class="col-lg-4">
        
      </div>
      <div class="col-lg-8">
        <div class="row">
            <div class="card mb-4">
            <div class="text-center"><h3 class="my-3">lịch sử mua hàng</h3></div>
                <div class="card-body">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>payment method</th>
                                        <th>Total</th>
                                        <th>Note</th>
                                        <th>Order code</th>
                                        <th>Transaction code</th>
                                        <th>time</th>
                                    </tr>
                                </thead>
                                <tbody id="display-cart-profiles">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal edit profile -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="display_edit">
      
    </div>
  </div>
</div>
<!-- Modal edit password -->
<div class="modal fade" id="editPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p id="text-heading" class="resurtPassword" style="color: red;"></p>
            <form id="formPassword">
                <div class="mb-3">
                    <label for="oldPassword" class="form-label">Mật khẩu cũ</label>
                    <input name="password1" type="password" class="form-control oldPassword" id="oldPassword" placeholder="Mật khẩu cũ" required autocomplete="current-password">
                </div>
                <div class="mb-3">
                    <label for="newPassword1" class="form-label">Mật khẩu mới</label>
                    <input name="password2" type="password" class="form-control newPassword1" id="newPassword1" placeholder="Mật khẩu mới" required autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="newPassword2" class="form-label">Nhập lại mật khẩu mới</label>
                    <input name="password3" type="password" class="form-control newPassword2" id="newPassword2" placeholder="Nhập lại mật khẩu mới" required autocomplete="new-password">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button onclick="editPassword()" type="button" class="btn btn-primary">Edit Password</button>
        </div>
    </div>
  </div>
</div>



<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="handle_cart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div style="width: auto;max-width: 70%;" class="modal-dialog modal-dialog-scrollable"> <!-- Thêm lớp modal-dialog-scrollable -->
    <div styke="width: 70%;" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Nội dung bảng (table) trong modal -->
        <p><h3>Tình trạng giao hàng: </h3>đang chuẩn bị hàng | Hồ Chí Minh ---> đà nẵng</p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d3974170.343963847!2d105.35864299922747!3d13.410734117579631!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e6!4m5!1s0x317529292e8d3dd1%3A0xf15f5aad773c112b!2zSOG7kyBDaMOtIE1pbmg!3m2!1d10.8230989!2d106.62966379999999!4m5!1s0x314219c792252a13%3A0xfc14e3a044436487!2zxJDDoCBO4bq1bmcsIEjhuqNpIENow6J1LCDEkMOgIE7hurVuZywgVmnhu4d0IE5hbQ!3m2!1d16.0544068!2d108.20216669999999!5e0!3m2!1svi!2s!4v1724639629157!5m2!1svi!2s" 
            width="100%" 
            height="350" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        <table class="table">
          <thead>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>payment method</th>
            </tr>
          </thead>
          <tbody id="display-detailCart">
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<script>
    $(document).ready(function () {
        const decodedUrl = decodeURIComponent(window.location.href);

        const urlParams = new URLSearchParams(decodedUrl.split('?')[1]);

        const message = urlParams.get('message');
        const resultCode = urlParams.get('resultCode');
        const payment = urlParams.get('payment');

        if(message == 'Successful.' && resultCode == '0') {
            const orderId = urlParams.get('orderId');
            const transId = urlParams.get('transId');
            $.ajax({
                type: "POST",
                url: "pages/main/handle/handle-payment.php",
                data: { orderId:orderId, transId:transId},
                dataType: "html",
                success: function (response) {
                    alertify.message(response);
                }
            });
        }

        if (message == 'Giao dịch bị từ chối bởi người dùng.' && resultCode != '0') {
            alertify
                .alert("bạn đã hủy giao dịch.", function(){
                    alertify.message('OK');
                });
        }

        if(payment == 'COD'){
            $.ajax({
                type: "POST",
                url: "pages/main/handle/handle-payment.php",
                data: { payment:payment },
                dataType: "html",
                success: function (response) {
                    alertify.message(response);
                }
            });
        }
    });

    $(document).ready(function () {
        displayProfile();
        $.ajax({
            type: "GET",
            url: "pages/main/handle/handle-profiles.php",
            data: {action : 'load_cart_profiles'},
            dataType: "html",
            success: function (response) {
                $('#display-cart-profiles').html(response);
            }
        });

        $.ajax({
            type: "GET",
            url: "pages/main/handle/handle-profiles.php",
            data: {action : 'load_edit_profiles'},
            dataType: "html",
            success: function (response) {
                $('#display_edit').html(response);
            }
        });
    });

    function displayProfile(){
        $.ajax({
            type: "GET",
            url: "pages/main/handle/handle-profiles.php",
            data: {action : 'load_profiles'},
            dataType: "html",
            success: function (response) {
                $('#display-profiles').html(response);
            }
        });
    }

    function logOut() {
        $.ajax({
            type: "GET",
            url: "pages/menu/handle-menu.php",
            data: { log_out: '1' },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    window.location.href = "index.php?pages=login";
                } else {
                    console.log('Đăng xuất không thành công');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
            }
        });
    }

    function editProfiles(){
        $name = $('#name').val();
        $phone = $('#phone').val();
        $address = $('#address').val();

        if (!$name || !$phone || !$address) {
            $('.resurt').html('Vui lòng điền đầy đủ thông tin');
            return;
        }
        $.ajax({
            type: "POST",
            url: "pages/main/handle/handle-profiles.php",
            data: {
                name : $name,
                phone : $phone,
                address : $address
            },
            dataType: "html",
            success: function (response) {
                $('.btn-close').click();
                alertify.message(response);
                displayProfile();
            }
        });
    }

    function editPassword(){
        var oldPassword = $('.oldPassword').val();
        var newPassword1 = $('.newPassword1').val();
        var newPassword2 = $('.newPassword2').val();
        
        if (newPassword1.length<6 && newPassword2.length<6) {
            $('.resurtPassword').html('Mật khẩu mới phải có ít nhất 6 ký tự');
            return;
        }

        if (newPassword1!=newPassword2){
            $('.resurtPassword').html('Mật khẩu không trùng nhau');
            return;
        }

        $.ajax({
            type: "POST",
            url: "pages/main/handle/handle-profiles.php",
            data: {oldPassword:oldPassword, newPassword:newPassword2},
            dataType: "HTML",
            success: function (response) {
                if (response === 'mật khẩu cũ không chính xác'){
                    $('.resurtPassword').html(response);
                }else{
                    $('.btn-close').click();
                    $('#formPassword')[0].reset();
                    alertify.message(response);
                }
                
            }
        });
    }

    function openDetailCart(id_pay){
        $.ajax({
            type: "GET",
            url: "pages/main/handle/handle-profiles.php",
            data: {action:'load_detailCart', id_pay:id_pay},
            dataType: "html",
            success: function (response) {
                $('#display-detailCart').html(response);
                var myModal = new bootstrap.Modal(document.getElementById('handle_cart'));
                myModal.show();
            }
        });
    }
</script>