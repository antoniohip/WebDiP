$(document).ready(function () {
    $('#zahtjev').change(function () {
        var e = document.getElementById("zahtjev");
        var odabrano = e.options[e.selectedIndex].value;
    
        $.ajax({
            url: "../PHP/mozedoci.php",
            method: "POST",
            data: {odabrano: odabrano},
            dataType: "text",
            success: function (html)
            {
                $('#mozedoci').html(html);
            }
        });
    });
});