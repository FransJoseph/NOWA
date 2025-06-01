<?php
session_start();

if (!isset($_SESSION['login'])) {
    die("Brak uprawnień");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /");
    exit;
}

include 'dbconfig.php';

@$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Pobieranie i filtrowanie danych
@$imie = trim($_POST['imie'] ?? '');
@$nazwisko = trim($_POST['nazwisko'] ?? '');
@$notka = trim($_POST['notka'] ?? '');

if (empty($imie) || empty($nazwisko)) {
    die("Błąd: imię i nazwisko są wymagane.");
}

// Data urodzenia i śmierci - mogą być NULL
$data_urodzenia = !empty($_POST['data_urodzenia']) ? $_POST['data_urodzenia'] : null;
$data_smierci = !empty($_POST['data_smierci']) ? $_POST['data_smierci'] : null;

// Przygotowanie zapytania z 5 parametrami (s - string, ? dla NULLs)
$stmt = $conn->prepare("INSERT INTO zmarli (imie, nazwisko, data_urodzenia, data_smierci, notka) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Błąd przygotowania zapytania: " . $conn->error);
}

$stmt->bind_param(
    "sssss",
    $imie,
    $nazwisko,
    $data_urodzenia,
    $data_smierci,
    $notka
);

if ($stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    echo "Błąd: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>