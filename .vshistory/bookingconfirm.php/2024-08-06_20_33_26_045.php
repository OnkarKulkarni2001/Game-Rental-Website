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
