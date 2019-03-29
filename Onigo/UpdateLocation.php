<?php
/**
 * Created by PhpStorm.
 * User: 73470
 * Date: 12/10/2018
 * Time: 8:42 PM
 */
$locationx = $_GET["locationx"];
$locationy = $_GET["locationy"];
$uid = $_COOKIE["uidcookie"];
$conn = new mysqli("localhost", "root", "");
if ($conn->connect_error) {
    die("connect failed:" . $conn->connect_error);
} else {
    $select = mysqli_select_db($conn, "db_pro1");
    $str = "update location set locationx =" . "" . "$locationx" . "" . ",locationy =" . "" . "$locationy" . "" . "   where uid=" . "$uid";
    $result = $conn->query($str);
    $url = $_COOKIE['myurl'];
    echo "<script>window.location.href='$url'</script>";
}