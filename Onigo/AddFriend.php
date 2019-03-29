<?php
/**
 * Created by PhpStorm.
 * User: 73470
 * Date: 12/9/2018
 * Time: 7:40 PM
 */
$conn = new mysqli("localhost", "root", "", "db_pro1");
$uid = $_COOKIE['uidcookie'];
//echo"$uid";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>add friends</title>
</head>

<body>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet'
      type='text/css'>
<link href="note.css" rel="stylesheet" type="text/css">
<div class="testbox">
    <h1>Input the username</h1>

    <form action="AddFriend.php" method="POST">
        <fieldset>
            <legend><span class="number">1</span>username</legend>

            <input autocomplete="off" name="user" type="text" value=''/>

        </fieldset>
        <button type="submit" name="sub1">OK</button>

    </form>

    <form action="AddFriend.php" method="POST">
        <fieldset>
            <legend><span class="number">2</span>your friends</legend>
        </fieldset>
        <div id="data" style="top 10px;width:390px;height:150px;overflow-y:scroll;overflow-x:auto;">
            <?php
            $query = "select p.uname from user,friends,user as p where user.uid=" . "'$uid'and user.uid=friends.uid and friends.fid=p.uid ";
            $result = $conn->query($query);
            echo "<table border=1 id=\"notelist\" class=\"notelist\" style=\"\"><tr align=center><th>friends name</th></tr>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>{$row['uname']}</td>";
                echo "</tr>";
            }
            ?>
        </div>
</div>


<?php
if (isset($_POST['sub1'])) {
    $username = isset($_POST['user']) ? $_POST['user'] : "";
    $query = "select uid from user where uname=" . "'$username'   ";
    $result = $conn->query($query);
    $nums = mysqli_num_rows($result);
    if ($nums == 0) {
        echo "<script>alert('no such user!')</script>";
        echo "<script>window.location.href='addfriend.php'</script>";
    } else {
        $row = mysqli_fetch_array($result);
        $query1 = "insert into friends values(" . "$uid" . "," . "{$row['uid']}" . ")";
        $query2 = "insert into friends values(" . "{$row['uid']}" . "," . "$uid" . ")";
//        echo"$query1";
        $conn->query($query1);
        $conn->query($query2);
        $url = $_COOKIE['myurl'];
        echo "<script>alert('add success!!')</script>";
        echo "<script>window.location.href='$url'</script>";
    }
}

?>

</body>
</html>
