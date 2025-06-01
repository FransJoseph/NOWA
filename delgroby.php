<?php

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

include 'dbconfig.php';

@$id = intval($_GET['id']); // Tłumienie ewentualnego błędu

// Użycie operatora @ przy tworzeniu połączenia
@$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Przygotowane zapytanie zamiast bezpośredniego wstawiania ID (ochrona przed SQL Injection)
$stmt = $conn->prepare("DELETE FROM groby WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1; url=index.php">
    <title>Usuwanie</title>
</head>
<body>
<h1>Grób został usunięty. Proszę czekać...</h1>
</body>
</html>