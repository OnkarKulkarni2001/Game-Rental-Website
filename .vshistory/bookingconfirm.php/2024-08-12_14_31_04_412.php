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
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="index.php">Online Video Game Rental</a>
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

$query = "INSERT INTO rentedvideogame (game_id, customer_username, rent_start_date, rent_end_date, fare, return_status) 
VALUES ('$game_id', '$customer_username', '$rent_start_date', '$rent_end_date', '$total_amount', 'NR')";

$success = $conn->query($query);

if (!$success) {
    die("Could not enter data: " . $conn->error);
}
?>

<div class="container">
    <div class="jumbotron" style="text-align: center;">
        <h2>Thank you for Renting!</h2>
        <h3>Game Name: <?php echo $game_name; ?></h3>
        <h4>Start Date: <?php echo $rent_start_date; ?></h4>
        <h4>End Date: <?php echo $rent_end_date; ?></h4>
        <h4>Number of days: <?php echo $total_days; ?></h4>
        <h4>Fare: CAD. <?php echo $price_day; ?> per day</h4>
        <h4>Total Amount: CAD. <?php echo $total_amount; ?></h4>
        <br>
        <h3>Enjoy your game!</h3>
    </div>
</div>
</body>
</html>
