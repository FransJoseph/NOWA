$(document).ready(function () {
    // Ładowanie treści do #main po kliknięciu w link z klasą .link
    $(".link").click(function () {
        const targetUrl = $(this).attr("link");
        if (targetUrl) {
            $("#main").load(targetUrl);
        }
    });

    // Funkcja do pokazywania/ukrywania pola daty i resetowania wartości inputu
    function toggleDateField(toggleSelector, containerSelector, inputSelector) {
        const isChecked = $(toggleSelector).is(":checked");
        $(containerSelector).toggle(isChecked);
        if (!isChecked) {
            $(inputSelector).val("");
        }
    }

    // Obsługa przełączników dat urodzenia i śmierci
    $("#toggleUrodzenie").on("change", function () {
        toggleDateField("#toggleUrodzenie", "#urodzenieContainer", "#data_urodzenia");
    });

    $("#toggleSmierc").on("change", function () {
        toggleDateField("#toggleSmierc", "#smiercContainer", "#data_smierci");
    });

    // Inicjalne ustawienie widoczności i wartości pól dat
    toggleDateField("#toggleUrodzenie", "#urodzenieContainer", "#data_urodzenia");
    toggleDateField("#toggleSmierc", "#smiercContainer", "#data_smierci");

    // Inicjalizacja przełącznika "brak daty" dla pochówku
    function initPochowekDateToggle() {
        const checkbox = $("#brak_daty");
        const input = $("#data_pochowku");

        if (checkbox.length && input.length) {
            // Stan początkowy - wyłącz pole daty jeśli checkbox zaznaczony
            input.prop("disabled", checkbox.is(":checked"));

            checkbox.on("change", function () {
                if (checkbox.is(":checked")) {
                    input.prop("disabled", true).val("");
                } else {
                    input.prop("disabled", false).focus();
                }
            });
        }
    }

    // Obserwator zmian w elemencie #main, aby dynamicznie inicjalizować elementy
    const main = document.getElementById("main");
    if (main) {
        const observer = new MutationObserver(() => {
            initPochowekDateToggle();
        });
        observer.observe(main, { childList: true, subtree: true });
    }

    // Inicjalizacja przy starcie strony
    initPochowekDateToggle();
});