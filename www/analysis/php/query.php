<?php
session_start();
include ("database.php");
date_default_timezone_set('Australia/Brisbane');
$clickdate = date("m.d.y");
$select_sql = "SELECT * FROM `clickcount` WHERE `clickdate` = '" . $clickdate . "'";
$result = mysqli_query($conn, $select_sql);
$count = 0;
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $update_sql = "UPDATE `clickcount` SET `clicktimes` = " . ($row["clicktimes"]+1) . " WHERE `clickdate` = '" . $clickdate . "'";
    mysqli_query($conn, $update_sql);
    $count = $row["clicktimes"] + 1;
} else {
    $insert_sql = "INSERT INTO `clickcount` (`clickdate`, `clicktimes`) VALUES ( '" . $clickdate . "', 1)";
    if (mysqli_query($conn, $insert_sql)) {
        $count = 1;
};
    
}
echo $count;
?>