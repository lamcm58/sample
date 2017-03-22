<?php
$pageTitle = "Đăng nhập";
include "../partial/_header.php";
?>
<body>
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <h2>Đăng nhập</h2>
        <form method="POST" id="loginForm">
            <div class="form-group">
                <input type="text" name="email" id="email" class="form-control" placeholder="Nhập email của bạn">
                <p class="err-email"></p>
                <p class="err-login"></p>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu của bạn">
                <p class="err-password"></p>
                <p class="err-login"></p>
            </div>

            <div><a href="register.php">Chưa có tài khoản? Đăng ký</a></div>
            <br>

            <button type="submit" id="login" name="submit" class="btn btn-primary">Đăng nhập</button>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../public/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#login").click(function (e) {
            $.ajax({
                url: "../../helper/user/processLogin.php",
                method: 'POST',
                data: $("#loginForm").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data != ''){
                        $.each(data, function(key, value){
//							$("div.form-group").addClass("has-error");
                            $(".err-"+key).html(value).css({"color":"red"}).fadeIn(400).fadeOut(3000);
                        });
                    } else {
                        location.href = 'index.php';
                        $("#loginForm")[0].reset();
                    }
                }
            });
            e.preventDefault();
        });
    });
</script>
</body>
</html>