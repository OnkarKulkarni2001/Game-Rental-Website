<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "videogamerental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: customerlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $orderId = isset($_POST['orderId']) ? $conn->real_escape_string($_POST['orderId']) : '';
    $cardNumber = isset($_POST['cardNumber']) ? $conn->real_escape_string($_POST['cardNumber']) : '';
    $cardName = isset($_POST['cardName']) ? $conn->real_escape_string($_POST['cardName']) : '';
    $expDate = isset($_POST['expDate']) ? $conn->real_escape_string($_POST['expDate']) : '';
    $cvv = isset($_POST['cvv']) ? $conn->real_escape_string($_POST['cvv']) : '';

    // Validate required fields
    if (empty($orderId) || empty($cardNumber) || empty($cardName) || empty($expDate) || empty($cvv)) {
        die("All fields are required.");
    }

    // Placeholder for payment processing
    $payment_successful = true; // This should be replaced with actual payment gateway integration

    if ($payment_successful) {
        // Update the booking status
        $sql = "UPDATE rentedgames SET payment_status = 'Completed' WHERE game_id = '$orderId'";

        if ($conn->query($sql) === TRUE) {
            $sql1 = "SELECT * FROM rentedgames WHERE game_id = '$orderId'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();
            $game_id = $row1["game_id"];

            $sql2 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();
            $game_name = $row2["game_name"];

            $conn->close();
        } else {
            die("Error updating booking status: " . $conn->error);
        }
    } else {
        echo "Payment failed. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>

<!DOCTYPE html>
<html>

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

        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="jumbotron">
        <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Booking Confirmed.</h1>
    </div>
</div>
<br>

<h2 class="text-center"> Thank you for using Videogame Rental System! </h2>
<h3 class="text-center"><strong>Your Order Number:</strong> <span style="color: blue;"><?php echo $orderId; ?></span></h3>

<div class="container">
    <h5 class="text-center">Please read the following information about your order.</h5>
    <div class="box">
        <div class="col-md-10" style="float: none; margin: 0 auto; text-align: center;">
            <h3 class="text-center"><strong>Your Order Number:</strong> <span style="color: blue;"><?php echo isset($orderId) ? $orderId : 'N/A'; ?></span></h3>

            <h3 style="color: orange;">Your booking has been received and placed into our order processing system.</h3>
            <br>
            <h4>Please make a note of your <strong>order number</strong> now and keep it in the event you need to communicate with us about your order.</h4>
            <br>
            <h3 style="color: orange;">Invoice</h3>
            <br>
        </div>
        <div class="col-md-10" style="float: none; margin: 0 auto;">
            <h4><strong>Game Name:</strong> <?php echo $game_name; ?></h4>
            <br>
            <h4><strong>Booking Date:</strong> <?php echo date("Y-m-d"); ?></h4>
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
