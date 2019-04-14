<?php
include "dbconnect.php";
$beginfrom = 301;
$endat = 346;
while ($beginfrom<=$endat) {
	$seatnumber = $beginfrom;
	$sql1 = "UPDATE seats SET seatlocation = 'upper' WHERE `number`='$seatnumber'";
	if(mysql_query($sql1)){
		echo "<br>$seatnumber success";
	}else{
		echo"<br><font color='red'>Seat Number $seatnumber Failed</font>";
	}
	$beginfrom++;
}
?>