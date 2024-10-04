<!DOCTYPE html>
<html>
<?php 
session_start(); 
require 'connection.php';
$conn = Connect();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - GAMEVAULT</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: white">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   GAMEVAULT </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            <?php
                if(isset($_SESSION['login_client'])){
            ?> 
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a></li>
                    <li><a href="enterGame.php" role="button">Control Panel</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
            
            <?php
                }
                else if (isset($_SESSION['login_customer'])){
            ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a></li>
                    <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> My Orders <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="returnGame.php">Return Now</a></li>
                            <li><a href="mybookings.php">My Bookings</a></li>
                        </ul>
                    </li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>

            <?php
                }
                else {
            ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="clientlogin.php">Employee</a></li>
                    <li><a href="customerlogin.php">Customer</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
            </div>
                <?php   }
                ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="bgimg-1" style="background-image: url('assets/img/about-bg.jpg'); background-size: cover; height: 300px;">
        <header class="intro">
            <div class="intro-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h1 class="brand-heading" style="color: white; font-family:Montserrat, sans-serif; background:rgba(0,0,0, 0.5);">About GAMEVAULT</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div id="sec2" style="color: #777;background-color:white;text-align:center;padding:50px 80px;">
        <h3 style="text-align:center;">About Us</h3>
        <br>
        <section class="menu-content">
            <p>Welcome to GAMEVAULT, your ultimate destination for renting video games online. Our mission is to provide an easy and convenient way for gamers to access a wide range of games at affordable prices. Whether you're looking for the latest releases or classic favorites, GAMEVAULT has you covered.</p>
            <p>Our platform is designed with both customers and employees in mind. Customers can browse our extensive catalog, make bookings, and manage their orders with ease. Employees have access to a powerful control panel to manage game listings, update availability, and handle customer inquiries.</p>
            <p>At GAMEVAULT, we're passionate about gaming and committed to delivering a top-notch experience for all our users. Our team of dedicated professionals is here to ensure that your rental experience is smooth and enjoyable. Thank you for choosing GAMEVAULT!</p>
            <h4>Meet the Team</h4>
            <p>We are a group of gaming enthusiasts and technology experts who came together to create this innovative rental service. Our team brings years of experience in game development, customer service, and digital marketing.</p>
            <p>If you have any questions or feedback, feel free to reach out to us through our contact page.</p>
        </section>
    </div>

    <footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <h5>© <?php echo date("Y"); ?> Videogame Rentals | SQATE Section 3 Group 2</h5>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.easing.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>
