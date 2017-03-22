<?php  
include '../connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$fullName = $_POST['fullname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$dob = $_POST['dob'];
	$password = $_POST['password'];
	$passwordRetype = $_POST['passwordRetype'];
	$gender = $_POST['gender'];

	//cấp session để hiển thị ở các bước kế tiếp
	$_SESSION['fullname'] = $fullName;
	$_SESSION['username'] = $username;
	$_SESSION['email'] = $email;
	$_SESSION['phone'] = $phone;
	$_SESSION['dob'] = $dob;
	$_SESSION['gender'] = $gender;

	$errors = [];

	if ($fullName==""){
		$errors['fullname'] = "Họ tên không được để trống";
	}

	if ($username==""){
		$errors['username'] = "Tên đăng nhập không được để trống";
	}

	if ($email==""){
		$errors['email'] = "Email không được để trống";
	}
	else {
		// check email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = "Email không hợp lệ";
		}
	}

//	check password

	if ($password == ""){
		$errors['password'] = "Mật khẩu không được để trống";
	}
	if ($passwordRetype==""){
		$errors['passwordRetype'] = "Xác nhận mật khẩu không được để trống";
	}
	else {
		if ($password !== $passwordRetype) {
			$errors['passwordRetype'] = "Mật khẩu không khớp nhau";
		}
		if (strlen($password) < 8 ) {
			$errors['password'] = "Mật khẩu phải có ít nhất 8 ký tự";
		}
		if (strlen($passwordRetype) < 8){
			$errors['passwordRetype'] = "Mật khẩu phải có ít nhất 8 ký tự";
		}
	}

//	check phone
	if ($phone==""){
		$errors['phone'] = "Số điện thoại không được để trống";
	}

//	check ngày sinh
	if ($dob==""){
		$errors['dob'] = "Ngày sinh không được để trống";
	}

//	check giới tính
	if ($gender==""){
		$errors['gender'] = "Giới tính không được để trống";
	}

//	nếu ko có lỗi thì thực hiện insert vào db
	if (empty($errors)) {
		$select = mysqli_query($conn, "SELECT `email` FROM `users` WHERE `email` = '{$email}'");
		if (mysqli_num_rows($select) == 0) {
			// format ngày sinh
			$datetimeFormat = date("Y-m-d", strtotime($dob));
			// mã hóa mật khẩu
			$passEncrypt = md5($password);

			$sql = "INSERT INTO `users`(`username`,`password`,`fullName`,`email`,`phone`,`dob`,`gender`) VALUES ('{$username}','{$passEncrypt}','{$fullName}','{$email}','{$phone}','{$datetimeFormat}','{$gender}')";

			$result = mysqli_query($conn, $sql);
			if ($result){
				$last_id = $conn->insert_id;

				$_SESSION['logged'] = true;
				$_SESSION['user_id'] = $last_id;
			}
		}
		else {
			$errors['email'] = "Email này đã tồn tại";
		}
	}

	echo json_encode($errors);
}
