<?php 
 include('session_customer.php');
if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
}
?>
<?php


    #$type = $_POST['radio'];
    #$charge_type = $_POST['radio1'];
    #$driver_id = $_POST['driver_id_from_dropdown'];
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
    
    $err_date = dateDiff("$rent_start_date", "$rent_end_date");
    $no_of_days = $err_date;
    if ($no_of_days <= 0){
        $no_of_days = 1;
    }
    $sql0 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
    $result0 = $conn->query($sql0);
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

    if (!$result1 | !$result2 ){
        die("Couldnt enter data: ".$conn->error);
    }

?>
<?php
        $game_id = $_GET["id"];
        $sql1 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
        $result1 = mysqli_query($conn, $sql1);

        if(mysqli_num_rows($result1)){
            while($row1 = mysqli_fetch_assoc($result1)){
                $game_name = $row1["game_name"];
                $price_day = $row1["price_day"];
                $trailer = $row1["trailer_link"];
                $platform = $row1["platform"];
                $game_img = $row1["game_img"];
                $platform_img = $row1["platform_img"];
            }
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
