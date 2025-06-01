<?php
@include 'dbconfig.php'; // @ do tłumienia błędów
session_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("Nieprawidłowe ID pochówku.");
}

@$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM pochowki WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Nie znaleziono pochówku o podanym ID.");
}

$row = $result->fetch_assoc();

// Pobieramy zmarłych i groby w osobnych zapytaniach
$zmarliRes = $conn->query("SELECT id, imie, nazwisko FROM zmarli ORDER BY nazwisko, imie");
$grobyRes = $conn->query("SELECT id, lokalizacja FROM groby ORDER BY lokalizacja");

// Przygotowujemy dane do dropdownów
$zmarli = [];
while ($z = $zmarliRes->fetch_assoc()) {
    $zmarli[] = $z;
}
$groby = [];
while ($g = $grobyRes->fetch_assoc()) {
    $groby[] = $g;
}

// Data pochówku i checkbox „brak daty”
$isNullDate = is_null($row['data_pochowku']);
$dataValue = $isNullDate ? '' : $row['data_pochowku'];
$checkedAttr = $isNullDate ? 'checked' : '';

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edycja pochówku</title>
    <script>
        // Prosta walidacja JS
        function validateForm() {
            const idZmarly = document.forms['pochowekForm']['id_zmarly'].value;
            const idGrob = document.forms['pochowekForm']['id_grob'].value;

            if (!idZmarly) {
                alert('Proszę wybrać zmarłego.');
                return false;
            }
            if (!idGrob) {
                alert('Proszę wybrać grób.');
                return false;
            }
        }

        // Obsługa checkboxa „brak daty” - wyłącz pole daty, gdy zaznaczone
        function toggleDate() {
            const checkbox = document.getElementById('brak_daty');
            const dataField = document.getElementById('data_pochowku');
            dataField.disabled = checkbox.checked;
            if (checkbox.checked) {
                dataField.value = '';
            }
        }
        window.onload = function() {
            toggleDate();
            document.getElementById('brak_daty').addEventListener('change', toggleDate);
        }
    </script>
</head>
<body>
<h2>Edycja pochówku</h2>

<form method="POST" name="pochowekForm" id="powiaz-form" action="zapisz_editpochowku.php" onsubmit="return validateForm()">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

    <div class="form-group">
        <label for="id_zmarly">Zmarły:</label>
        <select name="id_zmarly" class="form-control" required>
            <option value="">-- Wybierz zmarłego --</option>
            <?php foreach ($zmarli as $z): ?>
                <option value="<?php echo $z['id']; ?>" <?php echo ($z['id'] == $row['id_zmarly']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($z['imie'] . ' ' . $z['nazwisko']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_grob">Grób:</label>
        <select name="id_grob" class="form-control" required>
            <option value="">-- Wybierz grób --</option>
            <?php foreach ($groby as $g): ?>
                <option value="<?php echo $g['id']; ?>" <?php echo ($g['id'] == $row['id_grob']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($g['lokalizacja']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="data_pochowku">Data pochówku:</label>
        <input type="date" class="form-control" id="data_pochowku" name="data_pochowku" value="<?php echo htmlspecialchars($dataValue); ?>" style="width: 150px;">
        <br>
        <input type="checkbox" name="brak_daty" id="brak_daty" <?php echo $checkedAttr; ?>>
        <label for="brak_daty">Nieznana data pochówku</label>
    </div>

    <div class="form-group">
        <label for="rodzaj_pochowku">Rodzaj pochówku:</label>
        <input list="rodzaje" name="rodzaj_pochowku" class="form-control" value="<?php echo htmlspecialchars($row['rodzaj_pochowku']); ?>">
        <datalist id="rodzaje">
            <option value="trumna"></option>
            <option value="urna"></option>
        </datalist>
    </div>

    <div class="form-group">
        <label for="notka_pochowku">Notka:</label>
        <input type="text" name="notka_pochowku" class="form-control" value="<?php echo htmlspecialchars($row['notka_pochowku']); ?>">
    </div>

    <p>
        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
    </p>
</form>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>