<?php
// creditcarddetails.php
include('session_customer.php');
if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Credit Card Details</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="index.php">Online Video Game Rental</a>
        </div>
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                </li>
                <li>
                    <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 65px;">
    <div class="col-md-7" style="float: left; margin: 0 auto;">
        <div class="form-area">
            <form role="form" action="processpayment.php" method="POST">
                <br style="clear: both">
                <h3 style="margin-bottom: 25px; text-align: center;">Credit Card Details</h3>

                <div class="form-group">
                    <label for="cardNumber">Card Number</label>
                    <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
                </div>

                <div class="form-group">
                    <label for="cardName">Name on Card</label>
                    <input type="text" class="form-control" id="cardName" name="cardName" required>
                </div>

                <div class="form-group">
                    <label for="expiryDate">Expiry Date</label>
                    <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
                </div>

                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" required>
                </div>

                <input type="hidden" name="hidden_gameid" value="<?php echo $_POST['hidden_gameid']; ?>">
                <input type="hidden" name="rent_start_date" value="<?php echo $_POST['rent_start_date']; ?>">
                <input type="hidden" name="rent_end_date" value="<?php echo $_POST['rent_end_date']; ?>">

                <button type="submit" class="btn btn-primary pull-right">Submit Payment</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
