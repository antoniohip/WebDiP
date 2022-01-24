$(document).ready(function () {
    $('#search').keyup(function () {
        var txtbox = $(this).val();
        var str = 1;

        $.ajax({
            url: "PHP/prikaziLokacije.php",
            method: "POST",
            data: {txtbox: txtbox, str: str},
            dataType: "text",
            success: function (html)
            {
                $('#rezultat').html(html);
            }
        });
    });
});

$(document).ready(function () {

    var txtbox = $('#search').val();
    var str = 1;

    $.ajax({
        url: "PHP/prikaziLokacije.php",
        method: "POST",
        data: {txtbox: txtbox, str: str},
        dataType: "text",
        success: function (html)
        {
            $('#rezultat').html(html);
        }
    });

});

var smjer;
var stupac;

$(document).on('click','.pagination_link', function (e) {
    e.preventDefault();
    var txtbox = $('#search').val();
    var str = $(this).attr("value");
    
    
     $.ajax({
            url: "PHP/prikaziLokacije.php",
            method: "POST",
            data: {txtbox: txtbox, str: str, stupac:stupac, smjer:smjer},
            dataType: "text",
            success: function (html)
            {
                $('#rezultat').html(html);
            }
        });
});  



$(document).on('click','.sort', function () {
    var txtbox = $('#search').val();
    stupac = $(this).attr("id");
    smjer = $(this).data("order");
    
     $.ajax({
            url: "PHP/prikaziLokacije.php",
            method: "POST",
            data: {txtbox: txtbox, str: 1, stupac:stupac, smjer:smjer},
            dataType: "text",
            success: function (html)
            {
                $('#rezultat').html(html);
            }
        });
});  


