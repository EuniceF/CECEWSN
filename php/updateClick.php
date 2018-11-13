<?php
include(""); //input !$db! by connection
$currentDate = date("m.d.y");
echo $currentDate . "<br />";
$sqlse = "SELECT * FROM `table` WHERE `attr_date` = " . $currentDate; // table and attr need to be replace
echo $sqlse . "<br />";

$sqlin= "INSERT INTO `table` (`attr_date`, `attr_time`) values (" . $currentDate . ", 1)";
echo $sqlin . "<br />";
$sqlup= "UPDATE `table` SET `attr_time` = " . ($row['attr_time']+1) . " WHERE `attr_date` = " . $currentDate;
echo $sqlup . "<br />";

$result = mysqli_query($db,$sqlse);

$count = mysqli_num_rows($result); // found out whether there is a tuple of current day

// attr_date and attr_time changed into your database attribute name
if ($count == 0) {
    $sqlin= "INSERT INTO `table` (`attr_date`, `attr_time`) values (" . $currentDate . ", 1)";
    echo $sqlin . "<br />"; // can be delete
    mysqli_query($db,$sqlin);
    
} else {
    $row = $result->fetch_assoc(); // should be the only one tuple if eixst the date

    $sqlup= "UPDATE `table` SET `attr_time` = " . ($row['attr_time']+1) . " WHERE `attr_date` = " . $currentDate;
    echo $sqlup . "<br />"; // can be delete
    mysqli_query($db,$sqlup);
    
}
$db.close();
?>