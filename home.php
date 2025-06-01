<!DOCTYPE html>
<html lang="pl">

<h2>Strona główna</h2>

<p>
<p>

<div class="my-4 text-center text-muted">
    <i class="bi bi-cross" style="font-size: 2rem;"></i>
    <blockquote class="blockquote mt-2">
        <p class="mb-0 font-italic" style="font-size: 1.3rem;">Pamiętajmy o modlitwie za zmarłych nie tylko od święta!</p>
    </blockquote>
</div>

<h3>Ostatnio pochowani</h3>

<table class="table table-bordered table-sm table-striped bg-white">
    <thead class="thead-light">
    <tr>
        <th>Imię i nazwisko</th>
        <th>Zmarły/zmarła</th>
        <th>Pochówek</th>
    </tr>
    </thead>
    <tbody>
    <?php
    include 'dbconfig.php';
    $conn = new mysqli($server, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    $sql = "SELECT z.imie, z.nazwisko, z.data_smierci, p.data_pochowku
                FROM pochowki p
                JOIN zmarli z ON p.id_zmarly = z.id
                ORDER BY p.data_pochowku DESC
                LIMIT 10";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['imie']) . " " . htmlspecialchars($row['nazwisko']) . "</td>";
            echo "<td>" . htmlspecialchars($row['data_smierci']) . "</td>";
            echo "<td>" . ($row['data_pochowku'] ? htmlspecialchars($row['data_pochowku']) : "<span class='text-muted'>Nieznany</span>") . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Brak danych do wyświetlenia</td></tr>";
    }

    $conn->close();
    ?>
    </tbody>
</table>