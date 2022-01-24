

function provjeri_mail() {

    var reg = /^([a-zA-Z0-9]+)((\.){1}[a-zA-Z0-9]+)*(\@){1}([a-zA-Z]+)((\.){1}[a-zA-Z]+)+([a-zA-Z]+)$/;
    if (reg.test($("#email").val())) {
        $("#mail").removeClass("greska");
        greska1 = 0;

        if (greska1 === 0 && greska2 === 0 && greska3 === 0 && greska4 === 0 && greska5 === 0 && greska6 === 0) {
            $("#submit").prop("disabled", false);
        }

    } else {
        greska1 = 1;
        alert("Nevažeći mail!");
        $("#mail").addClass("greska");
        alert("lol"+greska1+greska2+greska3+greska4+greska5+greska6);
        if (greska1 === 1 || greska2 === 1 || greska3 === 1 || greska4 === 1 || greska5 === 1 || greska6 === 1) {
            $("#submit").prop("disabled", true);
        }
    }
}




function provjeri_korime() {

    var reg = /^[A-Za-z]+(?:[ _-][A-Za-z0-9]+)*$/;
    if (reg.test($("#korime").val())) {
        greska2 = 0;
        $("#korime").removeClass("greska");

        if (greska1 === 0 && greska2 === 0 && greska3 === 0 && greska4 === 0 && greska5 === 0 && greska6 === 0) {
            $("#submit").prop("disabled", false);
        }
    } else {
        greska2 = 1;
        alert("Neispravno korisničko ime. Mora započeti slovima!");
        $("#korime").addClass("greska");
     
        if (greska1 === 1 || greska2 === 1 || greska3 === 1 || greska4 === 1 || greska5 === 1 || greska6 === 1) {
            $("#submit").prop("disabled", true);
        }
    }
}

function provjeri_ime() {

    var reg = /^[a-zA-Z_\-]{2,30}$/;
    if (reg.test($("#ime").val())) {
        greska3 = 0;
        $("#ime").removeClass("greska");
      
        if (greska1 === 0 && greska2 === 0 && greska3 === 0 && greska4 === 0 && greska5 === 0 && greska6 === 0) {
            $("#submit").prop("disabled", false);
        }
    } else {
        greska3 = 1;
        alert("Neispravno ime!");
        $("#ime").addClass("greska");
 
        if (greska1 === 1 || greska2 === 1 || greska3 === 1 || greska4 === 1 || greska5 === 1 || greska6 === 1) {
            $("#submit").prop("disabled", true);
        }
    }
}

function provjeri_prezime() {

    var reg = /^[a-zA-Z_\-]{2,30}$/;
    if (reg.test($("#prezime").val())) {
        greska4 = 0;
        $("#prezime").removeClass("greska");

        if (greska1 === 0 && greska2 === 0 && greska3 === 0 && greska4 === 0 && greska5 === 0 && greska6 === 0) {
            $("#submit").prop("disabled", false);
        }
    } else {
        greska4 = 1;
        alert("Neispravno prezime!");
        $("#prezime").addClass("greska");
      
        if (greska1 === 1 || greska2 === 1 || greska3 === 1 || greska4 === 1 || greska5 === 1 || greska6 === 1) {
            $("#submit").prop("disabled", true);
        }
    }
}

function provjeri_lozinku() {

    var loz = $('#lozinka1').val();
    if (loz.length > 4) {
        greska5 = 0;
        $("#lozinka1").removeClass("greska");
      
        if (greska1 === 0 && greska2 === 0 && greska3 === 0 && greska4 === 0 && greska5 === 0 && greska6 === 0) {
            $("#submit").prop("disabled", false);
        }
    } else {
        greska5 = 1;
        alert("Lozinka mora sadržavati barem 5 znakova!");
        $("#lozinka1").addClass("greska");
        
        if (greska1 === 1 || greska2 === 1 || greska3 === 1 || greska4 === 1 || greska5 === 1 || greska6 === 1) {
            $("#submit").prop("disabled", true);
        }
    }
}
function provjeri_match() {

    var loz = $('#lozinka1').val();
    var loz2 = $('#lozinka2').val();
    if (loz !== loz2) {
        greska6 = 1;
        $("#lozinka2").addClass("greska");
         alert("Lozinke se ne podudaraju!");
        if (greska1 === 1 || greska2 === 1 || greska3 === 1 || greska4 === 1 || greska5 === 1 || greska6 === 1) {
            $("#submit").prop("disabled", true);
        }
    } else {
        greska6 = 0;
       
        $("#lozinka2").removeClass("greska");
  
        if (greska1 === 0 && greska2 === 0 && greska3 === 0 && greska4 === 0 && greska5 === 0 && greska6 === 0) {
            $("#submit").prop("disabled", false);
        }
    }
}