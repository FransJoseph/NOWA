<!DOCTYPE html>
<html lang="pl-PL">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="app.js" defer></script>

    <title>Wykaz Cmentarza</title>
</head>

<!-- Strona -->
<body class="d-flex flex-column min-vh-120">

<!-- Tytuł -->
<div class="jumbotron text-center w-100 m-0 rounded-0">
    <h1 class="display-4">Wykaz Cmentarza</h1>
</div>

<!-- Kontener zawężający stronę -->
<div class="container-fluid d-flex flex-column min-vh-100">

    <p>

    <!-- Przyciski -->
    <div class="row text-center" id="menu">
        <div class="col-md-12">
            <div class="btn-group">
                <button type="button" link="home.php" class="link btn btn-primary">Strona główna</button>
                <button type="button" link="zmarli.php" class="link btn btn-primary">Zmarli</button>
                <button type="button" link="groby.php" class="link btn btn-primary">Groby</button>
                <button type="button" link="pochowki.php" class="link btn btn-primary">Pochówki</button>
                <button type="button" link="szukaj.php" class="link btn btn-primary">Wyszukaj w bazie</button>
                <?php session_start();
                if (isset($_SESSION['login'])) { ?>
                    <button type="button" link="logout.php" class="link btn btn-primary">
                        <i class="bi bi-unlock-fill"></i> Wyloguj się
                    </button>
                <?php } else { ?>
                    <button type="button" link="logowanie.php" class="link btn btn-primary">
                        <i class="bi bi-lock-fill"></i> Zaloguj się
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>

    <p>

    <main id="main" class="flex-grow-1 container-fluid px-4" style="overflow-x: auto;">
        <h2 style="font-weight: bold; font-size: 2.5rem; text-align: center;">Witamy na stronie cmentarza</h2>
    </main>

    <!-- Notka na końcu strony -->
    <br>
    <div class="row text bg-light" id="footer">
        <div class="col-md-12">(c) Frans Joseph PL 2025 All Rights Reserved</div>
    </div>

</div> <!-- Koniec funkcjonalnej strony (kontenera) -->
</body> <!-- Koniec strony  -->

</html>