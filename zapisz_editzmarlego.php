<?php
include 'dbconfig.php';

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Nieprawidłowy ID");
}

$id = (int)$_POST['id'];
$imie = $_POST['imie'] ?? '';
$nazwisko = $_POST['nazwisko'] ?? '';
$data_urodzenia = $_POST['data_urodzenia'] ?: null; // null jeśli puste
$data_smierci = $_POST['data_smierci'] ?: null;
$notka = $_POST['notka'] ?? '';

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Przygotowane zapytanie z obsługą NULL dla dat
$sql = "UPDATE zmarli SET 
    imie = ?, 
    nazwisko = ?, 
    data_urodzenia = ?, 
    data_smierci = ?, 
    notka = ? 
    WHERE id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Błąd przygotowania zapytania: " . $conn->error);
}

$stmt->bind_param(
    "sssssi",
    $imie,
    $nazwisko,
    $data_urodzenia,
    $data_smierci,
    $notka,
    $id
);

// Jeśli data jest pusta, to ustaw na NULL:
if ($data_urodzenia === '') $data_urodzenia = null;
if ($data_smierci === '') $data_smierci = null;

if (!$stmt->execute()) {
    die("Błąd aktualizacji: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Automatyczny powrót</title>
    <script>
        setTimeout(function () {
            window.history.go(-2);
        }, 500);
    </script>
</head>

<body>
<h1>Zapisywanie...</h1>
</body>

</html>