<h4>Baza:</h4>

<table class="table table-hover table-sm">
    <thead>
    <tr>
        <th>Id</th>
        <th>Id Zmarłego</th>
        <th>Id grobu</th>
        <th>Imie</th>
        <th>Nazwisko</th>
        <th>Data urodzenia</th>
        <th>Data smierci</th>
        <th>Notka</th>
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
    groby.notka AS notka_grobu

    FROM pochowki
    JOIN zmarli ON pochowki.id_zmarlego = zmarli.id
    JOIN groby ON pochowki.id_grobu = groby.id
    ORDER BY pochowki.id ASC";

    $result = $conn->query($zapytanie);

    if ($result->num_rows > 0) {
        $licznik = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $licznik++ . "</td><td>" . $row["imie"] . "</td><td>" . $row["nazwisko"] . "</td><td>" . $row["data_urodzenia"] . "</td><td>" . $row["data_smierci"] . "</td><td>" . $row["notka"] . "</td>";
            echo "<td>";
            if (isset($_SESSION['login'])) {
                echo "<a class='btn btn-warning btn-sm' style='margin-right: 4px;' href='editzmarli.php?id=" . $row["id"] . "'title='Edytuj'> <i class='bi bi-pencil-square'> </i> </a>";
                echo "<a class='btn btn-danger btn-sm' href='delzmarli.php?id=" . $row["id"] . "'title='Usuń'> <i class='bi bi-x-circle'> </i> </a> ";
            }
            echo "</td></tr>\n";
        }
    } else {
        echo "0 results";
    }

    $conn->close(); ?>
    </tbody>
</table>

<form method="POST" action="zapiszpochowki.php">

<select name="zmarlyID">

    <?php
        include 'dbconfig.php';
        $conn = new mysqli($server, $user, $password, $dbname);
        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        $zapytanie = "SELECT id, imie, nazwisko, data_urodzenia, data_smierci, notka FROM zmarli";

        $result = $conn->query($zapytanie);

        if ($result->num_rows > 0) {
            $licznik = 1;
            while ($row = $result->fetch_assoc()) {
              echo "<option value='".$row['id']."'> ".$row['imie']." [".$row['nazwisko']."] [".$row['data_urodzenia']."] [".$row['data_smierci']."] [".$row['notka']."]</option>\n";
            }
        };

        $conn->close();
        ?>
</select><p></p>

<h4>Grób:</h4>

<select name="grobID">

    <?php
        include 'dbconfig.php';
        $conn = new mysqli($server, $user, $password, $dbname);
        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        $zapytanie = "SELECT id, lokalizacja, rodzaj, oplata, notka FROM groby";

        $result = $conn->query($zapytanie);

        if ($result->num_rows > 0) {
            $licznik = 1;
            while ($row = $result->fetch_assoc()) {
              echo "<option value='".$row['id']."'>".$row['lokalizacja']." [".$row['rodzaj']."] [".$row['oplata']."] [".$row['notka']."]</option>\n";
            }
        };

        $conn->close();
        ?>

</select><p></p>

<h4>Data pochówku:</h4>

    <div class="form-group">
        <input type="date" class="form-control" id="data_pochowku" name="data_pochowku" autocomplete="off">
    </div>

<h4>Rodzaj pochówku:</h4>

    <div class="form-group">
        <label>
            <input list="rodzaj_pochowku" name="rodzaj_pochowku" placeholder="Wybierz z listy" required>
        </label>
        <datalist id="rodzaj_pochowku">
            <option value="ziemny">
            <option value="urna">
        </datalist>
    </div>

<h4>Notka (niewymagana):</h4>

    <div class="form-group">
        <input type="txt" class="form-control" id="notka_pochowku" name="notka_pochowku" autocomplete="off">
    </div>

    <p>
    <p> <button type="submit" class="btn btn-primary">Powiąż</button> </p>

</form>