<!DOCTYPE html>
<html>

<?php 
include('session_client.php'); ?> 

<head>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/customerlogin.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/clientpage.css" />
    <style>
        /* Center the navbar */
        .navbar-custom {
            text-align: center;
        }
        
        /* Center the form and table */
        .form-area {
            text-align: center;
        }

        .table-container {
            display: flex;
            justify-content: center;
            overflow-x: auto;
        }

        /* Center the table within the container */
        table {
            margin: auto;
            width: auto; /* Ensures the table width adjusts automatically */
        }

        /* Add padding to table cells */
        th, td {
            padding: 8px;
        }

        /* Center footer text */
        .site-footer {
            text-align: center;
            padding: 20px;
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">Videogame Rentals</a>
            </div>

            <?php
                if (isset($_SESSION['login_client'])) {
            ?> 
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a></li>
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
                    <li><a href="#">History</a></li>
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
            <?php } ?>
        </div>
    </nav>

    <div class="container" style="margin-top: 65px;">
        <div class="col-md-7 col-md-offset-2">
            <div class="form-area">
                <form role="form" action="enterGame1.php" enctype="multipart/form-data" method="POST">
                    <br style="clear: both">
                    <h3 style="margin-bottom: 25px; font-size: 30px;">Please Provide New Game Details</h3>

                    <div class="form-group">
                        <input type="text" class="form-control" id="game_name" name="game_name" placeholder="Game Name" required autofocus="">
                    </div>

                    <div class="form-group">
                        <input name="uploadedimage" type="file">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="trailer_link" name="trailer_link" placeholder="Trailer Embed Link" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="price_day" name="price_day" placeholder="Price / Day" required>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="game_availability" name="game_availability" placeholder="Game Availability (Yes/No)" required>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="platform" name="platform" placeholder="Platform" required>
                    </div>

                    <button type="submit" id="submit" name="submit" class="btn btn-success">Submit for Rental</button>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-area" style="padding: 0px 100px;">
                <h3 style="margin-bottom: 25px; font-size: 30px;">My Games</h3>
                <?php
                // Storing Session
                $user_check = $_SESSION['login_client'];
                $sql = "SELECT * FROM videogame;";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                ?>
                <div class="table-container">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th width="24%">Cover</th>
                                <th width="15%">Game</th>
                                <th width="13%">Fare</th>
                                <th width="17%">Game Availability</th>
                                <th width="13%">Platform</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><span class="glyphicon glyphicon-menu-right"></span></td>
                                <td><img height="100" width="80" src="<?php echo $row["game_img"]; ?>" alt="Card image cap"></td>
                                <td><?php echo $row["game_name"]; ?></td>
                                <td><?php echo $row["price_day"]; ?></td>
                                <td><?php echo $row["game_availability"]; ?></td>
                                <td><?php echo $row["platform"]; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                <h4>No Games available</h4>
                <?php } ?>
            </div>
        </div>
    </div>

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
</body>

</html>
