<?php
include('session_customer.php');
if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $game_id = $_POST['hidden_gameid'];
    $rent_start_date = $_POST['rent_start_date'];
    $rent_end_date = $_POST['rent_end_date'];
    $cardNumber = $_POST['cardNumber'];
    $cardName = $_POST['cardName'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];

    // Here you would process the payment information securely.
    // This is just a placeholder. You should integrate with a payment gateway.

    // On successful payment, save the booking information to the database
    $sql = "INSERT INTO bookings (game_id, customer_id, rent_start_date, rent_end_date) VALUES ('$game_id', '".$_SESSION['login_customer']."', '$rent_start_date', '$rent_end_date')";

    if (mysqli_query($conn, $sql)) {
        echo "Booking successful!";
        // You can redirect to a confirmation page
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
