<?php
include 'dbconfig.php';

$search = $_GET['q'] ?? '';

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$searchEscaped = "%" . mb_strtolower($search, 'UTF-8') . "%";

$sql = "
    SELECT 
        pochowki.id AS pochowek_id,
        zmarli.imie,
        zmarli.nazwisko,
        zmarli.data_urodzenia,
        zmarli.data_smierci,
        zmarli.notka AS notka_zmarlego,
        groby.lokalizacja,
        groby.rodzaj,
        groby.oplata,
        groby.notka AS notka_grobu,
        pochowki.data_pochowku,
        pochowki.rodzaj_pochowku,
        pochowki.notka_pochowku
    FROM pochowki
    JOIN zmarli ON pochowki.id_zmarly = zmarli.id
    JOIN groby ON pochowki.id_grob = groby.id
    WHERE
        LOWER(zmarli.imie) LIKE ? OR
        LOWER(zmarli.nazwisko) LIKE ? OR
        LOWER(zmarli.notka) LIKE ? OR
        DATE_FORMAT(zmarli.data_urodzenia, '%Y-%m-%d') LIKE ? OR
        DATE_FORMAT(zmarli.data_smierci, '%Y-%m-%d') LIKE ? OR
        LOWER(groby.lokalizacja) LIKE ? OR
        LOWER(groby.rodzaj) LIKE ? OR
        CAST(groby.oplata AS CHAR) LIKE ? OR
        LOWER(groby.notka) LIKE ? OR
        LOWER(pochowki.rodzaj_pochowku) LIKE ? OR
        DATE_FORMAT(pochowki.data_pochowku, '%Y-%m-%d') LIKE ? OR
        LOWER(pochowki.notka_pochowku) LIKE ?
    ORDER BY pochowki.id DESC
";

$stmt = $conn->prepare($sql);
$params = array_fill(0, 12, $searchEscaped);
$stmt->bind_param(str_repeat('s', 12), ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Wyszukiwanie</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body class="p-4">

<link rel="stylesheet" href="style.css">

<h2>Szukaj</h2>

<form method="GET" action="szukaj.php" class="mb-3">
    <input type="text" name="q" class="form-control mb-2" placeholder="Wpisz imię, nazwisko, lokalizację, datę, notkę itd." value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Szukaj</button>
        <a href="index.php" class="btn btn-secondary">Powrót</a>
    </div>
</form>

<?php
if ($result->num_rows > 0) {
    echo "<table class='table table-striped'>";
    echo "<thead><tr>
            <th>#</th><th>Imię</th><th>Nazwisko</th><th>Data ur.</th><th>Data śm.</th><th>Notka zmarłego</th>
            <th>Lokalizacja</th><th>Rodzaj grobu</th><th>Opłata</th><th>Notka grobu</th>
            <th>Data pochówku</th><th>Rodzaj poch.</th><th>Notka pochówku</th>
          </tr></thead><tbody>";

    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . $i++ . "</td>
            <td>" . htmlspecialchars($row['imie'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['nazwisko'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['data_urodzenia'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['data_smierci'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['notka_zmarlego'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['lokalizacja'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['rodzaj'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['oplata'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['notka_grobu'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['data_pochowku'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['rodzaj_pochowku'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['notka_pochowku'], ENT_QUOTES, 'UTF-8') . "</td>
        </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p>Brak wyników dla podanego zapytania.</p>";
}

$stmt->close();
$conn->close();
?>

</body>
</html>