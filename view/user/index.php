<?php
include "../../helper/connection.php";
session_start();
if (!isset($_SESSION['logged'])) {
    header("Location: login.php");
}
$page = 0;
$record_per_page = 2;
$count = mysqli_query($conn,"SELECT `id` FROM `users`");
$total = mysqli_num_rows($count);
$total_page = ceil($total/$record_per_page);
if (isset($_GET['page'])){
    $page = $_GET['page'];
}
if ($page <= 0){
    $page = 1;
}
$from = ($page-1)*$record_per_page;

$sql = "SELECT * FROM `users` ORDER BY `id` ASC LIMIT $from,$record_per_page";
$result = mysqli_query($conn,$sql);

$pageTitle = "Danh sách người dùng";
?>
<?php include "../partial/_header.php"; ?>
<body>
<?php include "../partial/_navbar.php";?>
<div class="container">
    <h2>Danh sách người dùng</h2>
    <table class="table table-bordered table-responsive table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ và tên</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($result)>0){
            while ($rows = mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?php echo $rows['id']; ?></td>
                <td><?php echo $rows['fullName']; ?></td>
                <td><?php echo $rows['username']; ?></td>
                <td><?php echo $rows['email']; ?></td>
                <td><?php echo $rows['phone']; ?></td>
                <td><?php echo date("d-m-Y",strtotime($rows['dob']));?></td>
                <td><?php echo $rows['gender']==0?"Nữ":"Nam"; ?></td>
            </tr>
        <?php }
        } ?>
        </tbody>
    </table>

<!--    phân trang-->
    <?php include "../partial/_paging.php";?>

</div>

<script type="text/javascript" src="../../public/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
</body>
</html>