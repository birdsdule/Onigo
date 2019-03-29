<?php
function parseToXML($htmlStr)
{
    $xmlStr = str_replace('<', '&lt;', $htmlStr);
    $xmlStr = str_replace('>', '&gt;', $xmlStr);
    $xmlStr = str_replace('"', '&quot;', $xmlStr);
    $xmlStr = str_replace("'", '&#39;', $xmlStr);
    $xmlStr = str_replace("&", '&amp;', $xmlStr);
    return $xmlStr;
}

// Opens a connection to a MySQL server
$uid = $_COOKIE['uidcookie'];
$status = $_COOKIE["mystatus"];
$connection = mysqli_connect('localhost', "root", "");

if (!$connection) {
    die('Not connected : ' . mysqli_error());
}

// Set the active MySQL database
$db_selected = mysqli_select_db($connection, "db_pro1");
if (!$db_selected) {
    die ('Can\'t use db : ' . mysqli_error());
}

// Select all the rows in the markers table
$query = "SELECT * FROM site WHERE sid IN(SELECT sid FROM(
SELECT sid,filter.distance,ROUND(6378.138*2*ASIN(SQRT(POW(SIN( (location.locationx*PI()/180-slat*PI()/180)/2),2)+COS(location.locationx*PI()/180)*COS(slat*PI()/180)* POW(SIN( (location.locationy*PI()/180-slng*PI()/180)/2),2)))*1000)AS LENGTH
FROM tagofnote NATURAL JOIN site NATURAL JOIN tag NATURAL JOIN statusoftag
NATURAL JOIN note NATURAL JOIN SCHEDULE, filter NATURAL JOIN location 
WHERE filter.uid = " . "$uid" . "
AND forwho=0
and filter.statusid= " . "$status" . "
AND (tagofnote.tid=filter.tid AND statusoftag.statusid=filter.statusid) OR (tagofnote.tid=NULL AND statusoftag.statusid=filter.statusid) OR (tagofnote.tid=filter.tid AND statusoftag.statusid=NULL) OR (tagofnote.tid=NULL AND statusoftag.statusid=NULL)
AND TIME(location.locationtime)<=schedule.endtime AND TIME(location.locationtime)>=schedule.starttime
AND filter.statusid = statusoftag.statusid)AS p WHERE LENGTH<distance)";
//$query->bind_parm("i",$uid);
$result = $connection->query($query);
if (!$result) {
    die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<location>';
$ind = 0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)) {
    // Add to XML document node
    echo '<site ';
    echo 'id="' . $row['sid'] . '" ';
    echo 'name="' . parseToXML($row['sname']) . '" ';
    echo 'lat="' . $row['slat'] . '" ';
    echo 'lng="' . $row['slng'] . '" ';
    echo '/>';
    $ind = $ind + 1;
}

// End XML file
echo '</location>';
