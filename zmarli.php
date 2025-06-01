<?php
include 'dbconfig.php';
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Zmarli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="app.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="p-4">

<?php if (isset($_SESSION['login'])): ?>

    <h3>Dodaj zmarłego do bazy</h3>

    <form action="dodaj_zmarlego.php" method="POST" class="mb-5">

        <div class="mb-3">
            <label for="imie" class="form-label">Imię</label>
            <input type="text" class="form-control" id="imie" name="imie" style="max-width: 750px;" placeholder="W przypadku braku pozostawić puste" autocomplete="off">
        </div>

        <div class="mb-3">
            <label for="nazwisko" class="form-label">Nazwisko <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nazwisko" name="nazwisko" style="max-width: 750px;" placeholder="W przypadku braku pozostawić puste" required autocomplete="off">
        </div>

        <div class="date-toggle-container d-flex gap-5 mb-3">

            <div class="date-toggle-group">
                <div class="form-check form-switch d-flex align-items-center mb-1">
                    <input class="form-check-input" type="checkbox" id="toggleUrodzenie" checked>
                    <label class="form-check-label ms-2" for="toggleUrodzenie">Data urodzenia</label>
                </div>
                <input type="date" class="form-control" id="data_urodzenia" name="data_urodzenia" style="max-width: 150px;" autocomplete="off">
            </div>

            <div class="date-toggle-group">
                <div class="form-check form-switch d-flex align-items-center mb-1">
                    <input class="form-check-input" type="checkbox" id="toggleSmierc" checked>
                    <label class="form-check-label ms-2" for="toggleSmierc">Data śmierci</label>
                </div>
                <input type="date" class="form-control" id="data_smierci" name="data_smierci" style="max-width: 150px;" autocomplete="off">
            </div>

        </div>

        <div class="mb-3">
            <label for="notka" class="form-label">Notka (niewymagana)</label>
            <textarea class="form-control" id="notka" name="notka" rows="3" placeholder="Informacje o przeżytych latach przy braku dat, ekshumacje, lokalizacja, wyjaśnienia nieścisłości itp."></textarea>
        </div>

        <button type="submit" class="btn btn-primary me-2">Dodaj zmarłego</button>
        <button type="reset" class="btn btn-secondary">Resetuj</button>

    </form>

<?php else: ?>
<p>
<h3 class="alert alert-warning">Nie masz uprawnień do dodawania zmarłych</h3>
<p>
<?php endif; ?>

<h2>Zmarli</h2>

<table class="table table-hover table-sm table-striped">

    <thead class="table-light">
    <tr>
        <th>#</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Data urodzenia</th>
        <th>Data śmierci</th>
        <th>Notka</th>
        <th class="text-right pr-4">Akcje</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $conn = new mysqli($server, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM zmarli ORDER BY nazwisko, imie";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0):
        $licznik = 1;
        while ($row = $result->fetch_assoc()):
            // Bezpieczne wyświetlanie danych
            $imie = htmlspecialchars($row['imie']);
            $nazwisko = htmlspecialchars($row['nazwisko']);
            $data_urodzenia = $row['data_urodzenia'] ?: '-';
            $data_smierci = $row['data_smierci'] ?: '-';
            $notka = nl2br(htmlspecialchars($row['notka']));
            ?>
            <tr>
                <td><?= $licznik++ ?></td>
                <td><?= $imie ?></td>
                <td><?= $nazwisko ?></td>
                <td><?= $data_urodzenia ?></td>
                <td><?= $data_smierci ?></td>
                <td><?= $notka ?></td>
                <td class='text-right'>
                    <?php if (isset($_SESSION['login'])): ?>
                        <a class="btn btn-warning btn-sm" style="margin-right: 4px;" href="editzmarli.php?id=<?= htmlspecialchars($row['id']) ?>" title="Edytuj"><i class="bi bi-pencil-square"></i></a><a class="btn btn-danger btn-sm" href="delzmarli.php?id=<?= htmlspecialchars($row['id']) ?>" title="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć tego zmarłego?');"><i class="bi bi-x-circle"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php
        endwhile;
    else:
        ?>
        <tr><td colspan="7">Brak wyników</td></tr>
    <?php
    endif;

    $conn->close();
    ?>
    </tbody>
</table>

<script>

    $('#toggleUrodzenie').on('change', function() {
        $('#data_urodzenia').prop('disabled', !this.checked);
    }).trigger('change');

    $('#toggleSmierc').on('change', function() {
        $('#data_smierci').prop('disabled', !this.checked);
    }).trigger('change');

</script>

</body>
</html>