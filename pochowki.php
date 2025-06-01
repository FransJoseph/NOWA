<?php
include 'dbconfig.php';
session_start();
?>

<?php if(isset($_SESSION['login'])){ ?>

    <h2>Dodaj nowy pochówek</h2>

    <form action="dodaj_pochowek.php" method="POST">

        <p>Zmarły:</p>
        <select name="id_zmarly" class="form-control" required>
            <?php
            $conn = new mysqli($server, $user, $password, $dbname);
            if ($conn->connect_error) die("Błąd połączenia z bazą danych: " . $conn->connect_error);

            $zapytanie = "SELECT id, imie, nazwisko, data_urodzenia, data_smierci, notka FROM zmarli";
            $result = $conn->query($zapytanie);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['id']."'>[".$row['imie']."] [".$row['nazwisko']."] [".$row['data_urodzenia']."] [".$row['data_smierci']."] [".$row['notka']."]</option>\n";
            }

            $conn->close();
            ?>
        </select><br>

        <p>Grób:</p>
        <select name="id_grob" class="form-control" required>
            <?php
            $conn = new mysqli($server, $user, $password, $dbname);
            if ($conn->connect_error) die("Błąd połączenia z bazą danych: " . $conn->connect_error);

            $zapytanie = "SELECT id, lokalizacja, rodzaj, oplata, notka FROM groby";
            $result = $conn->query($zapytanie);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['id']."'>[".$row['lokalizacja']."] [".$row['rodzaj']."] [".$row['oplata']."] [".$row['notka']."]</option>\n";
            }

            $conn->close();
            ?>
        </select><br>

        <p>Data pochówku:</p>
        <input type="date" class="form-control" id="data_pochowku" name="data_pochowku" style="width: 150px;">
        <br>
        <input type="checkbox" name="brak_daty" id="brak_daty" onchange="toggleDateInput()">
        <label for="brak_daty">Nieznana data pochówku</label>

        <script>
            function toggleDateInput() {
                const checkbox = document.getElementById('brak_daty');
                const dateInput = document.getElementById('data_pochowku');
                dateInput.disabled = checkbox.checked;
                if (checkbox.checked) {
                    dateInput.value = "";
                }
            }
        </script>


        <p>Rodzaj pochówku:</p>
        <input list="rodzaj_pochowku" name="rodzaj_pochowku" class="form-control" style="width: 150px;" placeholder="Wybierz z listy" required>
        <datalist id="rodzaj_pochowku">
            <option value="trumna">
            <option value="urna">
        </datalist><br>

        <p>Notka (opcjonalna):</p>
        <textarea class="form-control" id="notka_pochowku" name="notka_pochowku" placeholder="Informacja czy to ekshumacja, wyjaśnienia nieścisłości etc." rows="3"></textarea><br>

        <button type="submit" class="btn btn-primary">Powiąż</button>
    </form>

<?php } else {
    echo "<h4>Nie masz uprawnień do dodawania pochówków</h4>";
} ?>

<p>

<h4>Baza:</h4>

<table class="table table-hover table-sm">
    <thead class="align-middle">
    <tr>
        <th>#</th>
        <th title="Id Zmarłego">Id Z.</th>
        <th title="Id grobu">Id g.</th>
        <th>Imie</th>
        <th>Nazwisko</th>
        <th title="Data urodzenia">Data ur.</th>
        <th title="Data śmierci">Data śm.</th>
        <th>Notka zmarłego</th>
        <th>Lokalizacja</th>
        <th>Rodzaj grobu</th>
        <th>Opłata</th>
        <th>Notka grobu</th>
        <th title="Data pochówku">Data p.</th>
        <th title="Data pochówku">Rodzaj p.</th>
        <th>Notka pochówku</th>
        <th>Akcje</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $conn = new mysqli($server, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    $zapytanie = "SELECT 
            pochowki.id AS pochowek_id,
            zmarli.id AS zmarly_id,
            groby.id AS grob_id,
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
        ORDER BY pochowki.id ASC";

    $result = $conn->query($zapytanie);

    if ($result->num_rows > 0) {
        $licznik = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $licznik++ . "</td><td>" . $row["zmarly_id"] . "</td><td>" . $row["grob_id"] . "</td><td>" . $row["imie"] . "</td><td>" . $row["nazwisko"] . "</td><td>" . $row["data_urodzenia"] . "</td><td>" . $row["data_smierci"] . "</td><td>" . $row["notka_zmarlego"] . "</td><td>" . $row["lokalizacja"] . "</td><td>" . $row["rodzaj"] . "</td><td>" . $row["oplata"] . "</td><td>" . $row["notka_grobu"] . "</td><td>" . $row["data_pochowku"] . "</td><td>" . $row["rodzaj_pochowku"] . "</td><td>" . $row["notka_pochowku"] . "</td>";
            echo "<td>";
            if (isset($_SESSION['login'])) {
                echo "<a class='btn btn-warning btn-sm' style='margin-right: 4px;' href='editpochowki.php?id=" . $row["pochowek_id"] . "' title='Edytuj'><i class='bi bi-pencil-square'></i></a>";
                echo "<a class='btn btn-danger btn-sm' href='delpochowki.php?id=" . $row["pochowek_id"] . "' title='Usuń'><i class='bi bi-x-circle'></i></a>";
            }
            echo "</td></tr>\n";
        }
    } else {
        echo "<tr><td colspan='15'>Baza jest pusta</td></tr>";
    }

    $conn->close();
    ?>
    </tbody>
</table>
