<?php
include('db_connection.php'); // Make sure to include your database connection file
session_start();

if (!isset($_SESSION['login_client'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['game_id'])) {
    $game_id = $_POST['game_id'];

    // Check if the game is currently rented
    $sql = "SELECT COUNT(*) as count FROM rentedgames WHERE game_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo "Cannot delete the game because it is currently rented.";
    } else {
        // Delete the game
        $sql = "DELETE FROM videogame WHERE game_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $game_id);

        if ($stmt->execute()) {
            header("Location: index.php"); // Redirect to main page or wherever appropriate
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}
?>
