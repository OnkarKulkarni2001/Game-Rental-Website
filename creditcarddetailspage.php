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
        <?php
        if (isset($_SESSION['login_client'])) {
        ?> 
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a></li>
                <li>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
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
        } else if (isset($_SESSION['login_customer'])) {
        ?>
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a></li>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
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
        } else {
        ?>
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="clientlogin.php">Employee</a></li>
                <li><a href="customerlogin.php">Customer</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </div>
        <?php
        }
        ?>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<div class="container">
    <div class="jumbotron">
        <h1 class="text-center">Enter Credit Card Details</h1>
    </div>
</div>

<div class="container">
    <h3 class="text-center">Please enter your payment information below.</h3>

    <div class="container">
        <div class="box">
            <div class="col-md-6" style="float: none; margin: 0 auto;">
                <form method="POST" action="process_payment.php">
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
                    <input type="hidden" name="orderId" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-success btn-block">Submit Payment</button>
                </form>
            </div>
        </div>
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
