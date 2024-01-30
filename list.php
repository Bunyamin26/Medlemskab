<?php
header('Content-Type: text/html; charset=utf-8');

$conn = new mysqli('mysql97.unoeuro.com', 'bunyaminerman_dk', 'txDb6BGnaf9g3rAwkc5m', 'bunyaminerman_dk_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT navn, email, telefon, adresse, Betalingsstatus FROM Medlemskab";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste</title>
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th>Navn</th>
        <th>Email</th>
        <th>Telefonnummer</th>
        <th>Adresse</th>
        <th>Betalingsstatus</th>
        <th>Action</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td class='showorder'>" . $row['navn'] . "</td>
                <td class='showorder'>" . $row['email'] . "</td>
                <td class='showorder'>" . $row['telefon'] . "</td>
                <td class='showorder'>" . $row['adresse'] . "</td>
                <td id='status' class='showorder'>" . $row['Betalingsstatus'] . "</td>
                <td><button class='edit-btn' onclick='openModal(\"" . $row['navn'] . "\", \"" . $row['email'] . "\", \"" . $row['telefon'] . "\", \"" . $row['adresse'] . "\", \"" . $row['Betalingsstatus'] . "\")'><i class='fas fa-edit'></i> Rediger</button></td>
              </tr>";
    }
    ?>
</table>

<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2></h2>
        <form id="editForm">
            <label for="editNavn">Navn:</label>
            <input type="text" id="editNavn" name="editNavn" required>

            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail" name="editEmail" required>

            <label for="editTelefon">Telefonnummer:</label>
            <input type="tel" id="editTelefon" name="editTelefon" required>

            <label for="editAdresse">Adresse:</label>
            <input type="text" id="editAdresse" name="editAdresse" required>

            <label>Betalingsstatus:</label>
            <label for="editBetalt"><input type="checkbox" id="editBetalt" name="editBetalt"> Betalt</label>
            <label for="editIkkeBetalt"><input type="checkbox" id="editIkkeBetalt" name="editIkkeBetalt"> Ikke Betalt</label>

            <button type="submit">Gem ændringer</button>
        </form>
    </div>
</div>

<script>
    function openModal(navn, email, telefon, adresse, status) {
        document.getElementById("editNavn").value = navn;
        document.getElementById("editEmail").value = email;
        document.getElementById("editTelefon").value = telefon;
        document.getElementById("editAdresse").value = adresse;

        // Check the appropriate checkbox based on the current status
        if (status === 'Betalt') {
            document.getElementById("editBetalt").checked = true;
        } else {
            document.getElementById("editIkkeBetalt").checked = true;
        }

        document.getElementById("myModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
</script>

</body>
</html>
