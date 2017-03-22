<?php
include "../connection.php";
session_start();

if (isset($_SESSION['user_id'])){
    $userId = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $comment = $_POST['comment'];
    $postId = $_POST['postId'];

    $error = [];

    if ($comment==""){
        $error['comment'] = "Bình luận không được để trống";
    }

    if (empty($error)){
        $sql = "INSERT INTO `comments`(`comment`,`post_id`, `user_id`) VALUES ('{$comment}','{$postId}','{$userId}')";
        $result = mysqli_query($conn,$sql);
        if (!$result){
            echo "<script>alert('Xin kiểm tra lai câu lệnh sql')</script>";
        }
    }

    echo json_encode($error);
}