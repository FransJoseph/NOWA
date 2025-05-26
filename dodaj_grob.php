<?php
include 'dbconfig.php';

$lokalizacja = $_POST['lokalizacja'];
$rodzaj = $_POST['rodzaj'];
$oplata = $_POST['oplata'];
$notka = $_POST['notka'];

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$zapytanie = "INSERT INTO `groby` (`id`, `lokalizacja`, `rodzaj`, `oplata`, `notka`) VALUES (NULL, '$lokalizacja', '$rodzaj', '$oplata', '$notka');";
$result = $conn->query($zapytanie);

$conn->close();
?>

<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatyczny powrót</title>
    <script>
        setTimeout(function () {
            window.history.back();
        }, 1000); // 1000 ms = 1 sekunda
    </script>
</head>

<body>
    <h1>Za chwilę nastąpi powrót...</h1>
</body>

</html>