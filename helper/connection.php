<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

$hostname = "localhost";
$username = "root";
$password = "";
$database = "fresher_bt";

$conn = mysqli_connect($hostname,$username,$password,$database);
mysqli_set_charset($conn,"UTF8");

if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}