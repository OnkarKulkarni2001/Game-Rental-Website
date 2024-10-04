<!DOCTYPE html>
<html>
<?php 
 include('session_customer.php');
if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
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
$game_id = $conn->real_escape_string($_POST['hidden_gameid']);
$rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
$rent_end_date = date('Y-m-d', strtotime($_POST['rent_end_date']));
$return_status = "NR"; // not returned

function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$duration = dateDiff("$rent_start_date", "$rent_end_date");
$sql0 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
$result0 = mysqli_query($conn, $sql0);

if(mysqli_num_rows($result0) > 0) {
    while($row0 = mysqli_fetch_assoc($result0)){
        $game_name = $row0["game_name"];
        $price_day = $row0["price_day"];
        $platform_img = $row0["platform_img"];
        $game_img = $row0["game_img"];
        $total_amount = $price_day * $duration;
    }
}

if($total_amount === null || $duration <= 0) {
    ?>
    <div class="container">
        <div class="jumbotron" style="text-align: center;">
            <h1>Invalid Dates or Game ID!</h1>
            <p>Please go back and select valid details.</p>
        </div>
    </div>
    <?php
    die();
}

$sql1 = "INSERT INTO rentedvideogames(game_id, customer_username, rent_start_date, rent_end_date, fare, return_status) 
VALUES('$game_id', '$customer_username','$rent_start_date', '$rent_end_date', '$total_amount','$return_status')";
$result1 = $conn->query($sql1);

if ($result1){
    $id = $conn->insert_id;
    ?>

    <div class="container">
        <div class="jumbotron" style="text-align: center;">
            <h2>Thank you for Renting!</h2>
            <h3>Your order has been received successfully.</h3>
        </div>
    </div>
    <br>

    <h5> Order Details</h5>
    <div class="container" style="float: none; margin-bottom: 2px; width: 70%;">
        <div class="jumbotron" style="float: none; margin-bottom: 2px;">
            <ul class="list-group">
                <li class="list-group-item"><b>Game Name: </b> <?php echo $game_name; ?></li>
                <li class="list-group-item"><b>Game Platform: </b> <img src="<?php echo $platform_img; ?>" height="50px" width="50px"></li>
                <li class="list-group-item"><b>Fare:&nbsp;</b>  <?php echo $price_day; ?></li>
                <li class="list-group-item"><b>Rental Days:&nbsp;</b>  <?php echo $duration; ?></li>
                <li class="list-group-item"><b>Game image: </b><img src="<?php echo $game_img; ?>" height="100px" width="100px"></li>
                <li class="list-group-item"><b>Total Amount:&nbsp;</b>CAD.<?php echo $total_amount; ?></li>
                <li class="list-group-item"><b>Rent Date: </b> <?php echo $rent_start_date; ?></li>
                <li class="list-group-item"><b>Return Date:</b> <?php echo $rent_end_date; ?></li>
            </ul>
        </div>
    </div>

    <?php
} else {
    ?>

    <div class="container">
        <div class="jumbotron" style="text-align: center;">
            Something went wrong!
            <br>
            Please try again.
        </div>
    </div>

    <?php
}
?>

</body>
</html>
