<?php
include 'dbconfig.php';

$id_zmarly = $_POST['id_zmarly'];
$id_grob = $_POST['id_grob'];
$rodzaj_pochowku = $_POST['rodzaj_pochowku'];
$notka_pochowku = $_POST['notka_pochowku'];

// Obsługa checkboxa „brak daty”
if (isset($_POST['brak_daty']) && $_POST['brak_daty'] === 'on') {
    $data_pochowku = null;
} else {
    $data_pochowku = !empty($_POST['data_pochowku']) ? $_POST['data_pochowku'] : null;
}

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z BD: " . $conn->connect_error);
}

// Przygotowanie zapytania
$stmt = $conn->prepare("INSERT INTO pochowki (id_zmarly, id_grob, data_pochowku, rodzaj_pochowku, notka_pochowku) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Błąd przygotowania zapytania: " . $conn->error);
}

// Bindowanie parametrów (null zostanie poprawnie wstawione do bazy)
$stmt->bind_param("iisss", $id_zmarly, $id_grob, $data_pochowku, $rodzaj_pochowku, $notka_pochowku);

if (!$stmt->execute()) {
    echo "Błąd zapisu: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Automatyczny powrót</title>
    <script>
        setTimeout(function () {
            window.history.back();
        }, 250);
    </script>
</head>
<body>
<h1>Za chwilę nastąpi powrót...</h1>
</body>
</html>