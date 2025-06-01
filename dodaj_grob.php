<?php
// Zabezpieczenie: sprawdzenie czy formularz został przesłany metodą POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /"); // lub inna strona główna
    exit;
}

include 'dbconfig.php';

// Bezpieczne pobieranie danych POST z użyciem operatora @ i filtrowania
@$lokalizacja = htmlspecialchars(trim($_POST['lokalizacja'] ?? ''));
@$rodzaj = htmlspecialchars(trim($_POST['rodzaj'] ?? ''));
@$oplata = htmlspecialchars(trim($_POST['oplata'] ?? ''));
@$notka = htmlspecialchars(trim($_POST['notka'] ?? ''));

// Walidacja danych (czy nie są puste)
if (empty($lokalizacja) || empty($rodzaj) || empty($oplata)) {
    die("Błąd: Wymagane pola są puste.");
}

// Użycie operatora @ do tłumienia błędów przy połączeniu
@$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Przygotowanie i wykonanie zapytania
$stmt = $conn->prepare("INSERT INTO `groby` (`lokalizacja`, `rodzaj`, `oplata`, `notka`) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $lokalizacja, $rodzaj, $oplata, $notka);
$stmt->execute();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatyczny powrót</title>
    <script>
        setTimeout(function () {
            window.history.back();
        }, 1000); // 1 sekunda
    </script>
</head>

<body>
<h1>Dodano grób. Za chwilę nastąpi powrót...</h1>
</body>

</html>