<?php
/**
 * Created by PhpStorm.
 * User: ares1
 * Date: 2018/12/6
 * Time: 16:55
 */
$conn = new mysqli("localhost", "root", "", "db_pro1");
$uid = $_COOKIE['uidcookie'];
if ($sid = $_GET["sid"]) {
    $iscookie = 1;
    setcookie("sid", $sid);
}
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
<link href="CSS/MakeNote.css" rel="stylesheet">
<div class="testbox">
    <h1>Write your Note</h1>

    <form action="<?php
    echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
    ?>" method="POST">
        <fieldset>
            <legend><span class="number">1</span>Note desciption</legend>

            <input name="ndesc" type="text" value=''/>

            <legend><span class="number">2</span>Tag</legend>
            <select name="tdesc">
                <?php
                $sql = "select tdesc,tid from tag";
                $result = $conn->query($sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='$row[tid]'> $row[tdesc]</option>";
                }
                ?>
            </select>

            <legend><span class="number">3</span>Radius</legend>

            <input name="distance" type="text" value=''/>

            <legend><span class="number">4</span>Who can see</legend>
            <select name="forwho">
                <?php
                $sql = "select distinct forwho from note";
                $result = $conn->query($sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='$row[forwho]'>$row[forwho]</option>";
                }
                ?>
            </select>
            <legend><span class="number">6</span>Start time</legend>
            Start_Time: <input type="time" name="Start_Time"/>


            <legend><span class="number">7</span>End time</legend>
            End_Time: <input type="time" name="End_Time"/>


        </fieldset>
        <button type="submit" name="sub1">OK</button>

</div>
</form>


<?php
if ($iscookie == 1) {
    $sid = $_COOKIE["sid"];
}
if (isset($_POST['sub1'])) {
    echo "$sid";
    $tid = isset($_POST['tdesc']) ? $_POST['tdesc'] : "";
    $ndesc = isset($_POST['ndesc']) ? $_POST['ndesc'] : "";
    $distance = isset($_POST['distance']) ? $_POST['distance'] : "";
    $forwho = isset($_POST['forwho']) ? $_POST['forwho'] : "";
    $Start_Time = isset($_POST['Start_Time']) ? $_POST['Start_Time'] : "";
    $End_Time = isset($_POST['End_Time']) ? $_POST['End_Time'] : "";


    $check = "select * from note where sid =" . "'" . "$sid" . "'and nid =" . "'" . "$nid" . "'";
    $result = $conn->query($check);
    $nums = mysqli_num_rows($result);
    if ($nums > 0) {
        $query1 = "update note set ndesc=" . "'" . "$ndesc" . "',distance=" . "'" . "$distance" . "',forwho=" . "'" . "$forwho" . "',uid=" . "'" . "$uid" . "',sid=" . "'" . "$sid" . "')";
        mysqli_query($conn, $query1);
        $sql = "select nid from note ORDER BY nid DESC LIMIT 1";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        $query2 = "INSERT INTO schedule(nid,starttime, endtime) VALUES ('{$row['nid']}','$Start_Time','$End_Time')";
        $query3 = "INSERT INTO tagofnote(nid,tid) VALUES ('{$row['nid']}','$tid')";
        echo "$query1";
        echo "$query2";
        mysqli_query($conn, $query2);
        mysqli_query($conn, $query3);
        echo "<p class='success'>提交成功</p>";
    } else {
        $query1 = "INSERT INTO note(ndesc,distance,forwho,uid,sid) VALUES ('$ndesc','$distance','$forwho','$uid','$sid')";
        mysqli_query($conn, $query1);
        $sql = "select nid from note ORDER BY nid DESC LIMIT 1";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        $query2 = "INSERT INTO schedule(nid,starttime, endtime) VALUES ('{$row['nid']}','$Start_Time','$End_Time')";
        $query3 = "INSERT INTO tagofnote(nid,tid) VALUES ('{$row['nid']}','$tid')";
        echo "$query1";
        echo "$query2";
        mysqli_query($conn, $query2);
        mysqli_query($conn, $query3);
//        echo "<p class='success'>提交成功</p>";

    }

    echo "<script>window.location.href='$url'</script>";
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