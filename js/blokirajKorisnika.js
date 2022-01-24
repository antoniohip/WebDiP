$(document).ready(function () {
    $('#primjeni').click(function () {
     
        var e = document.getElementById("odabir2");
        var odabrano2 = e.options[e.selectedIndex].value;
        var id=document.getElementById('id').value;
   
        
        $.ajax({
            url: "../PHP/blokirajKorisnika.php",
            method: "POST",
            data: {id: id,odabrano2:odabrano2},
            dataType: "text",
            success: function (html)
            {
                $('#rezultat2').html(html);
            }
        });
        
         var e = document.getElementById("odabir");
        odabrano = e.options[e.selectedIndex].value;
        
        $.ajax({
            url: "../PHP/prikaziKorisnike.php",
            method: "POST",
            data: {odabrano: odabrano,str: 1},
            dataType: "text",
            success: function (html)
            {
                $('#rezultat').html(html);
            }
        });
        document.getElementById('id').value="";
        
        
    });
});