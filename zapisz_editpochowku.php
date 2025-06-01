<?php
include 'dbconfig.php';

$id = $_POST['id'];
$id_zmarly = $_POST['id_zmarly'];
$id_grob = $_POST['id_grob'];
$rodzaj_pochowku = $_POST['rodzaj_pochowku'];
$notka_pochowku = $_POST['notka_pochowku'];

$data_pochowku = isset($_POST['brak_daty']) ? null : $_POST['data_pochowku'];

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z BD: " . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE pochowki SET id_zmarly=?, id_grob=?, data_pochowku=?, rodzaj_pochowku=?, notka_pochowku=? WHERE id=?");
$stmt->bind_param("iisssi", $id_zmarly, $id_grob, $data_pochowku, $rodzaj_pochowku, $notka_pochowku, $id);

if (!$stmt->execute()) {
    echo "Błąd zapisu: " . $stmt->error;
}

$stmt->close();
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

</html>
