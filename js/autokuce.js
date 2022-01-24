$(document).ready(function () {

    $('#tablica').DataTable();
    $.ajax({
        url: "../PHP/prikaziAutokuce.php",
        method: "POST",
        data: {},
        dataType: "text",
        success: function (html)
        {
            $('#rezultat').html(html);
        }
    });
    $('#tablica').DataTable();

});

 $('#tablica').DataTable();