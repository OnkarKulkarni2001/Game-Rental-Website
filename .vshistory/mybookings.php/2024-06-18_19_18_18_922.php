<!DOCTYPE html>
<html>
<?php 
session_start();
require 'connection.php';
$conn = Connect();
?>
<head>
<link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
<title>My Bookings</title>
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
                <a class="navbar-brand page-scroll" href="index.php">
                  Online Video Game Rental </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            <?php
                if(isset($_SESSION['login_client'])){
            ?> 
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a>
                    </li>
                    <li>
                    <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="enterGame.php">Add Car</a></li>
              <li> <a href="view.php">View</a></li>

            </ul>
            </li>
          </ul>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>
            
            <?php
                }
                else if (isset($_SESSION['login_customer'])){
            ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                    </li>
                    <ul class="nav navbar-nav">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> My Orders <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="returnGame.php">Return Now</a></li>
              <li> <a href="mybookings.php"> My Bookings</a></li>
            </ul>
            </li>
          </ul>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>

            <?php
            }
                else {
            ?>

            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="clientlogin.php">Employee</a>
                    </li>
                    <li>
                        <a href="customerlogin.php">Customer</a>
                   </li>
                    <li>
                        <a href="#"> About </a>
                    </li>
                </ul>
            </div>
                <?php   }
                ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
 
<?php $login_customer = $_SESSION['login_customer']; 

    $sql1 = "SELECT * FROM rentedgames rv, videogame v
    WHERE rv.customer_username='$login_customer' AND v.game_id=rv.game_id AND rv.return_status='R'";
    $result1 = $conn->query($sql1);

    if (mysqli_num_rows($result1) > 0) {
?>

<div class="container">
    
        <br>
        <br>
        <br>
        <h1 class="text-center" style = "position:fixed;"><b>Your Bookings</b></h1>
      <br>
      <br>
        
        
    </div>

    <div class="table-responsive" style="padding-left: 100px; padding-right: 100px;" >
<table class="table table-striped">
  <thead class="thead-dark">
<tr>
<th width="15%">Order ID</th>
<th width="15%">Cover</th>
<th width="15%">Videogame</th>
<th width="15%">Platform</th>
<th width="15%">Start Date</th>
<th width="15%">End Date</th>
<th width="10%">Fare (/day)</th>
<th width="15%">Number of Days</th>
<th width="15%">Fine</th>
<th width="15%">Total Amount</th>
</tr>
</thead>
<?php
        while($row = mysqli_fetch_assoc($result1)) {
?>
<tr>
<td><?php echo $row["id"]; ?></td>
<td><img height = 100 width = 80 src="<?php echo $row["game_img"]; ?>" alt="Card image cap"></td>
<td><?php echo $row["game_name"]; ?></td>
<td><?php echo $row["platform"]; ?></td>
<td><?php echo $row["rent_start_date"] ?></td>
<td><?php echo $row["rent_end_date"]; ?></td>
<td> &#x20B9 <?php 
            
                echo ($row["fare"]);
            ?></td>

<td><?php echo $row["no_of_days"]; ?> </td>
<td> &#x20B9 <?php echo $row["fine"] ?></td>
<td> &#x20B9 <?php echo $row["total_amount"]; ?></td>
</tr>
<?php        } ?>
                </table>
                </div> 
        <?php } else {
            ?>
        <div class="container">
      <div class="jumbotron">
        <h1 class="text-center">You have not rented any games till now!</h1>
        <p class="text-center"> Your rented games will show up here after payment. </p>
      </div>
    </div>

            <?php
        } ?>   

</body>
<footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <h5>© <?php echo date("Y"); ?> Videogame Rentals | SQATE Section 3 Group 2</h5>
                </div>
            </div>
        </div>
    </footer>
</html>