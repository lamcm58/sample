<?php
include "../connection.php";
session_start();
if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    $errors = [];

    if ($title == ""){
        $errors['title'] = "Tiêu đề không được để trống";
    }
    if ($content == ""){
        $errors["content"] = "Nội dung không được để trống";
    }

    if (empty($errors)){
        $sql = "INSERT INTO `posts`(`post_title`,`post_content`,`user_id`) VALUES ('{$title}','{$content}','{$user_id}')";
        $result = mysqli_query($conn,$sql);
        if (!$result){
            echo "<script>alert('Xin kiểm tra lai câu lệnh sql')</script>";
        }
    }

    echo json_encode($errors);
}