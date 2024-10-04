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
    <div class="container" style="margin-top: 65px;" >
    <div class="col-md-7" style="float: left; margin: 0 auto;">
      <div class="form-area">
        <form role="form" action="bookingconfirm.php" method="POST">
        <br style="clear: both">
          <br>
          
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
      <iframe width="1110" height="400" src="<?php echo($trailer);?>?rel=0&amp;autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen ></iframe>
        
      <br>
          
            <!-- <div class="form-group"> -->
            <div class="aligned">
                     <img class="card-img-top" src="<?php echo $game_img; ?>" alt="Card image cap" width = "200px" height = "300px">   
             <span>
                    <h5><b><?php echo($game_name);?></b></h5>
         <!-- </div> -->
          <!-- <div class="form-group"> -->
            <img height = "20" width = "20" src="<?php echo $platform_img; ?>" alt="Card image cap">
            <h5> Platform:&nbsp;<b> <?php echo($platform);?></b></h5>
    </span>
    </div>
        

          <!-- </div>      -->
        <!-- <div class="form-group"> -->
        <?php $today = date("Y-m-d") ?>
          <label><h5>From:</h5></label>
            <input type="date" name="rent_start_date" min="<?php echo($today);?>" required="">
            &nbsp; 
          <label><h5>To:</h5></label>
          <input type="date" name="rent_end_date" min="<?php echo($today);?>" required="">
        <!-- </div>      -->
    
        <div ng-switch="myVar"> 
                    <!-- <div class="form-group"> -->
                <h5>Fare: <b><?php echo("CAD. " . $price_day);?></b><h5>    
                <!-- </div>    -->
        </div>


            <br><br>
                <!-- <form class="form-group"> -->
                
                <!-- </form> -->
                
                <input type="hidden" name="hidden_gameid" value="<?php echo $game_id; ?>">
                
         
           <input type="submit"name="submit" value="Rent Now" class="btn btn-warning pull-right">     
        </form>
        
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
