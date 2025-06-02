<?php
include 'dbconfig.php';
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title>Groby</title>
    <link href="bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php if (isset($_SESSION['login'])) { ?>

    <h2>Dodaj grób do bazy</h2>

    <form action="dodaj_grob.php" method="post">

        <div class="form-group">
            <label for="lokalizacja">Lokalizacja <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="lokalizacja" name="lokalizacja" style="width: 750px;" placeholder="Podążaj za ustaloną notacją" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label for="rodzaj">Rodzaj</label>
            <input list="rodzaj" name="rodzaj" placeholder="Wybierz rodzaj grobu" style="max-width: 250px;" class="form-control">
            <datalist id="rodzaj">
                <option value="ziemny"></option>
                <option value="grobowiec"></option>
                <option value="pomnik"></option>
                <option value="kolumbarium"></option>
                <option value="inny"></option>
            </datalist>
        </div>

        <div class="form-group">
            <label>Opłata <span class="text-danger">*</span></label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="oplata" value="TAK" id="oplata_tak" required>
                <label class="form-check-label" for="oplata_tak">TAK</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="oplata" value="NIE" id="oplata_nie" required>
                <label class="form-check-label" for="oplata_nie">NIE</label>
            </div>
        </div>

        <div class="form-group">
            <label for="notka">Notka (niewymagana)</label>
            <textarea class="form-control" id="notka" name="notka" placeholder="Wyjaśnienia nieścisłości etc." rows="3"></textarea>
        </div>

        <p>
        <p>

        <button type="submit" class="btn btn-primary">Dodaj grób</button>
        <button type="reset" class="btn btn-secondary">Resetuj</button>

    </form>

<?php } else { ?>
<p>
<h3 class="alert alert-warning">Nie masz uprawnień do dodawania grobów</h3>
<p>
<?php } ?>

<p>

<h2>Groby</h2>

<table class="table table-hover table-sm table-striped bg-white">
    <thead>
    <tr>
        <th>#</th>
        <th>Lokalizacja</th>
        <th>Rodzaj</th>
        <th>Opłata</th>
        <th>Notka</th>
        <th class="text-end pe-4">Akcje</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $conn = new mysqli($server, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    $zapytanie = "SELECT * FROM groby ORDER BY lokalizacja ASC";
    $result = $conn->query($zapytanie);

    if ($result && $result->num_rows > 0) {
        $licznik = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $licznik++ . "</td>";
            echo "<td>" . htmlspecialchars($row["lokalizacja"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["rodzaj"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["oplata"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["notka"]) . "</td>";
            echo "<td class='text-end pe-6'>";
            if (isset($_SESSION['login'])) {
                echo "<a class='btn btn-warning btn-sm me-1' style='margin-right: 4px;' href='editgroby.php?id=" . urlencode($row["id"]) . "' title='Edytuj'> <i class='bi bi-pencil-square'></i> </a>";
                echo "<a class='btn btn-danger btn-sm' href='delgroby.php?id=" . urlencode($row["id"]) . "' title='Usuń' onclick=\"return confirm('Czy na pewno chcesz usunąć ten grób?');\"> <i class='bi bi-x-circle'></i> </a>";
            }
            echo "</td>";
            echo "</tr>\n";
        }
    } else {
        echo "<tr><td colspan='6'>Brak wyników</td></tr>";
    }

    $conn->close();
    ?>
    </tbody>
</table>

</body>
</html>