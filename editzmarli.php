<?php
        include 'dbconfig.php';
        session_start();
        $id=$_GET['id'];
        $conn = new mysqli($server, $user, $password, $dbname);
        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        $zapytanie = "SELECT * FROM zmarli WHERE `zmarli`.`id` = $id LIMIT 1;";

        $result = $conn->query($zapytanie);

        if ($result->num_rows > 0) {
           
            while ($row = $result->fetch_assoc()) {  //$row["nazwa"]
               
          ?>

<h2>Edycja zmarłego</h2>

<form action="zapisz_editzmarlego.php" method="post">

    <div class="form-group">
        <input type="text" name="id" value="<?PHP echo $row['id'];?>" hidden>

        <label for="imie">Imie:</label>
        <input type="text" class="form-control" id="imie" name="imie" value="<?PHP echo $row['imie'];?>" autocomplete="off">
    </div>

    <div class="form-group">
        <label for="nazwisko">Nazwisko:</label>
        <input type="text" class="form-control" id="nazwisko" name="nazwisko" value="<?PHP echo $row['nazwisko'];?>" autocomplete="off">
    </div>

    <div class="form-group">
        <label for="data_urodzenia">Data urodzenia:</label>
        <input type="date" class="form-control" id="data_urodzenia" name="data_urodzenia" autocomplete="off" value="<?PHP echo $row['data_urodzenia'];?>">
    </div>

    <div class="form-group">
        <label for="data_smierci">Data śmierci:</label>
        <input type="date" class="form-control" id="data_smierci" name="data_smierci" autocomplete="off" value="<?PHP echo $row['data_smierci'];?>">
    </div>

    <div class="form-group">
        <label for="notka">Notka:</label>
        <input type="text" class="form-control" id="notka" name="notka" value="<?PHP echo $row['notka'];?>" autocomplete="off">
    </div>

    <p>
        <button type="submit" class="btn btn-primary">Popraw</button>
    </p>

</form>

<?PHP
            };
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>