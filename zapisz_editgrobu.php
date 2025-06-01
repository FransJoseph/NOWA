<?php
include 'dbconfig.php';

$id = $_POST['id'] ?? null;
$lokalizacja = $_POST['lokalizacja'] ?? '';
$rodzaj = $_POST['rodzaj'] ?? '';
$oplata = $_POST['oplata'] ?? '';
$notka = $_POST['notka'] ?? '';

if (!$id || !is_numeric($id)) {
    die("Niepoprawne ID grobu.");
}

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE `groby` SET `lokalizacja` = ?, `rodzaj` = ?, `oplata` = ?, `notka` = ? WHERE `id` = ?");
$stmt->bind_param("ssssi", $lokalizacja, $rodzaj, $oplata, $notka, $id);

if ($stmt->execute()) {
    $message = "Aktualizacja powiodła się.";
} else {
    $message = "Błąd podczas aktualizacji: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Aktualizacja grobu</title>
    <script>
        setTimeout(function () {
            window.location.href = 'index.php';
        }, 1500);
    </script>
</head>

<body>
<h1><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></h1>
<p>Za chwilę nastąpi przekierowanie...</p>
<p><a href="groby.php">Kliknij tutaj, jeśli przekierowanie nie zadziała.</a></p>
</body>

</html>