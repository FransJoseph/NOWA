<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wylogowywanie</title>
</head>
<body>
<p>Wylogowywanie... Zostaniesz przekierowany za chwilę.</p>

<script>
    setTimeout(function () {
        window.location.href = 'index.php'; // Przekierowanie na stronę główną
    }, 1000); // 1000 ms = 1 sekunda
</script>
</body>
</html>