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
    <style>
        .bgimg-1 {
            background-image: url('assets/img/about-bg.jpg');
            background-size: cover;
            height: 300px;
            position: relative;
            color: white;
        }
        .intro-body {
            text-align: center;
            padding: 100px 0;
        }
        .intro-body h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3em;
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }
        .section-content {
            padding: 50px 80px;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        .section-content h3 {
            font-family: 'Montserrat', sans-serif;
            margin-bottom: 20px;
            font-size: 2.5em;
        }
        .section-content h4 {
            font-family: 'Montserrat', sans-serif;
            margin-top: 30px;
            font-size: 2em;
        }
        .section-content p {
            margin-bottom: 20px;
        }
    </style>
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">GAMEVAULT</a>
            </div>

            <?php
                if(isset($_SESSION['login_client'])){
            ?> 
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a></li>
                    <li><a href="enterGame.php">Control Panel</a></li>
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
        </div>
    </nav>

    <div class="bgimg-1">
        <header class="intro">
            <div class="intro-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h1 class="brand-heading">About GAMEVAULT</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div class="section-content">
        <h3>About Us</h3>
        <p>Welcome to GAMEVAULT, your premier destination for online video game rentals. At GAMEVAULT, we are dedicated to providing a seamless and enjoyable experience for gamers seeking to rent their favorite titles. Our platform offers a diverse catalog of games, from the latest releases to timeless classics, all available at competitive rates.</p>
        <p>Our mission is to make video game rentals accessible and convenient, catering to the needs of both casual players and dedicated gamers. Whether you are looking to try out a new game before purchasing or simply want to enjoy a variety of titles without a long-term commitment, GAMEVAULT is here to serve you.</p>
        <h4>Our Team</h4>
        <p>GAMEVAULT is powered by a team of passionate individuals with expertise in gaming, technology, and customer service. We strive to ensure that every aspect of our service meets the highest standards, and we are constantly working to enhance your rental experience.</p>
        <p>If you have any questions or need assistance, please don't hesitate to reach out through our contact page. Thank you for choosing GAMEVAULT, and happy gaming!</p>
    </div>

    <footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <h5>© <?php echo date("Y"); ?> GAMEVAULT | SQATE Section 3 Group 2</h5>
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
