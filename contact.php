<?php
session_start();
include "dbconnect.php";
if (isset($_SESSION['email'])) {
    if ($_SESSION['email'] == "admin") {
        $user = "admin";
    }else{
        $user = "not admin";
    }
}else{
    $user = "not admin";
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

    <title>Contact - Start Bootstrap Theme</title>

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

    <div class="brand">Stadium E-Ticketing</div>
    <div class="address-bar">657 NYERI | Kimathi Way, 10100 | +254715 541 753</div>

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
                <a class="navbar-brand" href="index.php">Stadium E-Ticketing</a>
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
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">

        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">Contact
                        <strong>Stadium E-Ticketing</strong>
                    </h2>
                    <hr>
                </div>
                <?php
                if ($user == "admin") {
                    ?>
                    <div class="col-lg-12">
                        <table border="1">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Message</th>
                                <th>Remove</th>
                            </tr>
                            <?php
                            $sql1 = "SELECT * FROM contact where status = 'valid'";
                            $result1 = mysql_query($sql1);
                            while ($row1 = mysql_fetch_array($result1)) {
                                $name = $row1['name'];
                                $email = $row1['email'];
                                $phonenumber = $row1['phonenumber'];
                                $message = $row1['message'];
                                $cid = $row1['cid'];
                                echo "
                                    <tr>
                                        <td>$name</td>
                                        <td>$email</td>
                                        <td>$phonenumber</td>
                                        <td>$message</td>
                                        <td>
                                            <form action='processor.php' method='post'>
                                                <input type='hidden' name='pid' value='removecontact'>
                                                <input type='hidden' name='cid' value='$cid'>
                                                <input type='submit' value='Remove' class='btn btn-danger btn-sm'>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                }else{
                ?>
                <div class="col-md-8">
                    <!-- Embedded Google Map using an iframe - to select your location find it on Google maps and paste the link as the iframe src. If you want to use the Google Maps API instead then have at it! -->
                    <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?hl=@0.3905663,36.6372178,8z/data=!4m5!3m4!1s0x182780d08350900f:0x403b0eb0a1976dd9!8m2!3d-0.023559!4d37.906193?hl=en;output=embed"></iframe>
                </div>
                <div class="col-md-4">
                    <p>Phone:
                        <strong>+254715 541 753</strong>
                    </p>
                    <p>Email:
                        <strong><a href="mailto:name@example.com">martinw950@gmail.com</a></strong>
                    </p>
                    <p>Address:
                        <strong>657 Kimathi Way
                            <br>Nyeri, 10100</strong>
                    </p>
                </div>
                <?php } ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php
        if ($user == "admin") {
            # code...
        }else{
        ?>
        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">Contact
                        <strong>form</strong>
                    </h2>
                    <hr>
                    <p>The best form of Technology to be intergrated to the Game.</p>
                    <form action="processor.php" method="post">
                        <input type="hidden" name="pid" value="contact">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Email Address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control" name="phonenumber" required>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-12">
                                <label>Message</label>
                                <textarea class="form-control" rows="6" name="message"></textarea>
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Stadium E-Ticketing System 2017</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

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
            alert("Message submitted successfully, we`ll get back to you soon");
        </script>
        <?php
    }elseif ($_GET['msg'] == "success2") {
        ?>
        <script>
            alert("Ticket Booked successfully");
        </script>
        <?php
    }elseif ($_GET['msg'] == "success3") {
        ?>
        <script>
            alert("Removed successfully");
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