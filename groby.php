<h2>Groby</h2>

<table class="table table-hover table-sm">
    <thead>
        <tr>
            <th>Id</th>
            <th>Lokalizacja</th>
            <th>Rodzaj</th>
            <th>Opłata</th>
            <th>Notka</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tbody>
        <?php include 'dbconfig.php';
        session_start();
        $conn = new mysqli($server, $user, $password, $dbname);
        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        $zapytanie = "SELECT * FROM groby";

        $result = $conn->query($zapytanie);

        if ($result->num_rows > 0) {
            $licznik = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $licznik++ . "</td><td>" . $row["lokalizacja"] . "</td><td>" . $row["rodzaj"] . "</td><td>" . $row["oplata"] . "</td><td>" . $row["notka"] . "</td>";
                echo "<td>";
                if (isset($_SESSION['login'])) {
                    echo "<a class='btn btn-warning btn-sm' style='margin-right: 4px;' href='editgroby.php?id=" . $row["id"] . "'title='Edytuj'> <i class='bi bi-pencil-square'> </i> </a>";
                    echo "<a class='btn btn-danger btn-sm' href='delgroby.php?id=" . $row["id"] . "'title='Usuń'> <i class='bi bi-x-circle'> </i> </a> ";
                }
                echo "</td></tr>\n";
            }
        } else {
            echo "0 results";
        }

        $conn->close(); ?>
    </tbody>
</table>

<?php if(isset($_SESSION['login'])){ ?>

<h2>Dodaj grób do bazy</h2>

<form action="dodaj_grob.php" method="post">

    <div class="form-group">
        <label for="lokalizacja">Lokalizacja</label>
        <input type="text" class="form-control" id="lokalizacja" name="lokalizacja" placeholder="Podążaj za logiką Proboszcza" autocomplete="off" required>
    </div>

    <div class="form-group">
        <label for="rodzaj">Rodzaj</label>
        <label>
            <input list="rodzaj" name="rodzaj" placeholder="Wybierz rodzaj grobu" required>
        </label>
        <datalist id="rodzaj">
            <option value="ziemny">
            <option value="pomnik">
            <option value="grób rodzinny">
            <option value="grób dziecka">
            <option value="inny">
        </datalist>
    </div>

    <div class="form-group">
        <label for="oplata">Opłata</label>
        <label>
            <input list="oplata" name="oplata" placeholder="Wybierz z listy" required>
        </label>
        <datalist id="oplata">
            <option value="TAK">
            <option value="NIE">
        </datalist>
    </div>

    <div class="form-group">
        <label for="notka">Notka (niewymagana)</label>
        <input type="text" class="form-control" id="notka" name="notka" placeholder="Informacje o przeżytych latach przy braku dat, ekshumacje, wyjaśnienia nieścisłości etc." autocomplete="off" required>
    </div>

    <button type="submit" class="btn btn-primary">Dodaj grób</button>

</form>

<?php } else { echo "<h3>Nie masz uprawnień do dodawania grobów</h3>"; } ?>