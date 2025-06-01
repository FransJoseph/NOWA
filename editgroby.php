<?php
@include 'dbconfig.php'; // @ dla tłumienia błędów
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Nieprawidłowe ID grobu.");
}

$id = (int)$_GET['id'];

@$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM groby WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="pl">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Edycja grobu</title>
        <style>
            /* Prosta walidacja wizualna */
            input:invalid {
                border-color: red;
            }
        </style>
        <script>
            // Prosta walidacja JS przed wysłaniem formularza
            function validateForm() {
                const lokalizacja = document.getElementById('lokalizacja').value.trim();
                const oplataTak = document.getElementById('oplata_tak').checked;
                const oplataNie = document.getElementById('oplata_nie').checked;

                if (!lokalizacja) {
                    alert("Pole Lokalizacja jest wymagane.");
                    return false;
                }
                if (!oplataTak && !oplataNie) {
                    alert("Proszę wybrać opłatę.");
                    return false;
                }
                return true;
            }
        </script>
    </head>

    <body>
    <h2>Edycja grobu</h2>

    <form action="zapisz_editgrobu.php" method="post" onsubmit="return validateForm()">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>" />

        <div class="form-group">
            <label for="lokalizacja">Lokalizacja:</label>
            <input type="text" id="lokalizacja" name="lokalizacja" autocomplete="off"
                   value="<?php echo htmlspecialchars($row['lokalizacja']); ?>" required />
        </div>

        <div class="form-group">
            <label for="rodzaj">Rodzaj:</label>
            <input list="rodzaj-list" id="rodzaj" name="rodzaj" autocomplete="off"
                   value="<?php echo htmlspecialchars($row['rodzaj']); ?>" />
            <datalist id="rodzaj-list">
                <option value="ziemny"></option>
                <option value="grobowiec"></option>
                <option value="pomnik"></option>
                <option value="kolumbarium"></option>
                <option value="inny"></option>
            </datalist>
        </div>

        <div class="form-group">
            <label>Opłata:</label><br />
            <input type="radio" id="oplata_tak" name="oplata" value="TAK" <?php if ($row['oplata'] === 'TAK') echo 'checked'; ?> required />
            <label for="oplata_tak">TAK</label>

            <input type="radio" id="oplata_nie" name="oplata" value="NIE" <?php if ($row['oplata'] === 'NIE') echo 'checked'; ?> required />
            <label for="oplata_nie">NIE</label>
        </div>

        <div class="form-group">
            <label for="notka">Notka:</label>
            <input type="text" id="notka" name="notka" autocomplete="off"
                   value="<?php echo htmlspecialchars($row['notka']); ?>" />
        </div>

        <button type="submit">Popraw</button>
    </form>
    </body>

    </html>
    <?php
} else {
    echo "Nie znaleziono grobu o podanym ID.";
}

$stmt->close();
$conn->close();
?>