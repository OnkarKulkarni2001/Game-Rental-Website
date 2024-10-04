<?php
include('connection.php'); // Make sure to include your database connection file
session_start();

if (!isset($_SESSION['login_client'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['game_id'])) {
    $game_id = $_GET['game_id'];

    // Fetch game details
    $sql = "SELECT * FROM videogame WHERE game_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $game = $result->fetch_assoc();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_game'])) {
    $game_id = $_POST['game_id'];
    $game_name = $_POST['game_name'];
    $trailer_link = $_POST['trailer_link'];
    $price_day = $_POST['price_day'];
    $game_availability = $_POST['game_availability'];
    $platform = $_POST['platform'];
    
    // Update game details
    $sql = "UPDATE videogame SET game_name = ?, trailer_link = ?, price_day = ?, game_availability = ?, platform = ? WHERE game_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsdi", $game_name, $trailer_link, $price_day, $game_availability, $platform, $game_id);
    
    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to main page or wherever appropriate
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit Game</h2>
        <form action="editGame.php" method="POST">
            <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
            <div class="form-group">
                <label for="game_name">Game Name:</label>
                <input type="text" class="form-control" id="game_name" name="game_name" value="<?php echo $game['game_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="trailer_link">Trailer Embed Link:</label>
                <input type="text" class="form-control" id="trailer_link" name="trailer_link" value="<?php echo $game['trailer_link']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price_day">Price / Day:</label>
                <input type="text" class="form-control" id="price_day" name="price_day" value="<?php echo $game['price_day']; ?>" required>
            </div>
            <div class="form-group">
                <label for="game_availability">Game Availability (Yes/No):</label>
                <input type="text" class="form-control" id="game_availability" name="game_availability" value="<?php echo $game['game_availability']; ?>" required>
            </div>
            <div class="form-group">
                <label for="platform">Platform:</label>
                <input type="text" class="form-control" id="platform" name="platform" value="<?php echo $game['platform']; ?>" required>
            </div>
            <button type="submit" name="update_game" class="btn btn-primary">Update Game</button>
        </form>
    </div>
</body>
</html>
