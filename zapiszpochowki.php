<?PHP
$zmarlyID = $_POST['zmarlyID'];
$grobID = $_POST['grobID'];
$dataPochowku = $_POST['data_pochowku'];
$rodzajPochowku = $_POST['rodzaj_pochowku'];
$notkaPochowku = $_POST['notka_pochowku'];

include 'dbconfig.php';

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$zapytanie = "INSERT INTO `pochowki` (`zmarly_id`, `grob_id`, `data_pochowku`, `rodzaj_pochowku`, `notka_pochowku`) VALUES ('$zmarlyID', '$grobID', '$dataPochowku', '$rodzajPochowku', '$notkaPochowku');";


$result = $conn->query($zapytanie);

$conn->close();

?>