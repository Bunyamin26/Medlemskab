<?php

$navn = $_POST['navn'];
$email = $_POST['email'];
$telefon = $_POST['telefon'];
$adresse = $_POST['adresse'];
$year = $_POST['year'];



// Database connection
$conn = new mysqli('mysql97.unoeuro.com', 'bunyaminerman_dk', 'txDb6BGnaf9g3rAwkc5m', 'bunyaminerman_dk_db');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO Medlemskab (navn, email, telefon, adresse, year)
        VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $navn, $email, $telefon, $adresse, $year);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirect to index.php
    header("Location: index.html");
    exit(); // Make sure to exit after the redirection
}
?>