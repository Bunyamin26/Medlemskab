<?php


$navn = $_POST['navn'] ?? '';
$email = $_POST['email'] ?? '';
$telefon = $_POST['telefon'] ?? '';
$adresse = $_POST['adresse'] ?? '';
$kontigentyear = $_POST['year'] ?? '';

if (empty($navn) || empty($email) || empty($telefon) || empty($adresse) || empty($kontigentyear)) {
    die('All fields are required.');
}

$conn = new mysqli('mysql97.unoeuro.com', 'bunyaminerman_dk', 'txDb6BGnaf9g3rAwkc5m', 'bunyaminerman_dk_db');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO Medlemskab (navn, email, telefon, adresse, kontigentyear) VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    die('Prepare Failed: ' . $conn->error);
}

$stmt->bind_param("ssisi", $navn, $email, $telefon, $adresse, $kontigentyear);

if (!$stmt->execute()) {
    die('Execute Failed: ' . $stmt->error);
}

$stmt->close();
$conn->close();

header("Location: index.html");
exit(); 
?>
