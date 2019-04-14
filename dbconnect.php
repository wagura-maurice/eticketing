<?php
$server = "127.0.0.1";
$user = "root";
$password = "Rtcv39$$";
$db = "eticketing";

$connect = mysql_connect($server, $user, $password);
if (!$connect) {
	die("Could not connect to server!");
}

$dbconnect = mysql_select_db($db);
if (!$dbconnect) {
	die("Could not connect to DB!");
