<?php 
session_start();
require 'connection.php';
$conn = Connect();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <link rel="stylesheet" type="text/css" href="assets/css/customerlogin.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/clientpage.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/bookingconfirm.css" />
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="index.php">Videogame Rentals</a>
        </div>

        <?php if(isset($_SESSION['login_client'])) { ?>
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Control Panel <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="enterGame.php">Add Videogame</a></li>
                        <li><a href="view.php">View</a></li>
                    </ul>
                </li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>

        <?php } else if (isset($_SESSION['login_customer'])) { ?>
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Orders <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="returnGame.php">Return Now</a></li>
                        <li><a href="mybookings.php">My Bookings</a></li>
                    </ul>
                </li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>

        <?php } else { ?>
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="clientlogin.php">Employee</a></li>
                <li><a href="customerlogin.php">Customer</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>
        <?php } ?>
    </div>
</nav>

<?php 
$id = $_GET["id"];
$fare = $conn->real_escape_string($_POST['hid_fare']);
$game_return_date = date('Y-m-d');

$return_status = "R";
$login_customer = $_SESSION['login_customer'];

$sql0 = "SELECT rv.id, rv.rent_end_date, rv.rent_start_date, rv.total_amount, v.game_name, v.game_img, v.platform FROM rentedgames rv JOIN videogame v ON v.game_id = rv.game_id WHERE rv.id = '$id'";
$result0 = $conn->query($sql0);

if(mysqli_num_rows($result0) > 0) {
    while($row0 = mysqli_fetch_assoc($result0)){
        $rent_end_date = $row0["rent_end_date"];  
        $rent_start_date = $row0["rent_start_date"];
        $game_name = $row0["game_name"];
        $total_amount = $row0["total_amount"];
        $game_img = $row0["game_img"];
        $platform = $row0["platform"];
    }
}

function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$extra_days = dateDiff($rent_end_date, $game_return_date);
$total_fine = 0;

if ($extra_days > 0){
    $total_fine = $extra_days * $fare; // Assuming fine is charged per extra day
}

$duration = dateDiff($rent_start_date, $game_return_date);
if ($duration <= 1){
    $duration = 1;
}

$total_amount = ($duration * $fare) + $total_fine;

$sql1 = "UPDATE rentedgames SET game_return_date='$game_return_date', no_of_days='$duration', total_amount='$total_amount', fine='$total_fine', return_status='$return_status' WHERE id = '$id'";
$result1 = $conn->query($sql1);

if ($result1){
    $sql2 = "UPDATE videogame v, rentedgames rv SET v.game_availability='yes' 
    WHERE rv.game_id=v.game_id AND rv.customer_username = '$login_customer' AND rv.id = '$id'";
    $result2 = $conn->query($sql2);
} else {
    echo $conn->error;
}
?>

<div class="container">
    <div class="jumbotron">
        <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Videogame Returned</h1>
        <img height="280" width="230" src="<?php echo $game_img; ?>" alt="Card image cap">
        <h4><strong>Game Name: </strong> <?php echo $game_name;?></h4>
        <h4><strong>Platform: </strong> <?php echo $platform;?></h4>
        <h4><strong>Fare: </strong> CAD. <?php echo ($fare . "/day");?></h4>
    </div>
</div>
<br>

<h2 class="text-center">Thank you for using Video Game Rental!</h2>

<h3 class="text-center"><strong>Your Order Number:</strong> <span style="color: blue;"><?php echo "$id"; ?></span></h3>

<div class="container">
    <h5 class="text-center">Please read the following information about your order.</h5>
    <div class="box">
        <div class="col-md-10" style="float: none; margin: 0 auto; text-align: center;">
            <h3 style="color: orange;">Your Return Request has been processed.</h3>
            <br>
            <h3 style="color: orange;">Invoice</h3>
            <br>
        </div>
        <div class="col-md-10" style="float: none; margin: 0 auto;">
            <h4><strong>Booking Date: </strong> <?php echo date("Y-m-d"); ?> </h4>
            <br>
            <h4><strong>Start Date: </strong> <?php echo $rent_start_date; ?></h4>
            <br>
            <h4><strong>Rent End Date: </strong> <?php echo $rent_end_date; ?></h4>
            <br>
            <h4><strong>Game Return Date: </strong> <?php echo $game_return_date; ?> </h4>
            <br>
            <?php if($extra_days > 0){ ?>
            <h4><strong>Total Fine:</strong> <label class="text-danger"> CAD. <?php echo $total_fine; ?> </label> for <?php echo $extra_days;?> extra days.</h4>
            <br>
            <?php } ?>
            <h4><strong>Total Amount: </strong> CAD. <?php echo $total_amount; ?> </h4>
            <br>
            <h3><strong>SECURITY DEPOSIT OF CAD. 150 WILL BE REFUNDED AFTER YOU RETURN GAME IN PERSON TO THE STORE!</strong>$headingColor = "red"; // Change to desired color</h4>
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
                <h5>© <?php echo date("Y"); ?> Car Rentals</h5>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
