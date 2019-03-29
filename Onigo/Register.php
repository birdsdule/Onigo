<?php
/**
 * Created by PhpStorm.
 * User: 73470
 * Date: 11/6/2018
 * Time: 3:23 AM
 */

$conn = new mysqli("localhost", "root", "");
if ($conn->connect_error) {
    die("connect failed:" . $conn->connect_error);
} else {
    $select = mysqli_select_db($conn, "db_pro1");
    echo "connect success!";
    if (!$_POST['email']) {
        echo "please input the email";
    } else {
        $email = $_POST['email'];
        $psw = $_POST['password'];
        $reinput = $_POST['repassword'];
        if ($psw != $reinput) {
            echo "<script>alert('psw input error!！')</script>";
            echo "<script>window.location.href='RegisterFrame.html'</script>";
        } else {
            $emailcheck = "select uemail from user where uemail =" . "'" . "$email" . "'";
            $str = "insert into user (uemail,password) values(" . "'" . "$email" . "'," . "'" . "$psw" . "')";
            $result = $conn->query($emailcheck);
            $nums = mysqli_num_rows($result);
            if ($nums > 0) {
                echo "<script>alert('already has account')</script>";
                echo "<script>window.location.href='RegisterFrame.html'</script>";
            } else {
                $conn->query($str);
                echo "<script>alert('register success!！')</script>";
                echo "<script>window.location.href='LoginFrame.html'</script>";
            }


        }
    }
}
