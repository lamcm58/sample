<?php
session_start();
$pageTitle = "Đăng ký";
?>
<?php include "../partial/_header.php";?>
<body>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
		<h2>Đăng ký</h2>
		<form action="" method="POST" name="registerForm" id="registerForm">
			<div class="form-group">
				<input type="text" name="fullname" id="fullname" class="form-control" placeholder="Họ và tên" value="<?php echo isset($_SESSION['fullname'])?$_SESSION['fullname']:''; ?>">
				<p class="err-fullname"></p>
			</div>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" value="<?php echo isset($_SESSION['username'])?$_SESSION['username']:''; ?>">
				<p class="err-username"></p>
			</div>
			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo isset($_SESSION['email'])?$_SESSION['email']:''; ?>">
				<p class="err-email"></p>
			</div>
			<div class="form-group">
				<input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo isset($_SESSION['phone'])?$_SESSION['phone']:''; ?>">
				<p class="err-phone"></p>
			</div>
			<div class="form-group">
				<input type="text" name="dob" id="dob" class="form-control" placeholder="Ngày sinh" value="<?php echo isset($_SESSION['dob'])?$_SESSION['dob']:''; ?>" readonly>
				<p class="err-dob"></p>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Mật khẩu">
				<p class="err-password"></p>
			</div>
			<div class="form-group">
				<input type="password" name="passwordRetype" class="form-control" placeholder="Xác nhận lại mật khẩu">
				<p class="err-passwordRetype"></p>
			</div>
			<div class="form-group">
				<select name="gender" class="form-control">
					<option value="">Giới tính</option>
					<option value="0" <?php echo (isset($_SESSION['gender'])&&$_SESSION['gender']!=""&&$_SESSION['gender']==0?'selected':'')?>>Nữ</option>
					<option value="1" <?php echo (isset($_SESSION['gender'])&&$_SESSION['gender']==1?'selected':'')?>>Nam</option>
				</select>
				<p class="err-gender"></p>
			</div>
			<button type="submit" id="register" class="btn btn-primary" name="submit">Đăng ký</button>
			<button type="button" class="btn btn-default" onclick="history.go(-1)">Quay lại</button>
		</form>
	</div>
</div>
<script type="text/javascript" src="../../public/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../public/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$("#dob").datepicker();
	$(function () {
		$("#register").click(function (e) {
			$.ajax({
				url: "../../helper/user/processRegister.php",
				method: 'POST',
				data: $("#registerForm").serialize(),
				dataType: "json",
				success: function (data) {
					if (data != ''){
						$.each(data, function(key, value){
//							$("div.form-group").addClass("has-error");
							$(".err-"+key).html(value).css({"color":"red"}).fadeIn(400).fadeOut(3000);
						});
					} else {
						location.href = 'index.php';
						$("#registerForm")[0].reset();
					}
				}
			});
			e.preventDefault();
		});
	});
</script>
</body>
</html>
<?php session_destroy(); ?>