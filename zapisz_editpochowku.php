<?php
include 'dbconfig.php';

$id = $_POST['id'] ?? null;
$id_zmarly = $_POST['id_zmarly'] ?? null;
$id_grob = $_POST['id_grob'] ?? null;
$rodzaj_pochowku = $_POST['rodzaj_pochowku'] ?? '';
$notka_pochowku = $_POST['notka_pochowku'] ?? '';

$data_pochowku = isset($_POST['brak_daty']) ? null : ($_POST['data_pochowku'] ?? null);

// Podstawowa walidacja
if (!$id || !$id_zmarly || !$id_grob) {
    die("Niepoprawne dane wejściowe.");
}

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z BD: " . $conn->connect_error);
}

// Budujemy zapytanie w zależności czy data_pochowku jest null
if ($data_pochowku === null) {
    $sql = "UPDATE pochowki SET id_zmarly=?, id_grob=?, data_pochowku=NULL, rodzaj_pochowku=?, notka_pochowku=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $id_zmarly, $id_grob, $rodzaj_pochowku, $notka_pochowku, $id);
} else {
    $sql = "UPDATE pochowki SET id_zmarly=?, id_grob=?, data_pochowku=?, rodzaj_pochowku=?, notka_pochowku=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssi", $id_zmarly, $id_grob, $data_pochowku, $rodzaj_pochowku, $notka_pochowku, $id);
}

if (!$stmt->execute()) {
    echo "Błąd zapisu: " . $stmt->error;
} else {
    echo "Zapisano poprawnie.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Aktualizacja pochówku</title>
    <script>
        setTimeout(function () {
            window.history.go(-2);
        }, 1500);
    </script>
</head>

<body>
<p>Za chwilę nastąpi powrót...</p>
<p><a href="pochowki.php">Jeśli nic się nie dzieje, kliknij tutaj.</a></p>
</body>

</html>