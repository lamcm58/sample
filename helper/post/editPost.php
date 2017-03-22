<?php
include "../connection.php";

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $postId = $_POST['postId'];
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
        $sql = "UPDATE `posts` SET `post_title` = '{$title}', `post_content` = '{$content}' WHERE `id` = '{$postId}'";
        $result = mysqli_query($conn,$sql);
        if (!$result){
            echo "<script>alert('Xin kiểm tra lai câu lệnh sql')</script>";
        }
    }

    echo json_encode($errors);
}