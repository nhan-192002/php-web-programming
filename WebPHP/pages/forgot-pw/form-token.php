<div id="login" class="container">
    <div class="login1">
        <h1 id="text-heading">Forgot Password</h1>
        <p id="text-heading" class="resurt" style="color: red;"></p>
        <form method="POST">
            <input type="text" name="username" style="display:none;">
            <div class="form-group">
                <label for="exampleInputPassword1">New Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="new-password">
            </div>
            <div>
                <button style="width:40%;border-radius: 30px;" id="button-submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>



<script>
$(document).ready(function () {
    const decodedUrl = decodeURIComponent(window.location.href);

    const urlParams = new URLSearchParams(decodedUrl.split('?')[1]);

    const email = urlParams.get('email');
    const token = urlParams.get('token');

    if (email && token) {
        $('#button-submit').click(function (e) { 
            e.preventDefault();
            var $password = $('#exampleInputPassword1').val();

            if ($password.length < 6) {
                $('.resurt').html('Mật khẩu phải có ít nhất 6 ký tự');
                return;
            }
            
            $.ajax({
                type: "POST",
                url: "pages/forgot-pw/handle/handle-form-token.php",
                data: {
                    email: email,
                    token: token,
                    password: $password
                },
                dataType: "html",
                success: function (response) {
                    if (response.trim() === "yes") {
                        alert('Đặt lại mật khẩu thành công');
                        window.location.href = "index.php?pages=login";
                    } else {
                        $('.resurt').html(response); 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                    $('.resurt').html('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                }
            });
        });
    }
});

</script>