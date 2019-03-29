<?php
/**
 * Created by PhpStorm.
 * User: 73470
 * Date: 12/7/2018
 * Time: 3:15 PM
 */
$sid = $_GET["sid"];
$uid = $_GET["uid"];
$status = $_COOKIE["mystatus"];
$conn = new mysqli("localhost", "root", "");
if ($conn->connect_error) {
    die("connect failed:" . $conn->connect_error);
} else {
    $select = mysqli_select_db($conn, "db_pro1");
    //
    $str = "SELECT * FROM note WHERE nid IN(SELECT nid FROM(
SELECT nid,filter.distance,ROUND(6378.138*2*ASIN(SQRT(POW(SIN( (location.locationx*PI()/180-slat*PI()/180)/2),2)+COS(location.locationx*PI()/180)*COS(slat*PI()/180)* POW(SIN( (location.locationy*PI()/180-slng*PI()/180)/2),2)))*1000)AS LENGTH
FROM tagofnote NATURAL JOIN site NATURAL JOIN tag NATURAL JOIN statusoftag
NATURAL JOIN note NATURAL JOIN SCHEDULE, filter NATURAL JOIN location 
WHERE filter.uid = " . "$uid" . "
AND forwho=0
and sid = " . "$sid" . "
and filter.statusid= " . "$status" . "
AND (tagofnote.tid=filter.tid AND statusoftag.statusid=filter.statusid) OR (tagofnote.tid=NULL AND statusoftag.statusid=filter.statusid) OR (tagofnote.tid=filter.tid AND statusoftag.statusid=NULL) OR (tagofnote.tid=NULL AND statusoftag.statusid=NULL)
AND TIME(location.locationtime)<=schedule.endtime AND TIME(location.locationtime)>=schedule.starttime
AND filter.statusid = statusoftag.statusid)AS p WHERE LENGTH<distance)";
    //    $str1 = "select * from note natural join filter where sid = "."'"."$sid"."'";
    $result = $conn->query($str);
    if (mysqli_num_rows($result) < 1) {
        echo "no result";
    } else {
        echo "<table border=1><tr align=center><th>notedesc</th></tr>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row['ndesc']}</td>";
            echo "</tr>";
        }
    }
}