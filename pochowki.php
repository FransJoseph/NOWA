<h4>Zmarły:</h4>

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

    <p>
        <button type="submit" class="btn btn-primary">Powiąż</button>
    </p>

</select>

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

</select>

</form>