<?php
include 'dbconfig.php';
session_start();

if (!isset($_SESSION['login'])) {
    die("Brak uprawnień");
}

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Pobranie danych z formularza i walidacja
$imie = $conn->real_escape_string(trim($_POST['imie'] ?? ''));
$nazwisko = $conn->real_escape_string(trim($_POST['nazwisko'] ?? ''));

// Daty - jeśli puste, ustaw NULL
$data_urodzenia = !empty($_POST['data_urodzenia']) ? $conn->real_escape_string($_POST['data_urodzenia']) : null;
$data_smierci = !empty($_POST['data_smierci']) ? $conn->real_escape_string($_POST['data_smierci']) : null;

$notka = $conn->real_escape_string(trim($_POST['notka'] ?? ''));

// Budowa zapytania z NULL dla pustych dat
$sql = "INSERT INTO zmarli (imie, nazwisko, data_urodzenia, data_smierci, notka) VALUES (
    '" . $imie . "',
    '" . $nazwisko . "',
    " . ($data_urodzenia !== null ? "'$data_urodzenia'" : "NULL") . ",
    " . ($data_smierci !== null ? "'$data_smierci'" : "NULL") . ",
    '" . $notka . "'
)";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php"); // lub inna strona po dodaniu
    exit();
} else {
    echo "Błąd: " . $conn->error;
}

$conn->close();
?>
