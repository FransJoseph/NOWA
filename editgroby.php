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
        <input list="rodzaje" class="form-control" id="rodzaj" name="rodzaj" value="<?PHP echo $row['rodzaj'];?>" autocomplete="off">

        <datalist id="rodzaje">
            <option value="ziemny">
            <option value="pomnik">
            <option value="grób rodzinny">
            <option value="grób dziecka">
            <option value="inny">
        </datalist>

    </div>

    <div class="form-group">
        <label for="oplata">Opłata:</label>
        <input list="TF" class="form-control" id="oplata" name="oplata" autocomplete="off" value="<?PHP echo $row['oplata'];?>">

        <datalist id="TF">
            <option value="TAK">
            <option value="NIE">
        </datalist>

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