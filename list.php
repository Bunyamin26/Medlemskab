<?php
header('Content-Type: text/html; charset=utf-8');

$conn = new mysqli('mysql97.unoeuro.com', 'bunyaminerman_dk', 'txDb6BGnaf9g3rAwkc5m', 'bunyaminerman_dk_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, navn, email, telefon, adresse, Betalingsstatus, kontigentyear FROM Medlemskab";
$result = $conn->query($sql);
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
            position: relative;
            font-size: 3rem;
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
<button class="button" onclick="window.location.href='index.html'" style="
    margin-top: 10px;
    margin-bottom: 10px;
    margin-left: 10px;
    background-color: #00c200;
">Gå til forsiden</button>
<table>
    <tr>
        <th style='display:none;'>ID</th>
        <th>Navn</th>
        <th>Email</th>
        <th>Telefonnummer</th>
        <th>Adresse</th>
        <th>Kontingentår</th>
        <th>Betalingsstatus</th>
        <th>Action</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td style='display:none;' class='showorder'>" . $row['id'] . "</td>
        <td class='showorder'>" . $row['navn'] . "</td>
        <td class='showorder'>" . $row['email'] . "</td>
        <td class='showorder'>" . $row['telefon'] . "</td>
        <td class='showorder'>" . $row['adresse'] . "</td>
        <td class='showorder'>" . $row['kontigentyear'] . "</td>
        <td id='statusicon' class='showorder'>" . $row['Betalingsstatus'] . "</td>
        <td><button class='edit-btn' onclick='openModal(\"" . $row['id'] . "\", \"" . $row['navn'] . "\", \"" . $row['email'] . "\", \"" . $row['telefon'] . "\", \"" . $row['adresse'] . "\", \"" . $row['Betalingsstatus'] . "\", \"" . $row['kontigentyear'] . "\")'><i class='fas fa-edit'></i> Rediger</button></td>
      </tr>";
    }
    ?>
</table>

<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <h2><span class="close" onclick="closeModal()">&times;</span></h2>
        <form id="editForm" action="update.php" method="post"> <!-- Specify method as post -->
            <input type="hidden" id="editId" name="editId">
            <label for="editNavn">Navn:</label>
            <input type="text" id="editNavn" name="editNavn" required>

            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail" name="editEmail" required>

            <label for="editTelefon">Telefonnummer:</label>
            <input type="tel" id="editTelefon" name="editTelefon" required>

            <label for="editAdresse">Adresse:</label>
            <input type="text" id="editAdresse" name="editAdresse" required>

            <label for="editYear">Kontingentår:</label>
            <input type="text" id="editYear" name="editYear" required>

            <label>Betalingsstatus:</label>
            <label for="editBetalt"><input type="checkbox" id="editBetalt" name="editBetalt"> Betalt</label>
            <label for="editIkkeBetalt"><input type="checkbox" id="editIkkeBetalt" name="editIkkeBetalt"> Ikke Betalt</label>

<button type="button" onclick="deleteRecord()" style="
    background-color: red;
">Slet</button>
          
            <button type="submit">Gem ændringer</button>
        </form>
    </div>
</div>

  <script>
    const statusIcons = document.querySelectorAll('#statusicon');

    statusIcons.forEach(icon => {
        const status = icon.textContent.trim();

        if (status === 'Ikke Betalt') {
            icon.innerHTML = '<i class="fas fa-circle-xmark" style="color: red;"></i>'; 
        } else if (status === 'Betalt') {
            icon.innerHTML = '<i class="fas fa-circle-check" style="color: green;"></i>'; // Green "check" icon
        }
    });
</script>
  
  
  <script>
    function deleteRecord() {
        var confirmation = confirm("Er du sikker på, at du vil slette denne post?");

        if (confirmation) {
            var id = document.getElementById("editId").value;

            var xhr = new XMLHttpRequest();
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        closeModal();
                        window.location.reload();
                    } else {
                        alert('Error deleting record: ' + response.message);
                    }
                } else {
                    alert('Error deleting record. Please try again.');
                }
            };

            xhr.open('POST', 'delete.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('deleteId=' + id);
        }
    }
</script>

  
<script>
    function openModal(id, navn, email, telefon, adresse, status, kontigentyear) {
        document.getElementById("editId").value = id;
        document.getElementById("editNavn").value = navn;
        document.getElementById("editEmail").value = email;
        document.getElementById("editTelefon").value = telefon;
        document.getElementById("editAdresse").value = adresse;
        document.getElementById("editYear").value = kontigentyear;

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

    function updateRecord(event) {
        event.preventDefault();

        // Get form data
        var id = document.getElementById("editId").value;
        var navn = document.getElementById("editNavn").value;
        var email = document.getElementById("editEmail").value;
        var telefon = document.getElementById("editTelefon").value;
        var adresse = document.getElementById("editAdresse").value;
        var status = document.getElementById("editBetalt").checked ? 'Betalt' : 'Ikke Betalt';
        var year = document.getElementById("editYear").value;

        // Create a FormData object to send the form data
        var formData = new FormData();
        formData.append('editId', id);
        formData.append('editNavn', navn);
        formData.append('editEmail', email);
        formData.append('editTelefon', telefon);
        formData.append('editAdresse', adresse);
        formData.append('editBetalt', status);
        formData.append('editYear', year);

        // Create an XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Define the callback function for when the request is complete
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Successful response, handle it here
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    closeModal();
                    window.location.reload(); // Reload the page or update the table
                } else {
                    alert('Error updating record: ' + response.message);
                }
            } else {
                // Error response, handle it here
                alert('Error updating record. Please try again.');
            }
        };

        // Open a POST request to update.php
        xhr.open('POST', 'update.php', true);

        // Send the FormData object with the form data
        xhr.send(formData);
    }
</script>


</body>
</html>
