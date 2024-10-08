<!DOCTYPE html>
<html>

<?php
include('session_customer.php');
if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: customerlogin.php");
    exit;
}

include('connection.php'); // Assuming there's a file to handle database connection

function dateDiff($start, $end)
{
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$customer_username = $_SESSION["login_customer"];
$game_id = $conn->real_escape_string($_POST['hidden_gameid']);
$rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
$rent_end_date = date('Y-m-d', strtotime($_POST['rent_end_date']));
$return_status = "NR"; // not returned

$err_date = dateDiff($rent_start_date, $rent_end_date);
$no_of_days = max(1, $err_date); // Ensures at least one day of booking

$sql0 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
$result0 = $conn->query($sql0);
$row0 = $result0->fetch_assoc();
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
    $row = $result4->fetch_assoc();
    $game_name = $row["game_name"];
    $client_name = "John Doe"; // Example employee name
    $client_phone = "123-456-7890"; // Example employee contact

    if (!$result1 || !$result2) {
        die("Could not enter data: " . $conn->error);
    }
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
                    VideoGame Rentals </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <?php
            if (isset($_SESSION['login_client'])) {
            ?>
                <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a>
                        </li>
                        <li>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="enterGame.php">Add Videogame</a></li>
                                        <li><a href="view.php">View</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                        </li>
                    </ul>
                </div>
            <?php
            } else if (isset($_SESSION['login_customer'])) {
            ?>
                <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                        </li>
                        <ul class="nav navbar-nav">
                            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> My Orders <span class="caret"></span> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="returnGame.php">Return Now</a></li>
                                    <li><a href="mybookings.php"> My Bookings</a></li>
                                </ul>
                            </li>
                        </ul>
                        <li>
                            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                        </li>
                    </ul>
                </div>
            <?php
            } else {
            ?>
                <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="clientlogin.php">Employee</a>
                        </li>
                        <li>
                            <a href="customerlogin.php">Customer</a>
                        </li>
                        <li>
                            <a href="#"> FAQ </a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <?php if ($err_date >= 0) { ?>
        <div class="container">
            <div class="jumbotron">
                <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Booking Confirmed.</h1>
            </div>
        </div>
        <br>

        <h2 class="text-center"> Thank you for using Videogame Rental System! </h2>

        <h3 class="text-center"> <strong>Your Order Number:</strong> <span style="color: blue;"><?php echo $game_id; ?></span> </h3>

        <div class="container">
            <h5 class="text-center">Please read the following information about your order.</h5>
            <div class="box">
                <div class="col-md-10" style="float: none; margin: 0 auto; text-align: center;">
                    <h3 style="color: orange;">Your booking has been received and placed into our order processing system.</h3>
                    <br>
                    <h4>Please make a note of your <strong>order number</strong> now and keep it in the event you need to communicate with us about your order.</h4>
                    <br>
                    <h3 style="color: orange;">Invoice</h3>
                    <br>
                </div>
                <div class="col-md-10" style="float: none; margin: 0 auto;">
                    <h4> <strong>Game Name: </strong> <?php echo $game_name; ?></h4>
                    <br>
                    <h4> <strong>Fare:</strong> Rs. <?php echo $fare; ?>/day</h4>
                    <br>
                    <h4> <strong>Booking Date: </strong> <?php echo date("Y-m-d"); ?> </h4>
                    <br>
                    <h4> <strong>Start Date: </strong> <?php echo $rent_start_date; ?></h4>
                    <br>
                    <h4> <strong>Return Date: </strong> <?php echo $rent_end_date; ?></h4>
                    <br>
                    <h4> <strong>Employee Name:</strong> <?php echo $client_name; ?></h4>
                    <br>
                    <h4> <strong>Employee Contact: </strong> <?php echo $client_phone; ?></h4
                <br>
                <h4> <strong>Total Amount: </strong> Rs. <?php echo $total; ?></h4>
                <br>
            </div>
        </div>
        <div class="col-md-12" style="float: none; margin: 0 auto; text-align: center;">
            <h6>Please <strong>Note</strong>: You can <strong>Cancel</strong> the booking until 2 hours prior to the pickup time.</h6>
        </div>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="jumbotron">
            <h1 class="text-center" style="color: red;"><span class="glyphicon glyphicon-remove-circle"></span> Booking Failed.</h1>
        </div>
    </div>
    <br>
    <div class="container">
        <h5 class="text-center">Error: The booking dates provided are invalid. Please choose the correct dates.</h5>
    </div>
<?php } ?>
</body>
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h5>© 2020 VideoGame Rentals</h5>
            </div>
        </div>
    </div>
</footer>
</html>