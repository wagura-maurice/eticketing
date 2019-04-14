<?php
include "dbconnect.php";
session_start();
if (isset($_POST['pid'])) {
    if ($_POST['pid'] == "signup") {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        $reason = "";
        $dbauth = "yes";
        if (($name == "") || ($email == "") || ($password == "")) {
            $reason = "|All fields are required";
            $dbauth = "no";
        }else{
            $sql1 = "SELECT * FROM users WHERE email = '$email'";
            $result1 = mysql_query($sql1);
            while ($row1 = mysql_fetch_array($result1)) {
                $reason = "|The email exists";
                $dbauth = "no";
            }
        }
        if ($password != $password2) {
            $reason = "|Password mismatch";
            $dbauth = "no";
        }
        if ($dbauth == "yes") {
            $sql2 = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            if (mysql_query($sql2)) {
                $_SESSION['email'] = $email;
                header("location: index.php?msg=success");
            }else{
                header("location: signup.php?msg=error&name=$name&email=$email");
            }
        }else{
            header("location: signup.php?name=$name&email=$email&msg=reason&reason=$reason");
        }
    }elseif($_POST['pid'] == "cleartickets"){
        $sql2 = "UPDATE seats SET status = 'valid'";
        if (mysql_query($sql2)) {
            header("location: index.php");
        }else{
            header("location: index.php?msg=error");
        }
    }elseif($_POST['pid'] == "verify"){
        $sql1 = "SELECT * FROM seats";
        $result1 = mysql_query($sql1);
        while ($row1 = mysql_fetch_array($result1)) {
            if ($row1['status'] != "canceled") {
                $creditnumber = $row1['creditnumber'];
                $credittype = $row1['credittype'];
                $seatnumber = $row1['number'];
                $price = $row1['price'];
                $datebooked = $row1['datebooked'];
                $user = $row1['user'];
                $status = $row1['status'];
                $sql2 = "SELECT * FROM transactions WHERE creditnumber = '$creditnumber' AND bookdate = '$datebooked'";
                $result2 = mysql_query($sql2);
                $isthere1 = "no";
                while ($row2 = mysql_fetch_array($result2)) {
                    $isthere1 = "yes";
                    $status = $row2['status'];
                    $sql2 = "UPDATE seats SET status = '$status' WHERE `number`='$seatnumber'";
                    if (mysql_query($sql2)) {
                        #code
                    }
                }
                if ($isthere1 == "no") {
                    $sql2 = "INSERT INTO transactions (creditnumber, credittype, seatnumber, price, bookdate, user, status) VALUES ('$creditnumber', '$credittype', '$seatnumber', '$price', '$datebooked', '$user', '$status')";
                    if (mysql_query($sql2)) {
                        #code
                    }
                }
            }
        }
        header("location: index.php");
    }elseif($_POST['pid'] == "apply"){
        $creditcard = trim($_POST['creditcard']);
        $numberoftickets = $_POST['numberoftickets'];
        $paymentmethod = $_POST['paymentmethod'];

        $reason = "";
        $dbauth = "yes";
        if ($creditcard == "") {
            $reason = $reason."|All fields are required";
            $dbauth = "no";
        }
        if ($paymentmethod == "creditcard") {
            function validatecard($creditcard){
                global $type;
                $cardtype = array(
                    "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
                    "mastercard" => "/^5[1-5][0-9]{14}$/",
                    "amex"       => "/^3[47][0-9]{13}$/",
                    "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
                );
                if (preg_match($cardtype['visa'],$creditcard)){
                    $type= "visa";
                    return 'visa';
                }else if (preg_match($cardtype['mastercard'],$creditcard)){
                    $type= "mastercard";
                    return 'mastercard';
                }else if (preg_match($cardtype['amex'],$creditcard)){
                    $type= "amex";
                    return 'amex';
                }else if (preg_match($cardtype['discover'],$creditcard)){
                    $type= "discover";
                    return 'discover';
                }else{
                    return false;
                } 
            }
            validatecard($creditcard);
            if (validatecard($creditcard) !== false){
                # code...
            }else{
                $reason = $reason."|Credit card invalid. Use Visa, Mastercard, Amex or Discover";
                $dbauth = "no";
            }
        }elseif ($paymentmethod == "mpesa") {
            $type= "mpesa";
        }elseif ($paymentmethod == "cash") {
            $type= "cash";
        }elseif ($paymentmethod == "equitel") {
            $type= "equitel";
        }
        
        $seatnumbers = $_SESSION['seatnumbers'];
        $seatnumbersarry = explode("|",$seatnumbers);
        $count2 = 1;
        $totalprice = 0;
        $isthere1 = "yes";
        while ($count2 <= $numberoftickets) {
            $seatnumber = $seatnumbersarry[$count2];
            $sql1 = "SELECT * FROM seats WHERE `number` = '$seatnumber'";
            $result1 = mysql_query($sql1);
            while ($row1 = mysql_fetch_array($result1)) {
                $price = $row1['price'];
                $_SESSION['prices'] = $_SESSION['prices']."|".$price;
                if ($row1['status'] != "valid") {
                    $isthere1 = "no";
                }
            }
            $totalprice = $totalprice + $price;
            $count2++;
        }

        $totalamount=0;
        $sql1 = "SELECT * FROM payment WHERE reference='$creditcard' AND status='valid'";
        $result1 = mysql_query($sql1);
        while ($row1 = mysql_fetch_array($result1)) {
            $totalamount += $row1['amount'];
        }
        if ($totalamount < $totalprice) {
            $less = $totalamount-$totalprice;
            $reason = $reason."|Your transaction still has a less of $less, Check Number then try again";
            $dbauth = "no";
        }

        if ($isthere1 == "no") {
            $reason = $reason."|Some seats are no longer available, try again";
            $dbauth = "no";
        }

        if (isset($_SESSION['stadium'])) {
            $stadium = $_SESSION['stadium'];
        }else{
            $reason = $reason."|An error occured";
            $dbauth = "no";
        }

        if ($dbauth == "yes") {
            $seatnumbers = $_SESSION['seatnumbers'];
            $seatnumbersarry = explode("|",$seatnumbers);
            $prices = $_SESSION['prices'];
            $pricesarry = explode("|",$prices);
            $count2 = 1;
            $isthere1 = "yes";
            while ($count2 <= $numberoftickets) {
                $seatnumber = $seatnumbersarry[$count2];
                $price = $pricesarry[$count2];
                $email = $_SESSION['email'];
                $date = date(" d/m/y");
                $time1 = date("h")+1;
                $time1 = $time1.date(":i:s A");
                $datebooked = $time1.$date;
                $sql2 = "UPDATE seats SET stadium = '$stadium', user = '$email', creditnumber='$creditcard', credittype='$type', `datebooked`='$datebooked', status='verified' WHERE `number`='$seatnumber'";
                if (mysql_query($sql2)) {
                    $sql2 = "INSERT INTO transactions (creditnumber, credittype, seatnumber, price, bookdate, user, status) VALUES ('$creditcard', '$type', '$seatnumber', '$price', '$datebooked', '$email', 'verified')";
                    if (mysql_query($sql2)) {
                        $sql2 = "UPDATE payment SET status = 'settled' WHERE `reference`='$creditcard'";
                        if (mysql_query($sql2)) {
                            header("location: index.php?msg=success2");
                        }else{
                            $reason = mysql_error();
                            header("location: index.php?msg=error&reason=$reason#apply");
                        }
                    }else{
                        $reason = mysql_error();
                        header("location: index.php?msg=error&reason=$reason#apply");
                    }
                }else{
                    $reason = mysql_error();
                    header("location: index.php?msg=error&reason=$reason#apply");
                }
                $count2++;
            }
        }else{
            header("location: index.php?creditcard=$creditcard&paymentmethod=$paymentmethod&numberoftickets=$numberoftickets&msg=reason&reason=$reason#apply");
        }
    }elseif($_POST['pid'] == "login"){
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $sql1 = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result1 = mysql_query($sql1);
        $match = "no";
        while ($row1 = mysql_fetch_array($result1)) {
            $match = "yes";
        }
        if ($match == "yes") {
            $_SESSION['email'] = $email;
            header("location: index.php");
        }else{
            header("location: index.php?msg=mismatch");
        }
    }elseif($_POST['pid'] == "cancel"){
        $seatnumber = $_POST['seatnumber'];
        $status = $_POST['status'];
        $sql2 = "UPDATE seats SET status='$status' WHERE `number`='$seatnumber'";
        if (mysql_query($sql2)) {
            header("location: index.php?msg=success3");
        }else{
            header("location: index.php?msg=error");
        }
    }elseif($_POST['pid'] == "banker"){
        $tid = $_POST['tid'];
        $status = $_POST['status'];
        $sql2 = "UPDATE transactions SET status='$status' WHERE `tid`='$tid'";
        if (mysql_query($sql2)) {
            header("location: index.php?banker&msg=success3");
        }else{
            header("location: index.php?banker&msg=error");
        }
    }elseif($_POST['pid'] == "contact"){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phonenumber = trim($_POST['phonenumber']);
        $message = trim($_POST['message']);

        $reason = "";
        $dbauth = "yes";
        if (($name == "") || ($email == "") || ($phonenumber == "") || ($message == "")) {
            $reason = "|All fields are required";
            $dbauth = "no";
        }
        if ($dbauth == "yes") {
            $sql2 = "INSERT INTO contact (name, email, phonenumber, message) VALUES ('$name', '$email', '$phonenumber', '$message')";
            if (mysql_query($sql2)) {
                header("location: contact.php?msg=success");
            }else{
                $reason = mysql_error();
                header("location: contact.php?msg=error&reason=$reason");
            }
        }else{
            header("location: contact.php?msg=reason&reason=$reason");
        }
    }elseif($_POST['pid'] == "removecontact"){
        $cid = $_POST['cid'];
        $sql2 = "UPDATE contact SET status='invalid' WHERE `cid`='$cid'";
        if (mysql_query($sql2)) {
            header("location: contact.php?msg=success3");
        }else{
            header("location: contact.php?msg=error");
        }
    }else{
        header("location: index.php");
    }
}elseif(isset($_GET['logout'])){
    session_unset();
    session_destroy();
    header("location: index.php");
}else{
    header("location: index.php");
}
?>