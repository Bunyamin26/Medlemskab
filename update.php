<?php
header('Content-Type: application/json; charset=utf-8');

$conn = new mysqli('mysql97.unoeuro.com', 'bunyaminerman_dk', 'txDb6BGnaf9g3rAwkc5m', 'bunyaminerman_dk_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['editId'];
    $navn = $_POST['editNavn'];
    $email = $_POST['editEmail'];
    $telefon = $_POST['editTelefon'];
    $adresse = $_POST['editAdresse'];
    $betalingsstatus = $_POST['editBetalt'] ? 'Betalt' : 'Ikke Betalt';
    $kontigentYear = $_POST['editYear']; 

    $sql = "UPDATE Medlemskab SET navn='$navn', email='$email', telefon='$telefon', adresse='$adresse', Betalingsstatus='$betalingsstatus', kontigentyear='$kontigentYear' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header('Location: list.php');
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating record: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
