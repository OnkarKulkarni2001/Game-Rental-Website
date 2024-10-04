<!DOCTYPE html>
<html>

<?php
include_once('session_customer.php');
include_once('connection.php'); // Ensure this file is included for the $conn variable

if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: customerlogin.php");
    exit;
}

$customer_username = $_SESSION["login_customer"];
$game_id = $conn->real_escape_string($_POST['hidden_gameid']);
$rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
$rent_end_date = date('Y-m-d', strtotime($_POST['rent_end_date']));
$return_status = "NR"; // not returned
$fare = "NA";

function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$err_date = dateDiff($rent_start_date, $rent_end_date);
$no_of_days = max($err_date, 1); // Ensures at least one day of booking

$sql0 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
$result0 = $conn->query($sql0);
$row0 = mysqli_fetch_assoc($result0);
$fare = $row0["price_day"];
$total = $fare * $no_of_days;

if ($err_date >= 0) {
    $sql1 = "INSERT INTO rentedgames(`customer_username`, `game_id`, `booking_date`, `rent_start_date`, `rent_end_date`, `fare`, `no_of_days`, `total_amount`, `return_status`)
             VALUES('$customer_username', '$game_id', '" . date("Y-m-d") . "', '$rent_start_date', '$rent_end_date', '$fare', '$no_of_days', '$total', '$return_status')";
    $result1 = $conn->query($sql1);

    $sql2 = "UPDATE videogame SET game_availability = 'no' WHERE game_id = '$game_id'";
    $result2 = $conn->query($sql2);

    $sql4 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
    $result4 = $conn->query($sql4);
    $row = mysqli_fetch_assoc($result4);
    $game_name = $row["game_name"];

    if (!$result1 || !$result2) {
        die("Could not enter data: " . $conn->error);
    }
} else {
    $showError = true;
}
?>

<head>
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
                <a class="navbar-brand page-scroll" href="index.php">
                    VideoGame Rentals
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['login_client'])) { ?>
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a></li>
                        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="enterGame.php">Add Videogame</a></li>
                                <li><a href="view.php">View</a></li>
                            </ul>
                        </li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    <?php } elseif (isset($_SESSION['login_customer'])) { ?>
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a></li>
                        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> My Orders <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="returnGame.php">Return Now</a></li>
                                <li><a href="mybookings.php"> My Bookings</a></li>
                            </ul>
                        </li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    <?php } else { ?>
                        <li><a href="clientlogin.php">Employee</a></li>
                        <li><a href="customerlogin.php">Customer</a></li>
                        <li><a href="#">FAQ</a></li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <?php if (isset($showError) && $showError) { ?>
        <div class="container">
            <div class="jumbotron text-center">
                <h1 style="color: red;">You have selected an incorrect date.</h1>
            </div>
        </div>
    <?php } elseif ($err_date >= 0) { ?>
        <div class="container">
            <div class="jumbotron">
                <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Booking Confirmed.</h1>
            </div>
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
                        <h4><strong>Game Name:</strong> <?php echo $game_name; ?></h4>
                        <br>
                        <h4><strong>Fare:</strong> Rs. <?php echo $fare; ?>/day</h4>
                        <br>
                        <h4><strong>Booking Date:</strong> <?php echo date("Y-m-d"); ?></h4>
                        <br>
                        <h4><strong>Start Date:</strong> <?php echo $rent_start_date; ?></h4>
                        <br>
                        <h4><strong>Return Date:</strong> <?php echo $rent_end_date; ?></h4>
                        <br>
                        <!-- Assuming client_name and client_phone should be displayed -->
                        <h4><strong>Employee Name:</strong> <?php echo isset($client_name) ? $client_name : 'N/A'; ?></h4>
                        <br>
                        <h4><strong>Employee Contact:</strong> <?php echo isset($client_phone) ? $client_phone : 'N/A'; ?></h4>
                        <br>
                    </div>
                </div>
                <div class="col-md-12" style="float: none; margin: 0 auto; text-align: center;">
                    <h6>Warning! <strong>Do not reload this page</strong> or the above display will be lost. If you want a hardcopy of this page, please print it now.</h6>
                </div>
            </div>
        </div>
    <?php } ?>

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
