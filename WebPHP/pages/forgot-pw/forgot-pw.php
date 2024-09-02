<div id="login" class="container">
    <div class="login1">
        <h1 id="text-heading">Forgot Password</h1>
        <p id="text-heading" class="resurt" style="color: red;"></p>
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div>
                <button style="width:40%;border-radius: 30px;" id="button-submit" type="submit" class="btn btn-primary">Submit</button>

            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
    $('#button-submit').click(function (e) { 
        e.preventDefault();
        var $email = $('#exampleInputEmail1').val();

        $.ajax({
            type: "POST",
            url: "pages/forgot-pw/handle/handle-forgot-pw.php",
            data: {email: $email},
            dataType: "html",
            success: function (response) {
                if(response === "yes"){
                    alert('kiểm tra email để reset password!!');
                    window.location.href = "index.php?pages=login";
                }
                $('.resurt').html(response); // Hiển thị phản hồi từ server
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
                $('#response-message').html('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown); // Hiển thị lỗi cho người dùng
            }
        });
    });
});

</script>