<?php 
include('session_client.php'); 
?> 
<?php
if (!isset($_SESSION['login_client'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['game_id'])) {
    $game_id = $_POST['game_id'];
    
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
?>
