<?php
include 'dbconfig.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Nieprawidłowy ID");
}

$id = (int)$_GET['id'];

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$zapytanie = "SELECT * FROM zmarli WHERE id = $id LIMIT 1";
$result = $conn->query($zapytanie);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Jeśli data to '0000-00-00', ustaw pusty string
    $data_urodzenia = ($row['data_urodzenia'] === '0000-00-00') ? '' : $row['data_urodzenia'];
    $data_smierci = ($row['data_smierci'] === '0000-00-00') ? '' : $row['data_smierci'];
    ?>

    <h2>Edycja zmarłego</h2>

    <form action="zapisz_editzmarlego.php" method="post">

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="form-group">
            <label for="imie">Imie:</label>
            <input type="text" class="form-control" id="imie" name="imie" value="<?php echo htmlspecialchars($row['imie']); ?>" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="nazwisko">Nazwisko:</label>
            <input type="text" class="form-control" id="nazwisko" name="nazwisko" value="<?php echo htmlspecialchars($row['nazwisko']); ?>" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="data_urodzenia">Data urodzenia:</label>
            <input type="date" class="form-control" id="data_urodzenia" name="data_urodzenia" value="<?php echo $data_urodzenia; ?>" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="data_smierci">Data śmierci:</label>
            <input type="date" class="form-control" id="data_smierci" name="data_smierci" value="<?php echo $data_smierci; ?>" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="notka">Notka:</label>
            <input type="text" class="form-control" id="notka" name="notka" value="<?php echo htmlspecialchars($row['notka']); ?>" autocomplete="off">
        </div>

        <p>
            <button type="submit" class="btn btn-primary">Popraw</button>
        </p>

    </form>

    <?php
} else {
    echo "Nie znaleziono rekordu o podanym ID.";
}

$conn->close();
?>