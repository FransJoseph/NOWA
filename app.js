

$(document).ready(function () {
    
    $(".link").click(function () {
        $("#main").load($(this).attr("link"));
    });

}); 
