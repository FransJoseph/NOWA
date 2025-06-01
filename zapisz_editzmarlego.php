<?php
include 'dbconfig.php';

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Nieprawidłowy ID");
}

$id = (int)$_POST['id'];
$imie = $_POST['imie'] ?? '';
$nazwisko = $_POST['nazwisko'] ?? '';
$data_urodzenia = $_POST['data_urodzenia'] ?? '';
$data_smierci = $_POST['data_smierci'] ?? '';
$notka = $_POST['notka'] ?? '';

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Zabezpieczenie tekstów przed SQL Injection
$imie = $conn->real_escape_string($imie);
$nazwisko = $conn->real_escape_string($nazwisko);
$notka = $conn->real_escape_string($notka);

function sqlDateOrNull($date) {
    // Zwraca 'NULL' lub 'YYYY-MM-DD' w apostrofach
    if ($date === '' || $date === null) {
        return "NULL";
    }
    return "'" . $date . "'";
}

$data_urodzenia_sql = sqlDateOrNull($data_urodzenia);
$data_smierci_sql = sqlDateOrNull($data_smierci);

$sql = "UPDATE zmarli SET 
    imie = '$imie', 
    nazwisko = '$nazwisko', 
    data_urodzenia = $data_urodzenia_sql, 
    data_smierci = $data_smierci_sql, 
    notka = '$notka' 
    WHERE id = $id";

if (!$conn->query($sql)) {
    die("Błąd aktualizacji: " . $conn->error);
}

$conn->close();
?>

<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatyczny powrót</title>
    <script>
        setTimeout(function () {
            window.history.go(-2);
        }, 250);
    </script>
</head>

<body>
<h1>Zapisywanie...</h1>
</body>

</html>