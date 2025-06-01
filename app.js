$(document).ready(function () {
    $(".link").click(function () {
        $("#main").load($(this).attr("link"));
    });

    // Pokazuje/ukrywa pole daty (inne przypadki)
    function toggleDateField(toggleSelector, containerSelector, inputSelector) {
        if ($(toggleSelector).is(":checked")) {
            $(containerSelector).show();
        } else {
            $(containerSelector).hide();
            $(inputSelector).val("");
        }
    }

    $("#toggleUrodzenie").on("change", function () {
        toggleDateField("#toggleUrodzenie", "#urodzenieContainer", "#data_urodzenia");
    });

    $("#toggleSmierc").on("change", function () {
        toggleDateField("#toggleSmierc", "#smiercContainer", "#data_smierci");
    });

    toggleDateField("#toggleUrodzenie", "#urodzenieContainer", "#data_urodzenia");
    toggleDateField("#toggleSmierc", "#smiercContainer", "#data_smierci");

    // ---- Pochówek - brak daty ----
    function initPochowekDateToggle() {
        const checkbox = $("#brak_daty");
        const input = $("#data_pochowku");

        if (checkbox.length && input.length) {
            // ustaw stan początkowy
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

    // Obserwator zmian w #main dla dynamicznych załadunków
    const observer = new MutationObserver(() => {
        initPochowekDateToggle();
    });

    const main = document.getElementById("main");
    if (main) {
        observer.observe(main, { childList: true, subtree: true });
    }

    // Pierwsze uruchomienie
    initPochowekDateToggle();
});