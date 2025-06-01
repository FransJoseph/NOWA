<?php
include 'dbconfig.php';
session_start();
?>

<?php if(isset($_SESSION['login'])){ ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="app.js"></script>


    <h3>Dodaj zmarłego do bazy</h3>

    <form action="dodaj_zmarlego.php" method="POST">

        <div class="form-group">
            <label for="imie">Imie</label>
            <input type="text" class="form-control" id="imie" name="imie" style="width: 750px;" placeholder="W przypadku braku pozostawić puste" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="nazwisko">Nazwisko</label>
            <input type="text" class="form-control" id="nazwisko" name="nazwisko" style="width: 750px;" placeholder="W przypadku braku pozostawić puste" required autocomplete="off">
        </div>

        <div class="date-toggle-container">

            <!-- Data urodzenia -->
            <div class="date-toggle-group">
                <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="toggleUrodzenie" checked>
                    <label class="form-check-label ml-2" for="toggleUrodzenie">Data urodzenia</label>
                </div>
                <div class="form-group mb-0" id="urodzenieContainer">
                    <input type="date" class="form-control" id="data_urodzenia" name="data_urodzenia" style="width: 150px;" autocomplete="off">
                </div>
            </div>

            <p>

            <!-- Data śmierci -->
            <div class="date-toggle-group">
                <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="toggleSmierc" checked>
                    <label class="form-check-label ml-2" for="toggleSmierc">Data śmierci</label>
                </div>
                <div class="form-group mb-0" id="smiercContainer">
                    <input type="date" class="form-control" id="data_smierci" name="data_smierci" style="width: 150px;" autocomplete="off">
                </div>
            </div>

        </div>

        <p>

        <div class="form-group">
            <label for="notka">Notka (niewymagana)</label>
            <textarea class="form-control" id="notka" name="notka" placeholder="Informacje o przeżytych latach przy braku dat, ekshumacje, lokalizaja jeżeli pochowany na innym cmentarzu, wyjaśnienia nieścisłości etc." rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Dodaj zmarłego</button>
        <button type="reset" class="btn btn-secondary">Resetuj</button>

    </form>

<?php } else {
    echo "<h3>Nie masz uprawnień do dodawania zmarłych</h3>";
} ?>

<p>

<h2>Zmarli</h2>

<table class="table table-hover table-sm">
    <thead>
    <tr>
        <th>#</th>
        <th>Imie</th>
        <th>Nazwisko</th>
        <th>Data urodzenia</th>
        <th>Data śmierci</th>
        <th>Notka</th>
        <th>Akcje</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $conn = new mysqli($server, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    $zapytanie = "SELECT * FROM zmarli";
    $result = $conn->query($zapytanie);

    if ($result->num_rows > 0) {
        $licznik = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $licznik++ . "</td><td>" . $row["imie"] . "</td><td>" . $row["nazwisko"] . "</td><td>" . $row["data_urodzenia"] . "</td><td>" . $row["data_smierci"] . "</td><td>" . $row["notka"] . "</td>";
            echo "<td>";
            if (isset($_SESSION['login'])) {
                echo "<a class='btn btn-warning btn-sm' style='margin-right: 4px;' href='editzmarli.php?id=" . $row["id"] . "' title='Edytuj'><i class='bi bi-pencil-square'></i></a>";
                echo "<a class='btn btn-danger btn-sm' href='delzmarli.php?id=" . $row["id"] . "' title='Usuń'><i class='bi bi-x-circle'></i></a>";
            }
            echo "</td></tr>\n";
        }
    } else {
        echo "<tr><td colspan='7'>Brak wyników</td></tr>";
    }

    $conn->close();
    ?>
    </tbody>

</table>
