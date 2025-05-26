<?php
include 'dbconfig.php';

$id = $_POST['id'];
$lokalizacja = $_POST['lokalizacja'];
$rodzaj = $_POST['rodzaj'];
$oplata = $_POST['oplata'];
$notka = $_POST['notka'];

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$zapytanie = "UPDATE `groby` SET `lokalizacja` = '$lokalizacja', `rodzaj` = '$rodzaj', `oplata` = '$oplata', `notka` = '$notka' WHERE `groby`.`id` = $id;";


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
            window.history.go(-2);
        }, 250); // 1000 ms = 1 sekunda
    </script>

</head>

<body>
<h1>Zapisywanie...</h1>
</body>

</html>
