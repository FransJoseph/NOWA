<?php
        include 'dbconfig.php';
        session_start();
        $id=$_GET['id'];
        $conn = new mysqli($server, $user, $password, $dbname);
        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        $zapytanie = "SELECT * FROM groby WHERE `groby`.`id` = $id LIMIT 1;";

        $result = $conn->query($zapytanie);

        if ($result->num_rows > 0) {
           
            while ($row = $result->fetch_assoc()) {  //$row["nazwa"] ?>

<h2>Edycja grobu</h2>

<form action="zapisz_editgrobu.php" method="post">

    <div class="form-group">
        <input type="text" name="id" value="<?PHP echo $row['id'];?>" hidden>

        <label for="lokalizacja">Lokalizacja:</label>
        <input type="text" class="form-control" id="lokalizacja" name="lokalizacja" value="<?PHP echo $row['lokalizacja'];?>" autocomplete="off">
    </div>

    <div class="form-group">
        <label for="rodzaj">Rodzaj:</label>
        <input list="rodzaj" class="form-control" id="rodzaj" name="rodzaj" value="<?PHP echo $row['rodzaj'];?>" autocomplete="off">

        <datalist id="rodzaj">
            <option value="ziemny">
            <option value="grobowiec">
            <option value="pomnik">
            <option value="kolumbarium">
            <option value="inny">
        </datalist>

    </div>

    <div class="form-group">
        <label>Opłata:</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="oplata" id="oplata_tak" value="TAK"
                <?php if (isset($row['oplata']) && $row['oplata'] === 'TAK') echo 'checked'; ?> required>
            <label class="form-check-label" for="oplata_tak">TAK</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="oplata" id="oplata_nie" value="NIE"
                <?php if (isset($row['oplata']) && $row['oplata'] === 'NIE') echo 'checked'; ?> required>
            <label class="form-check-label" for="oplata_nie">NIE</label>
        </div>
    </div>

    <div class="form-group">
        <label for="notka">Notka:</label>
        <input type="text" class="form-control" id="notka" name="notka" value="<?PHP echo $row['notka'];?>" autocomplete="off">
    </div>

    <p>
        <button type="submit" class="btn btn-primary">Popraw</button>
    </p>

</form>

<?PHP       }
        } else { echo "0 results"; }

        $conn->close(); ?>