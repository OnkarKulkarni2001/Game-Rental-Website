<?php
include('session_client.php');


// Handle editing a game
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Update game details
        $game_name = $_POST['game_name'];
        $price_day = $_POST['price_day'];
        $game_availability = $_POST['game_availability'];
        $platform = $_POST['platform'];

        $update_sql = "UPDATE videogame SET game_name='$game_name', price_day='$price_day', game_availability='$game_availability', platform='$platform' WHERE id='$id'";
        mysqli_query($conn, $update_sql);

        header('Location: enterGame.php'); // Redirect to avoid form resubmission
        exit;
    }

    // Fetch current game details
    $query = "SELECT * FROM videogame WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
} 

// Handle deleting a game
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the game
    $delete_sql = "DELETE FROM videogame WHERE id='$id'";
    mysqli_query($conn, $delete_sql);

    header('Location: enterGame.php'); // Redirect to avoid form resubmission
    exit;
}

// Handle adding a new game
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $game_name = $_POST['game_name'];
    $price_day = $_POST['price_day'];
    $game_availability = $_POST['game_availability'];
    $platform = $_POST['platform'];

    // Handle file upload
    if (isset($_FILES['uploadedimage']) && $_FILES['uploadedimage']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // Ensure this directory exists and is writable
        $upload_file = $upload_dir . basename($_FILES['uploadedimage']['name']);
        move_uploaded_file($_FILES['uploadedimage']['tmp_name'], $upload_file);
    } else {
        $upload_file = ''; // Handle cases where no file is uploaded
    }

    $insert_sql = "INSERT INTO videogame (game_name, price_day, game_availability, platform, game_img) VALUES ('$game_name', '$price_day', '$game_availability', '$platform', '$upload_file')";
    mysqli_query($conn, $insert_sql);

    header('Location: enterGame.php'); // Redirect to avoid form resubmission
    exit;
}

// Fetch all games
$sql = "SELECT * FROM videogame";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
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
        .container {
            margin-top: 65px;
        }
        .form-area {
            text-align: center;
            margin: 0 auto;
            max-width: 800px;
        }
        .table-container {
            display: flex;
            justify-content: center;
            overflow-x: auto;
        }
        table {
            margin: auto;
            width: auto;
        }
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

            <?php if (isset($_SESSION['login_client'])) { ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
            <?php } else if (isset($_SESSION['login_customer'])) { ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a></li>
                    <li><a href="#">History</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
            <?php } else { ?>
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

    <div class="container">
        <div class="form-area">
            <?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) { ?>
            <h2>Edit Game</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="game_name">Game Name:</label>
                    <input type="text" class="form-control" id="game_name" name="game_name" value="<?php echo $row['game_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price_day">Price / Day:</label>
                    <input type="text" class="form-control" id="price_day" name="price_day" value="<?php echo $row['price_day']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="game_availability">Game Availability:</label>
                    <input type="text" class="form-control" id="game_availability" name="game_availability" value="<?php echo $row['game_availability']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="platform">Platform:</label>
                    <input type="text" class="form-control" id="platform" name="platform" value="<?php echo $row['platform']; ?>" required>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
            <?php } else { ?>
            <h2>Add New Game</h2>
            <form role="form" action="enterGame.php" enctype="multipart/form-data" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" id="game_name" name="game_name" placeholder="Game Name" required>
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
            <?php } ?>
        </div>

        <div class="form-area">
            <h3 style="margin-bottom: 25px; font-size: 30px;">My Games</h3>
            <?php if (mysqli_num_rows($result) > 0) { ?>
            <div class="table-container">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th width="24%">Cover</th>
                            <th width="15%">Game</th>
                            <th width="13%">Fare</th>
                            <th width="17%">Game Availability</th>
                            <th width="13%">Platform</th>
                            <th width="15%">Actions</th> <!-- New column for actions -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><img height="100" width="80" src="<?php echo $row["game_img"]; ?>" alt="Card image cap"></td>
                            <td><?php echo $row["game_name"]; ?></td>
                            <td><?php echo $row["price_day"]; ?></td>
                            <td><?php echo $row["game_availability"]; ?></td>
                            <td><?php echo $row["platform"]; ?></td>
                            <td>
                                <a href="enterGame.php?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="enterGame.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this game?');">Delete</a>
                            </td>
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
