<?php
session_start();

$login = isset($_POST['login']) ? trim($_POST['login']) : '';
$haslo = isset($_POST['haslo']) ? $_POST['haslo'] : '';

if ($login === '' || $haslo === '') {
    die("Proszę podać login i hasło.");
}

$haslo_hash = sha1($haslo);

include 'dbconfig.php';

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT id, login, haslo, status, imie, nazwisko FROM operatorzy WHERE login = ? AND haslo = ?");
$stmt->bind_param("ss", $login, $haslo_hash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($row['status'] == 0) {

        echo "Konto nie jest w pełni aktywne.<br>";
        $stmt->close();
        $conn->close();
        session_destroy();
        exit;
    }

    $_SESSION['login'] = $row['login'];
    $_SESSION['haslo'] = $row['haslo'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['status'] = $row['status'];
    $_SESSION['imie'] = $row['imie'];
    $_SESSION['nazwisko'] = $row['nazwisko'];

    echo "Witaj " . htmlspecialchars($_SESSION['imie']) . " " . htmlspecialchars($_SESSION['nazwisko']) . "<br>";
    echo "<a href='index.php'>Powrót do strony głównej</a><br>";
} else {
    echo "Nieprawidłowy login lub hasło.";
}

$stmt->close();
$conn->close();
?>