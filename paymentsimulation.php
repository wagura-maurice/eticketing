<?php
include "dbconnect.php";
if (isset($_POST['paymentmethod'])) {
	$reference = trim($_POST['reference']);
	$amount = trim($_POST['amount']);
	$paymentmethod = trim($_POST['paymentmethod']);
	$dbauth = "yes";

	if ($reference=="" || $amount=="") {
		echo "<font color='red'>*All fields are required<br></font>";
		$dbauth = "no";
	}
	if (is_numeric($amount)) {
		if ($amount<0) {
			echo "<font color='red'>*The amount is below Ksh. 0<br></font>";
			$dbauth = "no";
		}
	}else{
		echo "<font color='red'>*Should be numeric<br></font>";
		$dbauth = "no";
	}

	if ($dbauth == "yes") {
		$sql2 = "INSERT INTO payment (paymentmethod, reference, amount) VALUES ('$paymentmethod', '$reference', '$amount')";
		if (mysql_query($sql2)) {
			echo "<font color='green'>*Payment Successfully Simulated<br></font>";
		}else{
			$reason = mysql_error();
			echo "<font color='red'>*$reason<br></font>";
		}
	}
}
?>
<h1>Payment Simulation</h1>
<form action="paymentsimulation.php" method="post">
	Payment Method:
    <select name="paymentmethod" required>
        <option value="mpesa">Mpesa</option>
        <option value="creditcard">Debit/Credit/Prepaid Card</option>
        <option value="equitel">Equitel</option>
        <option value="cash">Cash</option>
    </select>
    Phone Number/Card Number/ID Number:
	<input type="text" name="reference">
	Amount paid:
	<input type="text" name="amount">
	<input type="submit" value="Submit">
</form>