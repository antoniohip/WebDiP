$(document).ready(function () {

    

    $('#gumb').click(function () {
        
        
        
        var e = document.getElementById("autokuca");
        var autokuca = e.options[e.selectedIndex].value;
        var korisnicko = $('#kim').val();
        var ime = $('#name').val();

        var prezime = $('#prez').val();
        var datum = $('#datum').val();
        var f = document.getElementById("drzava");
        var drzava = f.options[f.selectedIndex].value;
        var email = $('#email').val();
        var lozinka = $('#lozinka1').val();
        var lozinka2 = $('#lozinka2').val();
        var greska = 0;
        if (korisnicko === "") {
            alert("Greška. Unesite korisničko ime");

        }
        if (ime === "") {
            alert("Greška. Unesite ime");
            greska = 1;
        }
        if (prezime === "") {
            alert("Greška. Unesite prezime");
            greska = 1;
        }
        if (email === "") {
            alert("Greška. Unesite email");
            greska = 1;
        }
        if (lozinka.length < 4) {
            alert("Lozinka prekratka!");
            greska = 1;

        }
        if (lozinka !== lozinka2) {
            alert("Lozinke se ne poklapaju!");
            greska = 1;
        }


        if (greska === 0) {
           
            $.ajax({
                url: "../PHP/dodajModeratora.php",
                method: "POST",
                data: {autokuca: autokuca, korisnicko: korisnicko, ime: ime, prezime: prezime, datum: datum, drzava: drzava, email: email, lozinka: lozinka},
                dataType: "text",
                success: function (html)
                {
                    $('#rezultat2').html(html);
                }
            });
            document.getElementById("formamod").reset();

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
        }

    });
});


$(document).ready(function () {


    $('#gumb1').click(function () {
        var e = document.getElementById("ak");
        var ak = e.options[e.selectedIndex].value;
        var id = $('#idkorisnika').val();
       
       var greska2=0;
       
       
        if (id === "") {
            alert("Greška. Unesite id");
            greska2=1;
        }


        if (greska2 === 0) {
            
            $.ajax({
                url: "../PHP/dodajModeratora1.php",
                method: "POST",
                data: {ak: ak, id:id},
                dataType: "text",
                success: function (html)
                {
                    $('#rezultat3').html(html);
                }
            });
            

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
        }

    });
});






