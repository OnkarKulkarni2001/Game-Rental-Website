<?php 
include('session_customer.php');
if (!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $game_id = $conn->real_escape_string($_POST['hidden_gameid']);
    $game_name = $conn->real_escape_string($_POST['game_name']);
    $rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
    $rent_end_date = date('Y-m-d', strtotime($_POST['rent_end_date']));
    $price_day = $conn->real_escape_string($_POST['price_day']);
    
    // You can add payment processing code here.
    // After successful payment, redirect to bookingconfirm.php with POST method

    $_SESSION['game_id'] = $game_id;
    $_SESSION['game_name'] = $game_name;
    $_SESSION['rent_start_date'] = $rent_start_date;
    $_SESSION['rent_end_date'] = $rent_end_date;
    $_SESSION['price_day'] = $price_day;
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
    <div class="container">
        <div class="jumbotron">
            <h1 class="text-center" style="color: orange;">Payment Information</h1>
        </div>
        
        <div class="box">
            <div class="col-md-6" style="float: none; margin: 0 auto;">
                <form method="POST" action="bookingconfirm.php">
                    <div class="form-group">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="cardName">Name on Card</label>
                        <input type="text" class="form-control" id="cardName" name="cardName" required>
                    </div>
                    <div class="form-group">
                        <label for="expDate">Expiry Date</label>
                        <input type="text" class="form-control" id="expDate" name="expDate" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Proceed with Payment</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
