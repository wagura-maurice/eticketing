<?php
include "dbconnect.php";
$count = 10;
while ($count <= 46) {
	$number = "3".$count;
	$price = 500;
	$sql1 = "INSERT INTO seats (`number`, price) VALUES ('$number', '$price')";
	$sql2 = "SELECT * FROM seats WHERE `number` = '$number'";
	$result2 = mysql_query($sql2);
	$isthere = "no";
	while ($row2 = mysql_fetch_array($result2)) {
		$isthere = "yes";
	}
	if ($isthere == "no") {
		if (mysql_query($sql1)) {
			echo $number." success.<br>";
		}else{
			echo $number." error.<br>";
		}
	}else{
		echo $number." exists<br>";
	}
	$count++;
}
?>