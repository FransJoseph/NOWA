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

// Użycie prepared statement dla bezpieczeństwa
$stmt = $conn->prepare("SELECT * FROM zmarli WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Zamiana '0000-00-00' na pusty string dla pól dat
    $data_urodzenia = ($row['data_urodzenia'] === '0000-00-00' || $row['data_urodzenia'] === null) ? '' : $row['data_urodzenia'];
    $data_smierci = ($row['data_smierci'] === '0000-00-00' || $row['data_smierci'] === null) ? '' : $row['data_smierci'];
    ?>

    <!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="UTF-8" />
        <title>Edycja zmarłego</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="path_to_bootstrap.css"> <!-- jeśli używasz bootstrap -->
    </head>
    <body>
    <h2>Edycja zmarłego</h2>

    <form action="zapisz_editzmarlego.php" method="post" autocomplete="off">

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

        <div class="form-group">
            <label for="imie">Imię:</label>
            <input type="text" class="form-control" id="imie" name="imie"
                   value="<?php echo htmlspecialchars($row['imie']); ?>" required>
        </div>

        <div class="form-group">
            <label for="nazwisko">Nazwisko:</label>
            <input type="text" class="form-control" id="nazwisko" name="nazwisko"
                   value="<?php echo htmlspecialchars($row['nazwisko']); ?>" required>
        </div>

        <div class="form-group">
            <label for="data_urodzenia">Data urodzenia:</label>
            <input type="date" class="form-control" id="data_urodzenia" name="data_urodzenia" value="<?php echo htmlspecialchars($data_urodzenia); ?>">
        </div>

        <div class="form-group">
            <label for="data_smierci">Data śmierci:</label>
            <input type="date" class="form-control" id="data_smierci" name="data_smierci" value="<?php echo htmlspecialchars($data_smierci); ?>">
        </div>

        <div class="form-group">
            <label for="notka">Notka:</label>
            <input type="text" class="form-control" id="notka" name="notka" value="<?php echo htmlspecialchars($row['notka']); ?>">
        </div>

        <p>
            <button type="submit" class="btn btn-primary">Popraw</button>
        </p>

    </form>
    </body>
    </html>

    <?php
} else {
    echo "Nie znaleziono rekordu o podanym ID.";
}

$stmt->close();
$conn->close();
?>