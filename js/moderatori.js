var odabrano;
var odabrano2;
var unos;
var txtbox;
$(document).ready(function () {
        
        var e = document.getElementById("odabir");
        odabrano = e.options[e.selectedIndex].value;
        
        $.ajax({
            url: "../PHP/prikaziModeratore.php",
            method: "POST",
            data: {odabrano: odabrano},
            dataType: "text",
            success: function (html)
            {
                $('#rezultat').html(html);
            }
        });
    
});

$(document).on('click', '.sort', function () {
  
    var txtbox = $('#search').val();
    stupac = $(this).attr("id");
    smjer = $(this).data("order");
   
    $.ajax({
        url: "../PHP/prikaziModeratore.php",
        method: "POST",
        data: {txtbox: txtbox, str: 1,odabrano:odabrano, stupac: stupac, smjer: smjer},
        dataType: "text",
        success: function (html)
        {
            $('#rezultat').html(html);
        }
    });
});


$(document).ready(function () {
    $('#search').keyup(function () {
        var txtbox = $(this).val();
        var str = 1;
        
        $.ajax({
            url: "../PHP/prikaziModeratore.php",
            method: "POST",
            data: {txtbox: txtbox,odabrano:odabrano, str: str},
            dataType: "text",
            success: function (html)
            {
                $('#rezultat').html(html);
            }
        });
    });
});



$(document).ready(function () {
    $('#odabir').change(function () {
        var e = document.getElementById("odabir");
        odabrano = e.options[e.selectedIndex].value;
    
        $.ajax({
            url: "../PHP/prikaziModeratore.php",
            method: "POST",
            data: {odabrano: odabrano},
            dataType: "text",
            success: function (html)
            {
                $('#rezultat').html(html);
            }
        });
    });
});

var smjer;
var stupac;

$(document).on('click', '.pagination_link', function (e) {
    e.preventDefault();
    var txtbox = $('#search').val();
    var str = $(this).attr("value");


    $.ajax({
        url: "../PHP/prikaziModeratore.php",
        method: "POST",
        data: {txtbox: txtbox, str: str,odabrano:odabrano, stupac: stupac, smjer: smjer},
        dataType: "text",
        success: function (html)
        {
            $('#rezultat').html(html);
        }
    });
});





