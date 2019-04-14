<?php
session_start();
include "dbconnect.php";
if (isset($_SESSION['email'])) {
    header("location: index.php");
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

    <title>Sign Up - Stadium E-Ticketing System</title>

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
    <div class="address-bar"></div>

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
                    <li>
                        <a href="signup.php">Sign Up</a>
                    </li>
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
                    <h2 class="intro-text text-center">Stadium E-Ticketing System
                        <strong>Sign Up</strong>
                    </h2>
                    <hr>
                </div>
                <div class="col-lg-12 text-center">
                    <?php
                    if(isset($_GET['name'])){
                        $name = $_GET['name'];
                        $email = $_GET['email'];
                    }else{
                        $name = "";
                        $email = "";
                    }
                    ?>
                    <form action="processor.php" method="post">
                        <input type="hidden" name="pid" value="signup">
                        Name: <br><input type="text" name="name" value=<?php echo "'".$name."'"; ?> placeholder="Name" required><br><br>
                        Email: <br><input type="text" name="email" value=<?php echo "'".$email."'"; ?> placeholder="Email" required><br><br>
                        Password: <br><input type="password" name="password" placeholder="Password" required><br><br>
                        Confirm Password: <br><input type="password" name="password2" placeholder="Confirm Password" required><br><br>
                        <input type="submit" value="Sign up" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>

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
    if ($_GET['msg'] == "reason") {
        ?>
        <script>
            alert("<?php echo $reason;?>");
        </script>
        <?php
    }elseif ($_GET['msg'] == "error") {
        ?>
        <script>
            alert("An error occured");
        </script>
        <?php
    }
}
?>