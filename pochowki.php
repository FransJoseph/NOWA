<?php
include 'dbconfig.php';
session_start();

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) die("Błąd połączenia z bazą danych: " . $conn->connect_error);
?>

<?php if (isset($_SESSION['login'])) { ?>

    <h2>Dodaj nowy pochówek</h2>

    <form action="dodaj_pochowek.php" method="POST">

        <p>Zmarły: <span class="text-danger">*</span></p>
        <select name="id_zmarly" class="form-control" required>
            <?php
            $zap_zmarli = "SELECT id, imie, nazwisko, data_urodzenia, data_smierci, notka FROM zmarli";
            $result = $conn->query($zap_zmarli);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['id']) . "'>"
                    . htmlspecialchars($row['imie']) . ", "
                    . htmlspecialchars($row['nazwisko']) . ", ur. "
                    . htmlspecialchars($row['data_urodzenia']) . ", zm. "
                    . htmlspecialchars($row['data_smierci']) . ", "
                    . htmlspecialchars($row['notka'])
                    . "</option>\n";
            }
            ?>
        </select><br>

        <p>Grób: <span class="text-danger">*</span></p>
        <select name="id_grob" class="form-control" required>
            <?php
            $zap_groby = "SELECT id, lokalizacja, rodzaj, oplata, notka FROM groby";
            $result = $conn->query($zap_groby);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['id']) . "'>"
                    . htmlspecialchars($row['lokalizacja']) . ", "
                    . htmlspecialchars($row['rodzaj']) . ", opłata: "
                    . htmlspecialchars($row['oplata']) . ", "
                    . htmlspecialchars($row['notka'])
                    . "</option>\n";
            }
            ?>
        </select><br>

        <p>Data pochówku:</p>
        <input type="date" class="form-control" id="data_pochowku" name="data_pochowku" style="width: 150px;" required>
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
                    dateInput.removeAttribute('required');
                } else {
                    dateInput.setAttribute('required', 'required');
                }
            }
        </script>

        <p>Rodzaj pochówku:</p>
        <input list="rodzaj_pochowku" name="rodzaj_pochowku" class="form-control" style="width: 150px;" placeholder="Wybierz z listy">
        <datalist id="rodzaj_pochowku">
            <option value="trumna">
            <option value="urna">
        </datalist><br>

        <p>Notka (opcjonalna):</p>
        <textarea class="form-control" id="notka_pochowku" name="notka_pochowku" placeholder="Informacja czy to ekshumacja, wyjaśnienia nieścisłości etc." rows="3"></textarea><br>

        <button type="submit" class="btn btn-primary">Powiąż</button>
        <button type="reset" class="btn btn-secondary">Resetuj</button>

    </form>

<?php } else {
    echo "<h3>Nie masz uprawnień do dodawania pochówków</h3>";
} ?>

<p>

<h2>Baza</h2>

<table class="table table-hover table-sm">
    <thead class="align-middle">
    <tr>
        <th>#</th>
        <th title="Id Zmarłego">Id Z.</th>
        <th title="Id grobu">Id g.</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th title="Data urodzenia">Data ur.</th>
        <th title="Data śmierci">Data śm.</th>
        <th>Notka zmarłego</th>
        <th>Lokalizacja</th>
        <th>Rodzaj grobu</th>
        <th>Opłata</th>
        <th>Notka grobu</th>
        <th title="Data pochówku">Data p.</th>
        <th title="Rodzaj pochówku">Rodzaj p.</th>
        <th>Notka pochówku</th>
        <th>Akcje</th>
    </tr>
    </thead>

    <tbody>
    <?php
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
            echo "<tr>";
            echo "<td>" . $licznik++ . "</td>";
            echo "<td>" . htmlspecialchars($row["zmarly_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["grob_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["imie"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["nazwisko"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["data_urodzenia"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["data_smierci"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["notka_zmarlego"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["lokalizacja"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["rodzaj"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["oplata"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["notka_grobu"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["data_pochowku"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["rodzaj_pochowku"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["notka_pochowku"]) . "</td>";
            echo "<td>";
            if (isset($_SESSION['login'])) {
                echo "<a class='btn btn-warning btn-sm' style='margin-right: 4px;' href='editpochowki.php?id=" . htmlspecialchars($row["pochowek_id"]) . "' title='Edytuj'><i class='bi bi-pencil-square'></i></a>";
                echo "<a class='btn btn-danger btn-sm' href='delpochowki.php?id=" . htmlspecialchars($row["pochowek_id"]) . "' title='Usuń'><i class='bi bi-x-circle'></i></a>";
            }
            echo "</td>";
            echo "</tr>\n";
        }
    } else {
        echo "<tr><td colspan='16'>Baza jest pusta</td></tr>";
    }

    $conn->close();
    ?>
    </tbody>
</table>