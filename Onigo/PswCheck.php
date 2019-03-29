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
//    echo "connect success!";
    if (!$_POST['email']) {
        echo "please input the email";
    } else {
        $email = $_POST['email'];
        $psw = $_POST['password'];
        $str = "select * from user natural join location natural join status where uemail =" . "'" . "$email" . "'" . "and password =" . "'" . "$psw" . "'";
//            echo"$str";
        $result = $conn->query($str);
//            if (!$result) {
//                printf("Error: %s\n", mysqli_error($conn));
//                exit();
//            }
        if (mysqli_num_rows($result) < 1) {
            echo "<script>alert('wrong email or password')</script>";
            echo "<script>window.location.href='LoginFrame.html'</script>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                echo "<script>alert('login success!！')</script>";
                echo "<script>window.location.href=\"MainFrame.html?uid={$row['uid']}&uname={$row['uname']}&status={$row['statusdes']}\"</script>";
                $url = "MainFrame.html?uid={$row['uid']}&uname={$row['uname']}&status={$row['statusdes']}";
                setcookie(uidcookie, $row['uid']);
                setcookie(mycookieemail, $email);
                setcookie(myurl, $url);
                setcookie(locationlat, $row['locationx']);
                setcookie(locationlng, $row['locationy']);

            }
        }
    }
}
