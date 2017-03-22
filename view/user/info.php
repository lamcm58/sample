<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thông tin</title>
</head>
<body>
<h2>Thông tin người dùng: </h2>
<?php
session_start();
if (isset($_SESSION['fullname'])){
    $fullName = $_SESSION['fullname'];
}
if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}
if (isset($_SESSION['email'])){
    $email = $_SESSION['email'];
}
if (isset($_SESSION['phone'])){
    $phone = $_SESSION['phone'];
}
if (isset($_SESSION['dob'])){
    $dob = $_SESSION['dob'];
}
if (isset($_SESSION['gender'])){
    $gender = $_SESSION['gender'];
}

echo "Họ và tên: ".$fullName;
echo "<br/>";
echo "Tên đăng nhập: ".$username;
echo "<br/>";
echo "Email: ".$email;
echo "<br/>";
echo "Điện thoại: ".$phone;
echo "<br/>";
echo "Ngày sinh: ".$dob;
echo "<br/>";
if ($gender==0){
    echo "Giới tính: Nam";
} else {
    echo "Giới tính: Nữ";
}

session_destroy();
?>
<br/>
<a href="/">Quay lại trang đăng nhập</a>
</body>
</html>
