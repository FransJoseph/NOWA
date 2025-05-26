<?php
include 'dbconfig.php';

$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$data_urodzenia = $_POST['data_urodzenia'];
$data_smierci = $_POST['data_smierci'];
$notka = $_POST['notka'];


$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z BD: " . $conn->connect_error);
}

$zapytanie = "INSERT INTO `zmarli` (`id`, `imie`, `nazwisko`, `data_urodzenia`, `data_smierci`, `notka`) VALUES (NULL, '$imie', '$nazwisko', '$data_urodzenia', '$data_smierci', '$notka');";


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
        }, 250); // 1000 ms = 1 sekunda
    </script>
</head>

<body>
    <h1>Za chwilę nastąpi powrót...</h1>
</body>

</html>