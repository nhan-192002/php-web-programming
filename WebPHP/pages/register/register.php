<script>
    $(document).ready(function () {
        $('#button-submit').click(function (e) { 
            e.preventDefault();
            var $name = $('.name').val();
            var $phone = $('.phone').val();
            var $address = $('.address').val();
            var $email = $('.email').val();
            var $password = $('.password').val();

            // Kiểm tra mật khẩu (ví dụ: ít nhất 6 ký tự)
            if ($password.length < 6) {
                $('.resurt').html('Mật khẩu phải có ít nhất 6 ký tự');
                return;
            }

            if (!$name || !$phone || !$address) {
                $('.resurt').html('Vui lòng điền đầy đủ thông tin');
                return;
            }

            $.ajax({
                type: "POST",
                url: "pages/register/handle-regiter.php",
                dataType: "html",
                data: {
                    name: $name,
                    phone: $phone,
                    address: $address,
                    email: $email,
                    password: $password
                }
            }).done(function(response) {
                if (response.trim() === "kiểm tra email kích hoạt account") {
                    alert('đăng ký thành công!! kiểm tra email để kích hoạt tài khoản!!');
                    window.location.href = "index.php?pages=login";
                } else {
                    $('.resurt').html(response);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                $('.resurt').html('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
            });
        });
    });

    $(document).ready(function () {
        $('#exampleInputEmail1').change(function (e) { 
            e.preventDefault();
            var $check_mail = $('.email').val();

            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailPattern.test($check_mail)) {
                $('.checkmail').html('<span style="color: darkgreen;">Đang kiểm tra...</span>');

                $.ajax({
                    type: "GET",
                    url: "pages/register/handle-check-mail.php",
                    data: { checkmail : $check_mail },
                    dataType: "html",
                    success: function (response) {
                        console.log(response); // Kiểm tra giá trị phản hồi
                        if(response === "yes"){
                            $('.checkmail').html('<span style="color: darkgreen;">Địa chỉ email hợp lệ</span>');
                        } else if (response === "no"){
                            $('.checkmail').html('<span style="color: red;">Địa chỉ đã có người sử dụng</span>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                        $('.checkmail').html('<span style="color: red;">Có lỗi xảy ra: ' + textStatus + '</span>');
                    }
                });
            } else {
                $('.checkmail').html('<span style="color: red;">Địa chỉ email không hợp lệ</span>');
            }
        });
    });

</script>


<div id="login" class="container">
    <div class="login1">
        <h1 id="text-heading">Register</h1>
        <p id="text-heading" class="resurt" style="color: red;"></p>
        <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text">Person</span>
                <input type="text" class="form-control name" placeholder="Name" required="" autocomplete="name">
                <input type="text" class="form-control phone" placeholder="Number Phone" required="" autocomplete="tel">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control address" id="address" placeholder="Address" required="" autocomplete="address">
            </div>
            <div class="form-group">
                <label class="checkmail" for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required="" autocomplete="email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control password" id="exampleInputPassword1" placeholder="Password" required="" autocomplete="current-password">
            </div>
            <div>
                <button style="width:40%; border-radius: 30px;" id="button-submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
