<!DOCTYPE html>
<html>

<?php 
include('session_customer.php');
if (!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
    exit;
}
?>

<head>
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/bookingconfirm.css" />
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="index.php">VideoGame Rentals</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Orders <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="returnGame.php">Return Now</a></li>
                        <li><a href="mybookings.php">My Bookings</a></li>
                    </ul>
                </li>
                <li>
                    <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<?php
$game_id = $_SESSION['game_id'];
$game_name = $_SESSION['game_name'];
$rent_start_date = $_SESSION['rent_start_date'];
$rent_end_date = $_SESSION['rent_end_date'];
$price_day = $_SESSION['price_day'];

$total_days = ceil((strtotime($rent_end_date) - strtotime($rent_start_date)) / 86400);
$total_amount = $total_days * $price_day;

$customer_username = $_SESSION['login_customer'];

$query = "INSERT INTO rentedgames (game_id, customer_username, rent_start_date, rent_end_date, fare, return_status) 
VALUES ('$game_id', '$customer_username', '$rent_start_date', '$rent_end_date', '$total_amount', 'NR')";

$success = $conn->query($query);

if (!$success) {
    die("Could not enter data: " . $conn->error);
}
?>

<div class="container">
    <div class="jumbotron">
        <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Booking Confirmed.</h1>
    </div>
</div>
<br>

<h2 class="text-center">Thank you for using Videogame Rental System!</h2>

<h3 class="text-center"><strong>Your Order Number:</strong> <span style="color: blue;"><?php echo $game_id; ?></span></h3>

<div class="container">
    <h5 class="text-center">Please read the following information about your order.</h5>
    <div class="box">
        <div class="col-md-10" style="float: none; margin: 0 auto; text-align: center;">
            <h3 style="color: orange;">Your booking has been received and placed into our order processing system.</h3>
            <br>
            <h4>Please make a note of your <strong>order number</strong> now and keep it in case you need to communicate with us about your order.</h4>
            <br>
            <h3 style="color: orange;">Invoice</h3>
            <br>
        </div>
        <div class="col-md-10" style="float: none; margin: 0 auto;">
            <h4><strong>Game Name: </strong><?php echo $game_name; ?></h4>
            <br>
            <h4><strong>Fare:</strong> CAD. <?php echo $price_day; ?> per day</h4>
            <br>
            <h4><strong>Booking Date: </strong><?php echo date("Y-m-d"); ?></h4>
            <br>
            <h4><strong>Start Date: </strong><?php echo $rent_start_date; ?></h4>
            <br>
            <h4><strong>Return Date: </strong><?php echo $rent_end_date; ?></h4>
            <br>
            <h4><strong>Total Amount:</strong> CAD. <?php echo $total_amount; ?></h4>
            <br>
        </div>
    </div>
    <div class="col-md-12" style="float: none; margin: 0 auto; text-align: center;">
        <h6>Warning! <strong>Do not reload this page</strong> or the above display will be lost. If you want a hardcopy of this page, please print it now.</h6>
    </div>
</div>

<footer class="site-footer">
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <h5>© <?php echo date("Y"); ?> Videogame Rentals</h5>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
