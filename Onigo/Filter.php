<?php
/**
 * Created by PhpStorm.
 * User: 73470
 * Date: 12/9/2018
 * Time: 7:40 PM
 */
$conn = new mysqli("localhost", "root", "", "db_pro1");
$uid = $_COOKIE['uidcookie'];
$url = $_COOKIE['myurl'];
$status = $_COOKIE['mystatus'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filter</title>
</head>

<body>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet'
      type='text/css'>
<link href="note.css" rel="stylesheet">
<div class="testbox">
    <h1>Create your Filter</h1>

    <form action="Filter.php" method="POST">
        <fieldset>
            <legend><span class="number">1</span>Tag</legend>
            <select name="tdesc">
                <?php
                $sql = "select tdesc,tid from tag";
                $result = $conn->query($sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='$row[tid]'> $row[tdesc]</option>";
                }
                ?>
            </select>
            <legend><span class="number">2</span>Radius</legend>

            <input autocomplete="off" name="distance" type="text" value=''/>

            <legend><span class="number">3</span>From friends</legend>
            <select name="fromfriend">
                <?php
                $sql = "select distinct fromfriend from filter";
                $result = $conn->query($sql);
                while ($row = mysqli_fetch_assoc($result)) {

                    echo "<option value='$row[fromfriend]'> $row[fromfriend]</option>";
                }
                ?>
            </select>
            <legend><span class="number">5</span>Start time</legend>
            Start_Time: <input type="time" name="Start_Time"/>
            <legend><span class="number">6</span>End time</legend>
            End_Time: <input type="time" name="End_Time"/>
        </fieldset>
        <button type="submit" name="register">OK</button>

    </form>


    <?php
    if (isset($_POST['register'])) {
        $tid = isset($_POST['tdesc']) ? $_POST['tdesc'] : "";
        $distance = isset($_POST['distance']) ? $_POST['distance'] : "";
        $fromfriend = isset($_POST['fromfriend']) ? $_POST['fromfriend'] : "";
        $Start_Time = isset($_POST['Start_Time']) ? $_POST['Start_Time'] : "";
        $End_Time = isset($_POST['End_Time']) ? $_POST['End_Time'] : "";

        $check = "select * from filter where uid =" . "'" . "$uid" . "'";
        $result = $conn->query($check);
        $nums = mysqli_num_rows($result);
        if ($nums > 0) {
            $query1 = "update filter set tid=" . "'" . "$tid" . "',distance=" . "'" . "$distance" . "',fromfriend=" . "'" . "$fromfriend" . "',uid=" . "'" . "$uid" . "' where uid =" . "$uid" . " and statusid=" . "$status";
            mysqli_query($conn, $query1);
            echo "$query1";
            $sql = "select filid from filter ORDER BY filid DESC LIMIT 1";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $query2 = "update schefilter set fid=" . "'" . "{$row['filid']}" . "',starttime=" . "'" . "$Start_Time" . "', endtime=" . "'" . "$End_Time" . "' where uid =" . "$uid";
            mysqli_query($conn, $query2);
//            echo "<p class='success'>提交成功</p>";
            echo "<script>window.location.href='$url'</script>";
        } else {
            $query1 = "INSERT INTO filter(tid,statusid,distance,fromfriend,uid) VALUES ('$tid','$status','$distance','$fromfriend','$uid')";
            mysqli_query($conn, $query1);
            echo "$query1";
            $sql = "select filid from filter ORDER BY filid DESC LIMIT 1";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $query2 = "INSERT INTO schefilter(fid,starttime, endtime) VALUES ('{$row['filid']}','$Start_Time','$End_Time')";
            mysqli_query($conn, $query2);
//            echo "<p class='success'>提交成功</p>";
            echo "<script>window.location.href='$url'</script>";

        }

    }

    //    $str = "select *from filter natural join user natural join schefilter natural join tag where uid ="."'"."$uid"."'";
    //    $result = $conn->query($str);
    //    echo"<table border=3><table class='blueTable'><tr align=center><thead><tr><th>tag</th><th>distance</th><th>starttime</th><th>endtime</th></thead></tr>";
    //    while($row = mysqli_fetch_array($result)){
    //        echo"<tr>";
    //        echo"<td>{$row['tdesc']}</td>";
    //        echo"<td>{$row['distance']}</td>";
    //        echo"<td>{$row['starttime']}</td>";
    //        echo"<td>{$row['endtime']}</td>";
    //        echo"</tr>";
    //    }
    //    ?>

</body>
</html>