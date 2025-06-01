<?php
include 'dbconfig.php';
session_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$zapytanie = "SELECT * FROM pochowki WHERE id = $id LIMIT 1;";
$result = $conn->query($zapytanie);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>

    <h2>Edycja pochówku</h2>

    <form method="POST" id="powiaz-form" action="zapisz_editpochowku.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="form-group">
            <label for="id_zmarly">Zmarły:</label>
            <select name="id_zmarly" class="form-control" required>
                <?php
                $zmarli = $conn->query("SELECT id, imie, nazwisko FROM zmarli");
                while ($z = $zmarli->fetch_assoc()) {
                    $selected = ($z['id'] == $row['id_zmarly']) ? "selected" : "";
                    echo "<option value='{$z['id']}' $selected>" . htmlspecialchars($z['imie'] . ' ' . $z['nazwisko']) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_grob">Grób:</label>
            <select name="id_grob" class="form-control" required>
                <?php
                $groby = $conn->query("SELECT id, lokalizacja FROM groby");
                while ($g = $groby->fetch_assoc()) {
                    $selected = ($g['id'] == $row['id_grob']) ? "selected" : "";
                    echo "<option value='{$g['id']}' $selected>" . htmlspecialchars($g['lokalizacja']) . "</option>";
                }
                ?>
            </select>
        </div>

        <?php
        $isNullDate = is_null($row['data_pochowku']);
        $dataValue = $isNullDate ? '' : $row['data_pochowku'];
        $checkedAttr = $isNullDate ? 'checked' : '';
        ?>

        <div class="form-group">
            <label for="data_pochowku">Data pochówku:</label>
            <input type="date" class="form-control" id="data_pochowku" name="data_pochowku"
                   value="<?php echo htmlspecialchars($dataValue); ?>" style="width: 150px;">
            <br>
            <input type="checkbox" name="brak_daty" id="brak_daty" <?php echo $checkedAttr; ?>>
            <label for="brak_daty">Nieznana data pochówku</label>
        </div>

        <div class="form-group">
            <label for="rodzaj_pochowku">Rodzaj pochówku:</label>
            <input list="rodzaje" name="rodzaj_pochowku" class="form-control" value="<?php echo htmlspecialchars($row['rodzaj_pochowku']); ?>" required>
            <datalist id="rodzaje">
                <option value="trumna">
                <option value="urna">
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

    <?php
} else {
    echo "Nie znaleziono pochówku o podanym ID.";
}
$conn->close();
?>