<!DOCTYPE html>
<html>

<?php 
include('session_customer.php');
if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: customerlogin.php");
    exit;
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

<?php
$customer_username = $_SESSION["login_customer"];

// Check if POST variables are set
if (isset($_POST['hidden_gameid'], $_POST['rent_start_date'], $_POST['rent_end_date'])) {
    $game_id = $conn->real_escape_string($_POST['hidden_gameid']);
    $rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
    $rent_end_date = date('Y-m-d', strtotime($_POST['rent_end_date']));
} else {
    die("Required data not received. Please go back and try again.");
}

$return_status = "NR"; // not returned
$fare = "NA";

function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$err_date = dateDiff("$rent_start_date", "$rent_end_date");
$no_of_days = $err_date;
if ($no_of_days <= 0){
    $no_of_days = 1;
}

$sql0 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
$result0 = $conn->query($sql0);
if ($result0->num_rows == 0) {
    die("The selected game ID does not exist. Please choose a valid game.");
}
$row0 = mysqli_fetch_assoc($result0);
$fare = $row0["price_day"];
$total = $fare * $no_of_days;

if($err_date >= 0) { 
    $sql1 = "INSERT INTO rentedgames(`customer_username`, `game_id`, `booking_date`, `rent_start_date`, `rent_end_date`, `fare`, `no_of_days`, `total_amount`, `return_status`)
    VALUES('" . $customer_username . "','" . $game_id . "','" . date("Y-m-d") ."','" . $rent_start_date ."','" . $rent_end_date . "','" . $fare . "','" . $no_of_days . "','" . $total ."','" . $return_status . "')";
    $result1 = $conn->query($sql1);

    $sql2 = "UPDATE videogame SET game_availability = 'no' WHERE game_id = '$game_id'";
    $result2 = $conn->query($sql2);

    $sql4 = "SELECT * FROM  videogame c WHERE c.game_id = '$game_id'";
    $result4 = $conn->query($sql4);

    if (mysqli_num_rows($result4) > 0) {
        while($row = mysqli_fetch_assoc($result4)) {
            $id = $row["game_id"];
            $game_name = $row["game_name"];
        }
    }

    if (!$result1 || !$result2 ){
        die("Could not enter data: ".$conn->error);
    }
?>

<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="index.php">VideoGame Rentals</a>
        </div>

        <?php
        if(isset($_SESSION['login_client'])){
        ?> 
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a></li>
                <li>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span>
                        </a>
                            <ul class="dropdown-menu">
                                <li><a href="enterGame.php">Add Videogame</a></li>
                                <li><a href="view.php">View</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
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
                <ul class="nav navbar-nav">
                    <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        My Orders <span class="caret"></span>
                    </a>
                        <ul class="dropdown-menu">
                            <li><a href="returnGame.php">Return Now</a></li>
                            <li><a href="mybookings.php">My Bookings</a></li>
                        </ul>
                    </li>
                </ul>
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
                <li><a href="clientlogin.php">Client</a></li>
                <li><a href="customerlogin.php">Customer</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>
        <?php
        }
        ?>
    </div>
</nav>

<div class="container">
    <div class="jumbotron" style="text-align: center;">
        <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Booking Confirmed.</h1>
    </div>
</div>
<br>
<h2 class="text-center">Thank you for visiting VideoGame Rentals! We wish you have a safe rental experience.</h2>

<h3 class="text-center"><strong>Your Order Number:</strong> <span style="color: blue;"><?php echo $id; ?></span></h3>
<h3 class="text-center"><strong>Game Name:</strong> <span style="color: blue;"><?php echo $game_name; ?></span></h3>
<h3 class="text-center"><strong>Rent Start Date:</strong> <span style="color: blue;"><?php echo $rent_start_date; ?></span></h3>
<h3 class="text-center"><strong>Rent End Date:</strong> <span style="color: blue;"><?php echo $rent_end_date; ?></span></h3>
<h3 class="text-center"><strong>Fare:</strong> <span style="color: blue;">₹<?php echo $fare; ?>/day</span></h3>
<h3 class="text-center"><strong>Number of days:</strong> <span style="color: blue;"><?php echo $no_of_days; ?></span></h3>
<h3 class="text-center"><strong>Total Amount:</strong> <span style="color: blue;">₹<?php echo $total; ?></span></h3>

<?php
} else { 
    ?>
    <div class="container">
        <div class="jumbotron" style="text-align: center;">
            <h1>Invalid Dates!</h1>
            <p>Kindly Try Again.</p>
        </div>
    </div>
    <?php
}
?>
</body>
</html>
