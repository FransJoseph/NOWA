<?PHP

$login = $_POST['login'];
$haslo = SHA1($_POST['haslo']);


include 'dbconfig.php';

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$zapytanie = "SELECT * FROM operatorzy WHERE login='$login' AND haslo='$haslo'";

$result = $conn->query($zapytanie);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        session_start();
        $_SESSION['login'] = $row['login'];
        $_SESSION['haslo'] = $row['haslo'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['status'] = $row['status'];
        $_SESSION['imie'] = $row['imie'];
        $_SESSION['nazwisko'] = $row['nazwisko'];
        //header("Location: index.php");
    }
} else {
    echo "0 results";
}



$conn->close();

if(isset($_SESSION['login'])){
    echo "Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko']."<br>";
    echo "<a href='index.php'>Powrót do strony głównej</a><br>";
};

if($_SESSION['status']==0){
    echo "Konto nie jest w pełni aktywne<br>";
    session_destroy();
}
?>