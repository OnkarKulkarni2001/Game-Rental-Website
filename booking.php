<!DOCTYPE html>
<html>
<?php 
 include('session_customer.php');
 if (!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
    exit;
 }
?> 
<head>
    <title>Rent Video Game</title>
    <script type="text/javascript" src="assets/ajs/angular.min.js"> </script>
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
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Orders <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="returnGame.php">Return Now</a></li>
                        <li><a href="mybookings.php">My Bookings</a></li>
                    </ul>
                </li>
                <li>
                    <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<div class="container" style="margin-top: 65px;">
    <div class="col-md-7" style="float: left; margin: 0 auto;">
        <div class="form-area">
            <form role="form" action="process_payment.php" method="POST">
                <br style="clear: both">
                <br>
                <?php
                $game_id = $_GET["id"];
                $sql1 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
                $result1 = mysqli_query($conn, $sql1);

                if (mysqli_num_rows($result1) > 0) {
                    $row1 = mysqli_fetch_assoc($result1);
                    $game_name = $row1["game_name"];
                    $price_day = $row1["price_day"];
                    $trailer = $row1["trailer_link"];
                    $platform = $row1["platform"];
                    $game_img = $row1["game_img"];
                    $platform_img = $row1["platform_img"];
                }
                ?>
                <iframe width="1110" height="400" src="<?php echo $trailer; ?>?rel=0&amp;autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <br>

                <div class="aligned">
                    <img class="card-img-top" src="<?php echo $game_img; ?>" alt="Card image cap" width="200px" height="300px">
                    <span>
                        <h5><b><?php echo $game_name; ?></b></h5>
                        <img height="20" width="20" src="<?php echo $platform_img; ?>" alt="Platform icon">
                        <h5> Platform:&nbsp;<b><?php echo $platform; ?></b></h5>
                    </span>
                </div>

                <?php $today = date("Y-m-d"); ?>
                <label><h5>From:</h5></label>
                <input type="date" name="rent_start_date" min="<?php echo $today; ?>" required="">
                &nbsp;
                <label><h5>To:</h5></label>
                <input type="date" name="rent_end_date" min="<?php echo $today; ?>" required="">

                <div ng-switch="myVar">
                    <h5>Fare: <b><?php echo "CAD. " . $price_day; ?></b></h5>
                </div>

                <br><br>
                <input type="hidden" name="hidden_gameid" value="<?php echo $game_id; ?>">
                <input type="hidden" name="game_name" value="<?php echo $game_name; ?>">
                <input type="hidden" name="price_day" value="<?php echo $price_day; ?>">
                <input type="submit" name="submit" value="Rent Now" class="btn btn-warning pull-right">
            </form>
        </div>
    </div>
</div>
</body>
</html>
