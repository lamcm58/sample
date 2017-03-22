<?php
include "../../helper/connection.php";
session_start();
if (!isset($_SESSION['logged'])) {
    header("Location: ../user/login.php");
}

$page = 0;
$record_per_page = 2;
$count = mysqli_query($conn,"SELECT `id` FROM `posts`");
$total = mysqli_num_rows($count);
$total_page = ceil($total/$record_per_page);
if (isset($_GET['page'])){
    $page = $_GET['page'];
}
if ($page <= 0){
    $page = 1;
}
$from = ($page-1)*$record_per_page;

$sql = "SELECT p.*,u.fullName FROM `posts` AS p INNER JOIN `users` AS u ON p.user_id=u.id ORDER BY p.id DESC LIMIT $from,$record_per_page";
$result = mysqli_query($conn,$sql);

$pageTitle = "Danh sách bài viết";
?>
<?php include "../partial/_header.php"; ?>

<body>
<?php include "../partial/_navbar.php"; ?>
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="addNew">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formAdd">Thêm bài viết</button>
            <div id="formAdd" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">Thêm bài viết</h3>
                        </div>
                        <form method="POST" id="postForm">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="title" placeholder="Tiêu đề bài viết" class="form-control">
                                    <p class="err-title"></p>
                                </div>
                                <div class="form-group">
                                    <textarea name="content" rows="5" placeholder="Nội dung bài viết" class="form-control"></textarea>
                                    <script type="text/javascript">CKEDITOR.replace("content")</script>
                                    <p class="err-content"></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="addPost" class="btn btn-primary">Đăng</button>
                                <button type="button" id="cancelAdd" class="btn btn-default" data-dismiss="modal">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div style="margin-top: 30px;">
            <h2>Danh sách bài viết</h2>
            <?php if (mysqli_num_rows($result)>0){
                while ($rows = mysqli_fetch_assoc($result)){ ?>
                    <div class="post">
                        <h4><a href="post.php?id=<?php echo $rows['id'];?>"><?php echo $rows['post_title']; ?></a></h4>
                        <b>Người đăng:</b> <?php echo $rows['fullName'] ;?>,
                        lúc <?php echo date('d-m-Y H:i:s',strtotime($rows['created_at'])); ?>
                    </div>
            <?php }
            } ?>
        </div>
        <!--    phân trang-->
        <?php include "../partial/_paging.php";?>
    </div>
</div>
<script type="text/javascript" src="../../public/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addPost").click(function (e) {
            var title = $("input[name='title']").val();
            var content = CKEDITOR.instances.content.getData();
            $.ajax({
                url: "../../helper/post/addPost.php",
                method: 'POST',
                data: {
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
                        $("#formAdd")[0].reset();
                    }
                }
            });
            e.preventDefault();
        });

        $("#cancelAdd").click(function () {
            $("input[name='title']").val("");
            $("textarea[name='content']").val("");
        });
    });
</script>
</body>
</html>
