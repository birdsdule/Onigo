<?php
/**
 * Created by PhpStorm.
 * User: 73470
 * Date: 12/11/2018
 * Time: 5:34 PM
 */

$conn = new mysqli("localhost", "root", "", "db_pro1");
$connection = new mysqli("localhost", "root", "", "db_pro1");
$connection->query('set names utf8');
$update = $connection->prepare("UPDATE USER SET uname=?,gender=?,statusid=? where uid=?");
$uid = $_COOKIE['uidcookie'];
$url = $_COOKIE['myurl'];
//echo"$sid";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Note</title>
</head>

<body>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet'
      type='text/css'>
<link href="CSS/MainFrame.css" rel="stylesheet">
<div class="testbox">
    <h1>Set your INFO</h1>

    <form action="<?php
    echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
    ?>" method="POST">
        <fieldset>
            <legend><span class="number">1</span>User name</legend>

            <input name="username" type="text" value=''/>

            <legend><span class="number">2</span>gender</legend>
            <select name="gender">
                <option value="male">male</option>
                <option value=" famale">female</option>
            </select>

            <legend><span class="number">3</span>status</legend>
            <select name="status">
                <?php
                $sql = "select distinct * from status";
                $result = $conn->query($sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='$row[statusid]'>$row[statusdes]</option>";
                }
                ?>
            </select>
        </fieldset>
        <button type="submit" name="sub1">OK</button>

</div>
</form>


<?php
if (isset($_POST['sub1'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
    $status = isset($_POST['status']) ? $_POST['status'] : "";
//    $query1 ="UPDATE USER SET uname='"."$username"."',gender='"."$gender"."',statusid='"."$status"."' where uid="."$uid";
    $update->bind_param("ssii", $username, $gender, $status, $uid);
    $result = $update->execute();
    if ($result) {
        echo 1;
    } else {
        echo $update->error;
        echo 0;
    }
    echo "$query1";
    mysqli_query($conn, $query1);
    echo "<script>alert('set success!')</script>";
    $url = "MainFrame.html?uid={$uid}&uname={$username}&status={$status}";
    setcookie(myurl, $url);
    setcookie(mystatus, $status);
    echo "<script>window.location.href='$url'</script>";

//    echo"<script>window.location.href='$url'</script>";
//    echo "<p class='success'>提交成功</p>";
}
//$str = "select * from note natural join user natural join schedule natural join tag natural join tagofnote where uid ="."'"."$uid"."'";
//$result = $conn->query($str);
//echo"<table border=3><table class='blueTable'><tr align=center><thead><tr><th>note desc</th><th>tag</th><th>distance</th><th>starttime</th><th>endtime</th></thead></tr>";
//while($row = mysqli_fetch_array($result)){
//    echo"<tr>";
//    echo"<td>{$row['ndesc']}</td>";
//    echo"<td>{$row['tdesc']}</td>";
//    echo"<td>{$row['distance']}</td>";
//    echo"<td>{$row['starttime']}</td>";
//    echo"<td>{$row['endtime']}</td>";
//    echo"</tr>";
//}


?>

</body>
</html>