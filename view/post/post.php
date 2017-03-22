<?php
include "../../helper/connection.php";
session_start();
if (isset($_GET['id'])){
    $postId = $_GET['id'];
}
if (isset($_SESSION['user_id'])){
    $userId = $_SESSION['user_id'];
}

//query post
$result = mysqli_query($conn,"SELECT * FROM `posts` WHERE `id` = '$postId'");
$row = mysqli_fetch_assoc($result);

//query comment
$sql = "SELECT c.*,u.fullName FROM `comments` AS c INNER JOIN `users` AS u ON c.user_id=u.id WHERE `post_id` = $postId ORDER BY `created_at` DESC";
$comment = mysqli_query($conn,$sql);

$pageTitle = "Bài viết";
?>
<?php include "../partial/_header.php"; ?>

<body>
<?php include "../partial/_navbar.php"; ?>
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <?php if ($row['user_id']==$userId){ ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" >Hành động <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="" data-toggle="modal" data-target="#formEdit">Chỉnh sửa bài viết</a></li>
                        <li><a href="../../helper/post/deletePost.php?postId=<?php echo $row['id']; ?>" onclick="return window.confirm('Bạn có chắc muốn xóa bài viết này?')">Xóa bài viết</a></li>
                    </ul>
                </li>
            <?php } ?>

<!--            form edit-->
            <div id="formEdit" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">Chỉnh sửa bài viết</h3>
                        </div>
                        <form method="POST" id="editForm">
                            <input type="hidden" name="postId" value="<?php echo $row['id']; ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="title" placeholder="Tiêu đề bài viết" class="form-control" value="<?php echo $row['post_title']; ?>">
                                    <p class="err-title"></p>
                                </div>
                                <div class="form-group">
                                    <textarea name="content" rows="10" placeholder="Nội dung bài viết" class="form-control">
                                        <?php echo $row['post_content']; ?>
                                    </textarea>
                                    <script type="text/javascript">CKEDITOR.replace("content")</script>
                                    <p class="err-content"></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="editPost" class="btn btn-primary">Lưu</button>
                                <button type="button" id="cancelEdit" class="btn btn-default" data-dismiss="modal">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h2><?php echo $row['post_title']; ?></h2>
            <b>Thời gian:</b> <?php echo $row['created_at']; ?>
            <div class="content">
                <?php echo $row['post_content']; ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <form method="POST" id="commentForm">
                <input type="hidden" name="postId" value="<?php echo $postId; ?>">
                <div class="form-group">
                    <textarea name="comment" class="form-control" rows="5" placeholder="Bình luận của bạn"></textarea>
                    <p class="err-comment"></p>
                </div>
                <div class="pull-right">
                    <button type="submit" id="comment" class="btn btn-primary">Bình luận</button>
                    <button type="button" class="btn btn-default">Hủy</button>
                </div>
            </form>
        </div>
        <div class="row">
            <h3>Bình luận</h3>
            <div id="comments">
                <?php if (mysqli_num_rows($comment)>0) {
                    while ($rows = mysqli_fetch_assoc($comment)) {
                        ?>
                        <div><b><?php echo $rows['fullName'] ?> </b><?php echo $rows['comment']; ?></div>

                            <div>Vào lúc <?php echo date('d-m-Y H:i:s',strtotime($rows['created_at'])); ?></div> <br/>
                        <?php }
                } else {?>
                    <div>Không có bình luận nào</div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom: 50px;"></div>

<script type="text/javascript" src="../../public/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#editPost").click(function (e) {
            var id = $("input[name='postId']").val();
            var title = $("input[name='title']").val();
            var content = CKEDITOR.instances.content.getData();
            $.ajax({
                url: "../../helper/post/editPost.php",
                method: 'POST',
                data: {
                    postId: id,
                    title: title,
                    content: content
                },
                dataType: "json",
                success: function (data) {
                    if (data != ''){
                        $.each(data, function(key, value){
//							$("div.form-group").addClass("has-error");
                            $(".err-"+key).html(value).css({"color":"red"}).fadeIn(400).fadeOut(3000);
                        });
                    } else {
                        location.reload();
                    }
                }
            });
            e.preventDefault();
        });

        $("#comment").click(function (e) {
            $.ajax({
                url: "../../helper/comment/addComment.php",
                method: 'POST',
                data: $("#commentForm").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data != ''){
                        $.each(data, function(key, value){
//							$("div.form-group").addClass("has-error");
                            $(".err-"+key).html(value).css({"color":"red"}).fadeIn(400).fadeOut(3000);
                        });
                    } else {
                        location.reload();
                    }
                }
            });
            e.preventDefault();
        });
    });
</script>
</body>
</html>
