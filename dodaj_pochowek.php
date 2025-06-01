<?php
// Sprawdzenie czy formularz przesłano metodą POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /");
    exit;
}

include 'dbconfig.php';

// Pobieranie i filtrowanie danych
@$id_zmarly = intval($_POST['id_zmarly'] ?? 0);
@$id_grob = intval($_POST['id_grob'] ?? 0);
@$rodzaj_pochowku = htmlspecialchars(trim($_POST['rodzaj_pochowku'] ?? ''));
@$notka_pochowku = htmlspecialchars(trim($_POST['notka_pochowku'] ?? ''));

// Walidacja wymaganych pól
if ($id_zmarly <= 0 || $id_grob <= 0 || empty($rodzaj_pochowku)) {
    die("Błąd: brak wymaganych danych.");
}

// Obsługa checkboxa brak daty
if (isset($_POST['brak_daty']) && $_POST['brak_daty'] === 'on') {
    $data_pochowku = null;
} else {
    $data_pochowku = !empty($_POST['data_pochowku']) ? $_POST['data_pochowku'] : null;
}

@$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Przygotowanie zapytania
$stmt = $conn->prepare("INSERT INTO pochowki (id_zmarly, id_grob, data_pochowku, rodzaj_pochowku, notka_pochowku) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Błąd przygotowania zapytania: " . $conn->error);
}

if ($data_pochowku === null) {

    $data_pochowku_param = null;
    $stmt->bind_param("iisss", $id_zmarly, $id_grob, $data_pochowku_param, $rodzaj_pochowku, $notka_pochowku);

} else {
    $stmt->bind_param("iisss", $id_zmarly, $id_grob, $data_pochowku, $rodzaj_pochowku, $notka_pochowku);
}

if (!$stmt->execute()) {
    echo "Błąd zapisu: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
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