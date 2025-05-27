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
  <link rel="stylesheet" href="./css/style.css">
  <script type="text/javascript" src="app.js" defer></script>

  <title>Wykaz Cmentarza</title>
</head>

<!-- Strona -->
<body class="d-flex flex-column min-vh-100">

<!-- Kontener zawężający stronę -->
<div class="container d-flex flex-column min-vh-100">

    <!-- Tytuł -->
    <div class="jumbotron text-center">
        <h1>Wykaz Cmentarza</h1>
    </div>

    <!-- Przyciski -->
    <div class="row text-center" id="menu">
        <div class="col-md-12">
            <div class="btn-group">
                <button type="button" link="home.php" class="link btn btn-primary">Strona główna</button>
                <button type="button" link="zmarli.php" class="link btn btn-primary">Zmarli</button>
                <button type="button" link="groby.php" class="link btn btn-primary">Groby</button>
                <button type="button" link="pochowki.php" class="link btn btn-primary">Baza</button>
                <button type="button" link="kontakt.php" class="link btn btn-primary">Kontakt</button>
                <?PHP session_start();
                if (isset ($_SESSION ['login'] ) ) {?> <button type="button" link="logout.php" class="link btn btn-primary"> <i class="bi bi-unlock-fill"></i> Wyloguj się</button> <?PHP   }
                else{   ?> <button type="button" link="logowanie.php" class="link btn btn-primary"> <i class="bi bi-lock-fill"></i> Zaloguj się</button> <?PHP   } ?>
            </div>
        </div>
    </div>

    <div id="main" class="flex-grow-1">
        <h2>Strona główna</h2>
        <p>Witamy na stronie cmentarza</p>
    </div>

    <!-- Notka na końcu strony -->
    <div class="row text bg-light" id="footer">
        <div class="col-md-12">(c) FJ 2025 All Rights Reserved</div>
    </div>

</div> <!-- Koniec funkcjonalnej strony (kontenera) -->
</body> <!-- Koniec strony  -->

</html>