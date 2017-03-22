<?php
include "../connection.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordEncrypt = md5($password);

    $errors = [];

    if ($email==""){
        $errors['email'] = "Email không được để trống";
    }
    else {
        // check email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ";
        }
    }

    if ($password == ""){
        $errors['password'] = "Mật khẩu không được để trống";
    }

    if (empty($errors)) {

        $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$passwordEncrypt'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            $errors['login'] = "Email hoặc mật khẩu không đúng";
        }
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
        }
    }

    echo json_encode($errors);
}