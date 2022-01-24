$(document).ready(function () {
    $('#servis').change(function () {
        var e = document.getElementById("servis");
        var odabrano = e.options[e.selectedIndex].value;

        $.ajax({
            url: "../PHP/prikaziTermine.php",
            method: "POST",
            data: {odabrano: odabrano},
            dataType: "text",
            success: function (html)
            {
                $('#termin').html(html);
            }
        });
    });
    $('#termin').change(function (e) {
        e.preventDefault();
        var f = document.getElementById("termin");
        var odabrano2 = f.options[f.selectedIndex].value;
        $.ajax({
            url: "../PHP/popuniTermin.php",
            method: "POST",
            data: {pocetak: odabrano2},
            dataType: "text",
            success: function (html)
            {
               $("#pocetak").val(html);
            }
        });

    });
    
    $('#termin').change(function (e) {
        e.preventDefault();
        var f = document.getElementById("termin");
        var odabrano2 = f.options[f.selectedIndex].value;
        $.ajax({
            url: "../PHP/popuniTermin.php",
            method: "POST",
            data: {zavrsetak: odabrano2},
            dataType: "text",
            success: function (html)
            {
               $("#zavrsetak").val(html);
            }
        });

    });
    $('#termin').change(function (e) {
        e.preventDefault();
        var f = document.getElementById("termin");
        var odabrano2 = f.options[f.selectedIndex].value;
        $.ajax({
            url: "../PHP/popuniTermin.php",
            method: "POST",
            data: {broj: odabrano2},
            dataType: "text",
            success: function (html)
            {
               $("#broj").val(html);
            }
        });

    });
    
     $('#termin').change(function (e) {
        e.preventDefault();
        var f = document.getElementById("termin");
        var odabrano2 = f.options[f.selectedIndex].value;
        $.ajax({
            url: "../PHP/popuniTermin.php",
            method: "POST",
            data: {slika: odabrano2},
            dataType: "text",
            success: function (html)
            {
               $('#prikazisliku').html(html);
            }
        });

    });
    
});


