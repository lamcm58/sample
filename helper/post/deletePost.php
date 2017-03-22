<?php
include "../connection.php";

$postId = 0;
if (isset($_GET['postId'])){
    $postId = $_GET['postId'];
}
else{
    echo "Có lỗi, vui lòng kiểm tra lại.";
}
$sql = "DELETE FROM `posts` WHERE `id` = '$postId'";
$result = mysqli_query($conn,$sql);
if ($result){
    header("Location: ../../view/post/index.php");
}