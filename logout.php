<?PHP
session_start();
session_destroy();
echo "Wylogowywanie... Zostaniesz przekierowany za chwilę.";
?>

<script>
    setTimeout(function () {
        window.history.go(-2);
    }, 250); // 1000 ms = 1 sekunda
</script>
