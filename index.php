<?php
session_start();
include "dbconnect.php";
?>
<?php
if (isset($_POST['pid'])) {
    if ($_POST['pid']=="addticket") {
        $_SESSION['seatnumbers'] = $_SESSION['seatnumbers']."|".$_POST['seatnumber'];
        $_SESSION['ticketsdone']++;
        $numberoftickets = trim($_GET['numberoftickets']);
        header("location: index.php?numberoftickets=$numberoftickets#apply");    
    }
}
if (isset($_SESSION['ticketsdone'])) {
    if ($_SESSION['ticketsdone']>$_SESSION['numberoftickets']) {
        $_SESSION['ticketsdone'] = 0;
        $_SESSION['seatnumbers'] = "";
        header("location: index.php");
    }
}
if (isset($_POST['numberoftickets'])) {
    $_SESSION['ticketsdone'] = 0;
    $_SESSION['seatnumbers'] = "";
    $numberoftickets = trim($_POST['numberoftickets']);
    $_SESSION['stadium'] = trim($_POST['stadium']);
    header("location: index.php?numberoftickets=$numberoftickets#apply");
}
if (isset($_GET['numberoftickets'])) {
    $numberoftickets = trim($_GET['numberoftickets']);
    if (is_numeric($numberoftickets)) {
        if ($numberoftickets<1) {
            $_SESSION['ticketsdone'] = 0;
            $_SESSION['seatnumbers'] = "";
            $reason = "The number of tickets are less than 1";
            header("location: index.php?msg=reason&reason=$reason#apply");
        }else{
            $_SESSION['numberoftickets'] = $numberoftickets;
        }
    }else{
        $_SESSION['ticketsdone'] = 0;
        $_SESSION['seatnumbers'] = "";
        $reason = "The number of tickets should be numeric";
        header("location: index.php?msg=reason&reason=$reason|$numberoftickets#apply");
    }
}else{
    $numberoftickets = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Stadium E-Ticketing System</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="brand">Stadium E-Ticketing System</div>
    <div class="address-bar">THE BEST SOLUTION TO STADIUM MANAGEMENT</div>

    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.php">Stadium E-Ticketing System</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="about.php">About</a>
                    </li>
                    <?php
                    if (!isset($_SESSION['email'])) {
                        ?>
                        <li>
                            <a href="signup.php">Sign Up</a>
                        </li>
                        <?php
                    }
                    ?>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    <li>
                    <?php
                    if (!isset($_SESSION['email'])) {
                        
                    }else{
                        echo "<a href='processor.php?logout'>Logout</a>";
                    }
                    ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">

        <?php
        if (isset($_SESSION['email'])) {
            if (($_SESSION['email'] == "admin") && (!isset($_GET['banker'])) && (!isset($_GET['report'])) && (!isset($_GET['users']))) {
                ?>
                <div class="row">
                    <div class="box">
                        <div class="col-lg-12">
                            <hr>
                            <h2 class="intro-text text-center">
                                <strong>Tickets</strong>
                            </h2>
                            <hr>
                        </div>
                        
                        <div class="col-md-6">
                            <form action='processor.php' method='post'>
                                <input type='hidden' name='pid' value='verify'>
                                <!--input type='submit' value='Update tickets' class='btn btn-success btn-lg'-->
                                <a href="index.php" class="btn btn-sm">Tickets</a>
                                <a href="index.php?banker" class="btn btn-primary btn-sm">Transactions</a>
                                <a href="index.php?report" class="btn btn-success btn-sm">Tickets Revenue</a>
                                <a href="index.php?users" class="btn btn-primary btn-sm">Users</a>
                            </form>
                            <h2>Booked Tickets</h2>
                            <form action='processor.php' method='post'>
                                <input type='hidden' name='pid' value='cleartickets'>
                                <input type='submit' value='Clear ALL Tickets' class='btn btn-danger btn-sm'>
                            </form>
                            <?php
                            $user = $_SESSION['email'];
                            $sql2 = "SELECT * FROM seats";
                            $result2 = mysql_query($sql2);
                            $count1 = 1;
                            $isthere1 = "no";
                            while ($row2 = mysql_fetch_array($result2)) {
                                if ($row2['status'] == "booked") {
                                    $isthere1 = "yes";
                                    $seatnumber = $row2['number'];
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['datebooked'];
                                    $user = $row2['user'];
                                    echo "$count1. Seat number = $seatnumber |Price = $price |Credit card = $creditnumber ($credittype) <br>|User = $user |Date booked = $datebooked <br>|Status = <b>Waiting verification</b>
                                    <form action='processor.php' method='post'>
                                        <input type='hidden' name='pid' value='cancel'>
                                        <input type='hidden' name='status' value='canceled'>
                                        <input type='hidden' name='seatnumber' value='$seatnumber'>
                                        <input type='submit' value='Cancel' class='btn btn-danger btn-sm'>
                                    </form>
                                    <br><br>";
                                    $count1++;
                                }elseif ($row2['status'] == "verified") {
                                    $isthere1 = "yes";
                                    $seatnumber = $row2['number'];
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['datebooked'];
                                    $user = $row2['user'];
                                    echo "<font color='green'>$count1. Seat number = $seatnumber |Price = $price |Credit card = $creditnumber ($credittype) <br>|User = $user |Date booked = $datebooked <br>|Status = <b>Ticket verified</b></font>
                                    <form action='processor.php' method='post'>
                                        <input type='hidden' name='pid' value='cancel'>
                                        <input type='hidden' name='status' value='canceled'>
                                        <input type='hidden' name='seatnumber' value='$seatnumber'>
                                        <input type='submit' value='Cancel' class='btn btn-danger btn-sm'>
                                    </form>
                                    <br><br>";
                                    $count1++;
                                }elseif ($row2['status'] == "canceled") {
                                    $isthere1 = "yes";
                                    $seatnumber = $row2['number'];
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['datebooked'];
                                    $user = $row2['user'];
                                    echo "<font color='red'>$count1. Seat number = $seatnumber |Price = $price |Credit card = $creditnumber ($credittype) <br>|User = $user |Date booked = $datebooked <br>|Status = <b>Ticket canceled</b></font>
                                    <form action='processor.php' method='post'>
                                        <input type='hidden' name='pid' value='cancel'>
                                        <input type='hidden' name='status' value='booked'>
                                        <input type='hidden' name='seatnumber' value='$seatnumber'>
                                        <input type='submit' value='Return waiting' class='btn btn-warning btn-sm'>
                                    </form>
                                    <br><br>";
                                    $count1++;
                                }elseif ($row2['status'] == "invalid") {
                                    $isthere1 = "yes";
                                    $seatnumber = $row2['number'];
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['datebooked'];
                                    $user = $row2['user'];
                                    echo "<font color='red'>$count1. Seat number = $seatnumber |Price = $price |Credit card = $creditnumber ($credittype) <br>|User = $user |Date booked = $datebooked <br>|Status = <b>Invalid credit card</b></font>
                                    <form action='processor.php' method='post'>
                                        <input type='hidden' name='pid' value='cancel'>
                                        <input type='hidden' name='status' value='booked'>
                                        <input type='hidden' name='seatnumber' value='$seatnumber'>
                                        <input type='submit' value='Return waiting' class='btn btn-warning btn-sm'>
                                    </form>
                                    <br><br>";
                                    $count1++;
                                }
                            }
                            if ($isthere1 == "no") {
                                echo "You have no booked tickets";
                            }
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            <?php
            }elseif (($_SESSION['email'] == "admin") && (!isset($_GET['banker'])) && (isset($_GET['report'])) && (!isset($_GET['users']))) {
                ?>
                <div class="row">
                    <div class="box">
                        <div class="col-lg-12">
                            <hr>
                            <h2 class="intro-text text-center">
                                <strong>Tickets Revenue</strong>
                            </h2>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <a href="index.php" class="btn btn-success btn-sm">Tickets</a>
                            <a href="index.php?banker" class="btn btn-primary btn-sm">Transactions</a>
                            <a href="index.php?report" class="btn btn-sm">Tickets Revenue</a>
                            <a href="index.php?users" class="btn btn-primary btn-sm">Users</a>
                            <h2>Transactions</h2>
                            <?php
                            $sql2 = "SELECT * FROM transactions ORDER BY status ASC";
                            $result2 = mysql_query($sql2);
                            $count1 = 1;
                            $isthere1 = "no";
                            $bookedamount = 0;
                            $verifiedamount = 0;
                            $invalidamount = 0;
                            $canceledamount = 0;
                            while ($row2 = mysql_fetch_array($result2)) {
                                if ($row2['status'] == "booked") {
                                    $isthere1 = "yes";
                                    $bookedamount+=$row2['price'];
                                    $count1++;
                                }elseif ($row2['status'] == "verified") {
                                    $isthere1 = "yes";
                                    $verifiedamount+=$row2['price'];
                                    $count1++;
                                }elseif ($row2['status'] == "canceled") {
                                    $isthere1 = "yes";
                                    $canceledamount+=$row2['price'];
                                    $count1++;
                                }elseif ($row2['status'] == "invalid") {
                                    $isthere1 = "yes";
                                    $invalidamount+=$row2['price'];
                                    $count1++;
                                }
                            }
                            if ($isthere1 == "no") {
                                echo "There are no transactions";
                            }else{
                                echo "
                                <table border='1'>
                                    <tr>
                                        <th><font color='green'>Verified amount</font></th>
                                        <th><font color='green'>Ksh. $verifiedamount</font></th>
                                    </tr>
                                    <tr>
                                        <th><font color='black'>Amount Waiting verification</font></th>
                                        <th><font color='black'>Ksh. $bookedamount</font></th>
                                    </tr>
                                    <tr>
                                        <th><font color='red'>Invalid Amount</font></th>
                                        <th><font color='red'>Ksh. $invalidamount</font></th>
                                    </tr>
                                </table>";
                            }
                            $sql2 = "SELECT * FROM transactions ORDER BY status DESC";
                            $result2 = mysql_query($sql2);
                            $count1 = 1;
                            $isthere1 = "no";
                            while ($row2 = mysql_fetch_array($result2)) {
                                $creditnumber = $row2['creditnumber'];
                                $credittype = $row2['credittype'];
                                $price = $row2['price'];
                                $seatnumber = $row2['seatnumber'];
                                $bookdate = $row2['bookdate'];
                                $user = $row2['user'];
                                $status = $row2['status'];
                                if ($row2['status'] == "booked") {
                                    $isthere1 = "yes";
                                    echo "$count1. Credit number: $creditnumber ($credittype) |Price: $price <br>|Seat nummber: $seatnumber |Bookdate: $bookdate |User: $user <br><b>|Status: $status</b><br>";
                                    $count1++;
                                }elseif ($row2['status'] == "verified") {
                                    $isthere1 = "yes";
                                    echo "<font color='green'>$count1. Credit number: $creditnumber ($credittype) |Price: $price <br>|Seat nummber: $seatnumber |Bookdate: $bookdate |User: $user <br><b>|Status: $status</b><br></font>";
                                    $count1++;
                                }elseif ($row2['status'] == "canceled") {
                                    $isthere1 = "yes";
                                    echo "<font color='red'>$count1. Credit number: $creditnumber ($credittype) |Price: $price <br>|Seat nummber: $seatnumber |Bookdate: $bookdate |User: $user <br><b>|Status: $status</b><br></font>";
                                    $count1++;
                                }elseif ($row2['status'] == "invalid") {
                                    $isthere1 = "yes";
                                    echo "<font color='red'>$count1. Credit number: $creditnumber ($credittype) |Price: $price <br>|Seat nummber: $seatnumber |Bookdate: $bookdate |User: $user <br><b>|Status: $status</b><br></font>";
                                    $count1++;
                                }
                            }
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php
            }elseif (($_SESSION['email'] == "admin") && (isset($_GET['banker'])) && (!isset($_GET['report'])) && (!isset($_GET['users']))) {
                ?>
                <div class="row">
                    <div class="box">
                        <div class="col-lg-12">
                            <hr>
                            <h2 class="intro-text text-center">
                                <strong>Transactions</strong>
                            </h2>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <a href="index.php" class="btn btn-success btn-sm">Tickets</a>
                            <a href="index.php?banker" class="btn btn-sm">Transactions</a>
                            <a href="index.php?report" class="btn btn-success btn-sm">Tickets Revenue</a>
                            <a href="index.php?users" class="btn btn-primary btn-sm">Users</a>
                            <h2>Tickets Transactions</h2>
                            <?php
                            $sql2 = "SELECT * FROM transactions";
                            $result2 = mysql_query($sql2);
                            $count1 = 1;
                            $isthere1 = "no";
                            while ($row2 = mysql_fetch_array($result2)) {
                                if ($row2['status'] == "booked") {
                                    $isthere1 = "yes";
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['bookdate'];
                                    $user = $row2['user'];
                                    $tid = $row2['tid'];
                                    echo "$count1. Price = $price |Reference = $creditnumber ($credittype) <br>|User = $user |Date booked = $datebooked <br>|Status = <b>Waiting verification</b>
                                    <form action='processor.php' method='post'>
                                        <input type='hidden' name='pid' value='banker'>
                                        <input type='hidden' name='tid' value='$tid'>
                                        <input type='submit' value='verified' name='status' class='btn btn-success btn-sm'>
                                        <input type='submit' value='invalid' name='status' class='btn btn-danger btn-sm'>
                                    </form>
                                    <br><br>";
                                    $count1++;
                                }elseif ($row2['status'] == "verified") {
                                    $isthere1 = "yes";
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['bookdate'];
                                    $user = $row2['user'];
                                    $tid = $row2['tid'];
                                    echo "<font color='green'>$count1. Price = $price |Reference = $creditnumber ($credittype) <br>|User = $user |Date booked = $datebooked <br>|Status = <b>Transaction verified</b></font>
                                    <form action='processor.php' method='post'>
                                        <input type='hidden' name='pid' value='banker'>
                                        <input type='hidden' name='status' value='booked'>
                                        <input type='hidden' name='tid' value='$tid'>
                                        <input type='submit' value='Reset' class='btn btn-warning btn-sm'>
                                    </form>
                                    <br><br>";
                                    $count1++;
                                }elseif ($row2['status'] == "invalid") {
                                    $isthere1 = "yes";
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['bookdate'];
                                    $user = $row2['user'];
                                    $tid = $row2['tid'];
                                    echo "<font color='red'>$count1. Price = $price |Reference = $creditnumber ($credittype) <br>|User = $user |Date booked = $datebooked <br>|Status = <b>Invalid transaction</b></font>
                                    <form action='processor.php' method='post'>
                                        <input type='hidden' name='pid' value='banker'>
                                        <input type='hidden' name='status' value='booked'>
                                        <input type='hidden' name='tid' value='$tid'>
                                        <input type='submit' value='Reset' class='btn btn-warning btn-sm'>
                                    </form>
                                    <br><br>";
                                    $count1++;
                                }
                            }
                            if ($isthere1 == "no") {
                                echo "No booked tickets";
                            }
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php
            }elseif (($_SESSION['email'] == "admin") && (!isset($_GET['banker'])) && (!isset($_GET['report'])) && (isset($_GET['users']))) {
                ?>
                <div class="row">
                    <div class="box">
                        <div class="col-lg-12">
                            <hr>
                            <h2 class="intro-text text-center">
                                <strong>Users</strong>
                            </h2>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <a href="index.php" class="btn btn-success btn-sm">Tickets</a>
                            <a href="index.php?banker" class="btn btn-primary btn-sm">Transactions</a>
                            <a href="index.php?report" class="btn btn-success btn-sm">Tickets Revenue</a>
                            <a href="index.php?users" class="btn btn-sm">Users</a>
                            <h2>Registred users</h2>
                            <table border="1">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                                <?php
                                $sql2 = "SELECT * FROM users WHERE status='valid'";
                                $result2 = mysql_query($sql2);
                                $count1 = 1;
                                $isthere1 = "no";
                                while ($row2 = mysql_fetch_array($result2)) {
                                    if ($row2['email'] != "admin") {
                                        $name = $row2['name'];
                                        $email = $row2['email'];
                                        echo "
                                        <tr>
                                            <td>$count1</td>
                                            <td>$name</td>
                                            <td>$email</td>
                                        </tr>
                                        ";
                                        $count1++;
                                    }
                                }
                                ?>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php
            }else{
                ?>
                <div class="row">
                    <div class="box">
                        <div class="col-lg-12" id="apply">
                            <hr>
                            <h2 class="intro-text text-center">
                                <strong>Apply for tickets</strong>
                            </h2>
                            <hr>
                        </div>
                        <div id="carousel-example-generic" class="carousel slide col-lg-6">
                            <!-- Indicators -->
                            <ol class="carousel-indicators hidden-xs">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner ">
                                <div class="item active">
                                    <img class="img-responsive img-full"  src="img/slide-1.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="img-responsive img-full" src="img/slide-2.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="img-responsive img-full" src="img/slide-3.jpg" alt="">
                                </div>
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="icon-prev"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="icon-next"></span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <?php
                            if (!isset($_GET['numberoftickets'])) {
                            ?>
                            <h2>Apply</h2>
                            <form action = <?php echo "'index.php'"; ?> method="post">
                                Select Stadium:
                                <select name="stadium" required>
                                    <?php
                                      $stadium="";
                                      if ($stadium != "") {
                                        ?>
                                        <option value=<?php echo "'".$stadium."'"; ?>><?php echo $stadium; ?></option>
                                        <?php
                                      }
                                    ?>
                                    <option value="Nyayo_Stadium">Nyayo_Stadium</option>
                                    <option value="Kasarani_Stadium">Kasarani_Stadium</option>
                                    <option value="Machakos_Stadium">Machakos_Stadium</option>
                                </select><br>
                                Number of Tickets to Book:
                                <input type="text" name="numberoftickets" placeholder="Number of tickets" value=<?php echo "'".$numberoftickets."'"; ?> required>
                                <input type="submit" value="Submit" class='btn btn-success'>
                            </form>
                            <?php
                            }else{
                                echo "<h2>Application for ($numberoftickets) Tickets</h2>";
                            }
                            ?>
                            <?php
                            if (isset($_GET['numberoftickets'])) {
                                $numberoftickets = trim($_GET['numberoftickets']);
                                $ticketsdone = $_SESSION['ticketsdone'];
                                $ticketnumber = $ticketsdone+1;
                                if ($_SESSION['ticketsdone'] != $_SESSION['numberoftickets']) {
                                    echo "<h4>Enter Ticket ($ticketnumber) Details <a href='index.php'><font color='red'>Restart</font></a></h4>";
                                }else{
                                    echo "<h4>Choose Your Payment Method <a href='index.php'><font color='red'>Restart</font></a></h4>";
                                }
                                if (isset($_GET['seatlocation'])) {
                                    $seatlocation = $_GET['seatlocation'];
                                }else{
                                    $seatlocation = "";
                                }
                                if (isset($_POST['seatlocation'])) {
                                    $seatlocation = $_POST['seatlocation'];
                                    if (isset($_GET['seatnumber'])) {
                                        $seatnumber = $_GET['seatnumber'];
                                        $creditcard = $_GET['creditcard'];
                                    }else{
                                        $seatnumber = "";
                                        $creditcard = "";
                                    }
                                    ?>
                                    <form action = <?php echo "'index.php?numberoftickets=".$numberoftickets."'"; ?> method="post">
                                        <input type= "hidden" name="pid" value="addticket">
                                        Select Seat Number:
                                        <select name="seatnumber" required>
                                            <?php
                                              if ($seatnumber != "") {
                                                ?>
                                                <option value=<?php echo "'".$seatnumber."'"; ?>><?php echo $seatnumber; ?></option>
                                                <?php
                                              }
                                            ?>
                                            <?php
                                              $sql1 = "SELECT * FROM seats WHERE status='valid' AND seatlocation='$seatlocation'";
                                              $result1 = mysql_query($sql1);
                                              while ($row1 = mysql_fetch_array($result1)) {
                                                ?>
                                                <option value=<?php echo "'".$row1['number']."'"; ?>><?php echo $row1['number']." (Ksh.".$row1['price'].")"; ?></option>
                                                <?php
                                              }
                                            ?>
                                        </select>
                                        <input type="submit" value="Pick" class='btn btn-success'>
                                    </form>
                                    <?php
                                }elseif ($_SESSION['ticketsdone'] != $_SESSION['numberoftickets']) {
                                    ?>
                                    <form action = <?php echo "'index.php?numberoftickets=".$numberoftickets."'#apply"; ?> method="post">
                                        Select Seat Location:
                                        <select name="seatlocation" required>
                                            <?php
                                              if ($seatnumber != "") {
                                                ?>
                                                <option value=<?php echo "'".$seatnumber."'"; ?>><?php echo $seatnumber; ?></option>
                                                <?php
                                              }
                                            ?>
                                            <option value="field">Field</option>
                                            <option value="club">Club</option>
                                            <option value="upper">Upper</option>
                                        </select>
                                        <input type="submit" value="Submit" class='btn btn-success btn-sm'>
                                    </form>
                                    <?php
                                }elseif ($_SESSION['ticketsdone'] == $_SESSION['numberoftickets']) {
                                    $seatnumbers = $_SESSION['seatnumbers'];
                                    $seatnumbersarry = explode("|",$seatnumbers);
                                    $count2 = 1;
                                    $count3 = 1;
                                    $totalprice = 0;
                                    while ($count2 <= $numberoftickets) {
                                        $seatnumber = $seatnumbersarry[$count2];
                                        $sql1 = "SELECT * FROM seats WHERE `number` = '$seatnumber'";
                                        $result1 = mysql_query($sql1);
                                        $isthere1 = "no";
                                        while ($row1 = mysql_fetch_array($result1)) {
                                            $price = $row1['price'];
                                        }
                                        $totalprice = $totalprice + $price;
                                        echo "Ticket: $count3 Seat:$seatnumber Price:$price<br>";
                                        $count2++;
                                        $count3++;
                                    }
                                    echo "<b>Total: $totalprice</b><br>";
                                    if (isset($_GET['creditcard'])) {
                                        if ($_GET['paymentmethod'] == "mpesa") {
                                            $creditcard1 = $_GET['creditcard'];
                                            $creditcard2 = "";
                                            $creditcard3 = "";
                                            $creditcard4 = "";
                                        }elseif ($_GET['paymentmethod'] == "creditcard") {
                                            $creditcard1 = "";
                                            $creditcard2 = $_GET['creditcard'];
                                            $creditcard3 = "";
                                            $creditcard4 = "";
                                        }elseif ($_GET['paymentmethod'] == "equitel") {
                                            $creditcard1 = "";
                                            $creditcard2 = "";
                                            $creditcard3 = $_GET['creditcard'];
                                            $creditcard4 = "";
                                        }elseif ($_GET['paymentmethod'] == "cash") {
                                            $creditcard1 = "";
                                            $creditcard2 = "";
                                            $creditcard3 = "";
                                            $creditcard4 = $_GET['creditcard'];
                                        }
                                    }else{
                                        $creditcard1 = "";
                                        $creditcard2 = "";
                                        $creditcard3 = "";
                                        $creditcard4 = "";
                                    }
                                    ?>
                                    <hr>
                                    <img src='img/mpesa.png' width="10%" alt='' />
                                    <h5>Mpesa:</h5>
                                    <form action = "processor.php" method="post">
                                        <input type= "hidden" name="pid" value="apply">
                                        <input type= "hidden" name="paymentmethod" value="mpesa">
                                        <input type= "hidden" name="numberoftickets" value=<?php echo "'".$numberoftickets."'"; ?>>
                                        Use paybill number 123123 and account eticketing then click Apply after receiving the confirmation message.<br><br>
                                        Phone Number:
                                        <input type="text" name="creditcard" value=<?php echo "'".$creditcard1."'"; ?> required>
                                        <input type="submit" value="Apply" class='btn btn-success btn-sm'>
                                    </form>
                                    <hr>
                                    <img src='img/visa.png' width="10%" alt='' />
                                    <img src='img/mastercard.png' width="10%" alt='' />
                                    <h5>Debit/Credit/Prepaid Card:</h5>
                                    <form action = "processor.php" method="post">
                                        <input type= "hidden" name="pid" value="apply">
                                        <input type= "hidden" name="paymentmethod" value="creditcard">
                                        <input type= "hidden" name="numberoftickets" value=<?php echo "'".$numberoftickets."'"; ?>>
                                        Go to the nearest eticketing agent and pay with your card, then enter your card number and click Apply.<br><br> 
                                        Credit Card Number:
                                        <input type="text" name="creditcard" value=<?php echo "'".$creditcard2."'"; ?> required>
                                        <input type="submit" value="Apply" class='btn btn-success btn-sm'>
                                    </form>
                                    <hr>
                                    <img src='img/equitel.png' width="20%" alt='' />
                                    <h5>Equitel:</h5>
                                    <form action = "processor.php" method="post">
                                        <input type= "hidden" name="pid" value="apply">
                                        <input type= "hidden" name="paymentmethod" value="equitel">
                                        <input type= "hidden" name="numberoftickets" value=<?php echo "'".$numberoftickets."'"; ?>>
                                        Use business number 123123 and account eticketing the click Apply after receiving the confirmation message.<br><br>
                                        Phone Number:
                                        <input type="text" name="creditcard" value=<?php echo "'".$creditcard3."'"; ?> required>
                                        <input type="submit" value="Apply" class='btn btn-success btn-sm'>
                                    </form>
                                    <hr>
                                    <img src='img/cash.jpg' width="20%" alt='' />
                                    <h5>Cash:</h5>
                                    <form action = "processor.php" method="post">
                                        <input type= "hidden" name="pid" value="apply">
                                        <input type= "hidden" name="paymentmethod" value="cash">
                                        <input type= "hidden" name="numberoftickets" value=<?php echo "'".$numberoftickets."'"; ?>>
                                        Ask to make E-Ticketing cash payment with your ID as the reference number. After the deposit, click on Apply.<br><br>
                                        ID Number:
                                        <input type="text" name="creditcard" value=<?php echo "'".$creditcard4."'"; ?> required>
                                        <input type="submit" value="Apply" class='btn btn-success btn-sm'>
                                    </form>
                                    <hr>
                                    <?php
                                }
                            }
                            ?>
                            <h2>Your Booked Tickets</h2>
                            <?php
                            $user = $_SESSION['email'];
                            $sql2 = "SELECT * FROM seats WHERE user='$user' ORDER BY sid ASC";
                            $result2 = mysql_query($sql2);
                            $count1 = 1;
                            $isthere1 = "no";
                            while ($row2 = mysql_fetch_array($result2)) {
                                if ($row2['status'] == "booked") {
                                    $isthere1 = "yes";
                                    $seatnumber = $row2['number'];
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['datebooked'];
                                    $stadium = $row2['stadium'];
                                    echo "$count1. Staduim = $stadium |Seat number = $seatnumber |Price = $price |Payment = $creditnumber ($credittype) <br>|Date booked = $datebooked <br>|Status = <b>Waiting verification</b>
                                    <form action='processor.php' method='post'>
                                        <input type='hidden' name='pid' value='cancel'>
                                        <input type='hidden' name='status' value='canceled'>
                                        <input type='hidden' name='seatnumber' value='$seatnumber'>
                                        <input type='submit' value='Cancel' class='btn btn-danger btn-sm'>
                                    </form>
                                    <br><br>";
                                    $count1++;
                                }elseif ($row2['status'] == "verified") {
                                    $isthere1 = "yes";
                                    $seatnumber = $row2['number'];
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['datebooked'];
                                    $stadium = $row2['stadium'];
                                    $sql3 = "SELECT * FROM users WHERE email='$user'";
                                    $result3 = mysql_query($sql3);
                                    while ($row3 = mysql_fetch_array($result3)) {
                                        $name = $row3['name'];
                                    }
                                    echo "<font color='green'>$count1. Staduim = $stadium |Seat number = $seatnumber |Price = $price |Payment = $creditnumber ($credittype) <br>|Date booked = $datebooked <br>|Status = <b>Ticket verified</b></font><br>
                                    <form action='ticket.php?stadium=$stadium&seatnumber=$seatnumber&email=$user&name=$name&price=$price&datebooked=$datebooked' method='post'>
                                        <img src='barcode.php?text=$seatnumber' alt='testing' />
                                        <input type='submit' value='Download ticket' class='btn btn-success btn-sm'>
                                    </form>
                                    <br><br>";
                                    $count1++;
                                }elseif ($row2['status'] == "canceled") {
                                    $isthere1 = "yes";
                                    $seatnumber = $row2['number'];
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['datebooked'];
                                    $stadium = $row2['stadium'];
                                    echo "<font color='red'>$count1. Staduim = $stadium |Seat number = $seatnumber |Price = $price |Payment = $creditnumber ($credittype) <br>|Date booked = $datebooked <br>|Status = <b>Ticket canceled</b></font><br><br>";
                                    $count1++;
                                }elseif ($row2['status'] == "invalid") {
                                    $isthere1 = "yes";
                                    $seatnumber = $row2['number'];
                                    $price = $row2['price'];
                                    $creditnumber = $row2['creditnumber'];
                                    $credittype = $row2['credittype'];
                                    $datebooked = $row2['datebooked'];
                                    $stadium = $row2['stadium'];
                                    echo "<font color='red'>$count1. Staduim = $stadium |Seat number = $seatnumber |Price = $price |Payment = $creditnumber ($credittype) <br>|Date booked = $datebooked <br>|Status = <b>Credit card not valid</b></font><br><br>";
                                    $count1++;
                                }
                            }
                            if ($isthere1 == "no") {
                                echo "You have no booked tickets";
                            }
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php
            }
        }
        ?>

        <div class="row">
            <div class="box">
                <div class="col-lg-12 text-center">
                    <div class="col-md-6">
                        <img class="img-responsive img-border-left" src="img/stadium.jpg" alt="">
                    </div>
                    <h2 class="brand-before">
                        <small>Welcome to</small>
                    </h2>
                    <h1 class="brand-name">Stadium E-Ticketing System</h1>
                    <hr class="tagline-divider">
                    <?php
                    if (!isset($_SESSION['email'])) {
                        ?>
                        <form action="processor.php" method="post">
                            <input type="hidden" name="pid" value="login">
                            Email: <input type="text" name="email" placeholder="Email"><br><br>
                            Password: <input type="password" name="password" placeholder="Password"><br>
                            <input type="submit" value="Login" class="btn btn-success">
                        </form>
                        <?php
                    }else{
                        echo "<a href='processor.php?logout'>Logout</a> (".$_SESSION['email'].")";
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Stadium E-Ticketing System 2017 <a href="paymentsimulation.php">Payment Simulation</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
<?php
if(isset($_GET['reason'])){
    $reason = $_GET['reason'];
}
if(isset($_GET['msg'])){
    if ($_GET['msg'] == "mismatch") {
        ?>
        <script>
            alert("The email and password combination are incorrect");
        </script>
        <?php
    }elseif ($_GET['msg'] == "error") {
        ?>
        <script>
            alert("An error occured");
        </script>
        <?php
    }elseif ($_GET['msg'] == "success") {
        ?>
        <script>
            alert("Sign up successfull");
        </script>
        <?php
    }elseif ($_GET['msg'] == "success2") {
        ?>
        <script>
            alert("Ticket(s) Booked successfully");
        </script>
        <?php
    }elseif ($_GET['msg'] == "success3") {
        ?>
        <script>
            alert("Change successfull");
        </script>
        <?php
    }elseif ($_GET['msg'] == "reason") {
        ?>
        <script>
            alert("<?php echo $reason;?>");
        </script>
        <?php
    }
}
?>