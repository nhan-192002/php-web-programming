<script>
    // const email = new URLSearchParams(window.location.search).get('email');
    // const token = new URLSearchParams(window.location.search).get('token');

    const decodedUrl = decodeURIComponent(window.location.href);

    const urlParams = new URLSearchParams(decodedUrl.split('?')[1]);

    const email = urlParams.get('email');
    const token = urlParams.get('token');

    if (email && token) {
        $.ajax({
            type: "GET",
            url: "pages/login/handle-login.php",
            data: { email: email, token: token },
            dataType: "html",
            success: function (response) {
                $('.resurt').html(response);
            }
        });
    }


    $(document).ready(function () {
        $('.submit-login').click(function (e) { 
            e.preventDefault();
            var $email = $('.email').val();
            var $password = $('.password').val();

            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test($email)) {
                $('.resurt').html('Địa chỉ email không hợp lệ');
                return;
            }

            // Kiểm tra mật khẩu (ví dụ: ít nhất 6 ký tự)
            if ($password.length < 6) {
                $('.resurt').html('Mật khẩu phải có ít nhất 6 ký tự');
                return;
            }

            $.ajax({
                type: "POST",
                url: "pages/login/handle-login.php",
                dataType: "html",
                data: {
                    email: $email,
                    password: $password
                }
            }).done(function(response) {
                if(response.trim() === "Đăng nhập thành công") {
                    window.location.href = "index.php?pages=product"; // Chuyển đến trang sản phẩm sau khi đăng nhập thành công
                } else {
                    $('.resurt').html(response); // Hiển thị phản hồi từ server
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                $('.resurt').html('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
            });
        });
    });
</script>

<div id="login" class="container">
    <div class="login1">
        <h1 id="text-heading">login</h1>
        <p id="text-heading" class="resurt" style="color: red;"></p>
        <form method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input name="email" type="email" class="form-control email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required="" autocomplete="email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input name="password" type="password" class="form-control password" id="exampleInputPassword1" placeholder="Password" required="" autocomplete="current-password">
            </div>
            <div>
                <button style="width:40%;border-radius: 30px;" id="button-submit" type="submit" class="btn btn-primary submit-login">Submit</button>
                <br>
                <p id="button-submit"><a href="index.php?pages=forgot-pw">Quên mật khẩu?</a></p>
                <br>
                <p id="button-submit">Nếu bạn chưa có tài khoảng?<a href="index.php?pages=register"> đăng ký</a></p>
            </div>
        </form>
    </div>
</div>
