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

$zapytanie = "INSERT INTO `pochowki` (`id`, `id_osoby`, `id_grobu`) VALUES ('$zmarlyID', '$grobID', '$dataPochowku');";


$result = $conn->query($zapytanie);

$conn->close();

?>