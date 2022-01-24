<?php
require 'baza.class.php';
error_reporting(0);
$veza = new Baza();
$veza->spojiDB();

$upit = "SELECT * FROM autokuca";
$rezultat = $veza->selectDB($upit);
$broj = mysqli_num_rows($rezultat);
?>



<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Autokuce</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Prijava">
        <meta name="autor" content="Antonio Hip">
        <meta name="kljucneRijeci" content="Korisničko ime, lozinka, korisnički račun">
        <link href="css/ahip.css" rel="stylesheet" type="text/css">
        <link href="css/ahip_600.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style type="text/css"></style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 

        <script>
            $(document).ready(function () {
                var unos = $(this).val();

                $.ajax({
                    url: "pretrazivanjeAutokuce.php",
                    method: "POST",
                    data: {unos: unos},
                    dataType: "text",
                    success: function (html)
                    {
                        $('#pretraga').html(html);
                    }
                });
            });

            $(document).ready(function () {
                $('#unos').keyup(function () {
                    var unos = $(this).val();

                    $.ajax({
                        url: "pretrazivanjeAutokuce.php",
                        method: "POST",
                        data: {unos: unos},
                        dataType: "text",
                        success: function (html)
                        {
                            $('#pretraga').html(html);
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <header>
            <h1 class="nPrijava" style="text-align: center">Autokuce</h1>
            <ul>
                <li><a href="index.php">Autokuće</a></li>
                <li><a href="lokacijeServisi.php">Servisi</a></li>
                <?php
                error_reporting(0);
                require 'sesija.class.php';
                Sesija::kreirajSesiju();

                if (isset($_SESSION['korisnik'])) {
                    echo '<li style="float:right"><a class="active" href="obrasci/odjava.php">Odjava</a></li>';
                    echo "<div class='dropdown'>";
                    echo '<button class="dropbtn">Zahtjevi za servis';
                    echo '<i class="fa fa-caret-down"></i>';
                    echo ' </button>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="registriran/kreirajZahtjev.php">Kreiraj zahjev za servis</a>';
                    echo '<a href="registriran/kreiraniZahtjevi.php">Kreirani zahjevi za servis</a>';
                    echo '<a href="registriran/azurirajZahtjev.php">Ažuriraj stanje zahtjeva za servis</a>';
                    echo '<a href="registriran/evidencija.php">Informacije o završenim servisima</a>';
                    echo ' </div>';
                    echo " </div>";
                }
                if (isset($_SESSION["korisnik"])) {
                    $korisnik = Sesija::dajkorisnika();
                    $uloga = $korisnik['tip'];
                    
                    if ($uloga > 1) {

                        echo "<div class='dropdown'>";
                        echo '<button class="dropbtn">Moderator';
                        echo '<i class="fa fa-caret-down"></i>';
                        echo ' </button>';
                        echo '<div class="dropdown-content">';
                        echo '<a href="moderator/kreirajTermin.php">Kreiranje termina</a>';
                        echo '<a href="moderator/azurirajZahtjev.php">Ažuriraj zahtjev</a>';
                        echo '<a href="moderator/evidencija.php">Informiraj korisnika o sevisu</a>';
                        
                        echo ' </div>';
                        echo " </div>";
                      
                    }
                    if($uloga > 2){
                          echo "<div class='dropdown'>";
                        echo '<button class="dropbtn">Administrator';
                        echo '<i class="fa fa-caret-down"></i>';
                        echo ' </button>';
                        echo '<div class="dropdown-content">';
                        echo '<a href="administrator/upravljanjeRacunima.php">Upravljanje korisničkim računima</a>';
                        echo '<a href="administrator/konfiguracija.php">Konfiguracija sustava</a>';
                        echo '<a href="administrator/upravljanjeModeratorima.php">Kreiranje i dodjela moderatora</a>';
                        echo '<a href="administrator/kreiranjeAutokuce.php">Kreiraj autokuću</a>';
                        echo '<a href="administrator/kreiranjeServisa.php">Kreiraj lokaciju servisa</a>';
                        echo ' </div>';
                        echo " </div>";
                    }
                }
                if (!isset($_SESSION['korisnik'])) {
                    echo '<li style="float:right"><a class="active" href="obrasci/prijava.php">Prijava</a></li>';
                    echo '<li style="float:right"><a class="active" href="obrasci/registracija.php">Registracija</a></li>';
                }
                ?>

            </ul>
        </header>
        <section>
            <form novalidate id="form1" method="post" name="form1"  action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                <p>Pretraživanje:</p>
                <div>
                    <input  type="text" id="unos" name="unos" placeholder="autokuca" size="20" maxlength="20"  >
                </div>
            </form>

            <div id="pretraga"></div>

        </section>
        <footer  style="position: relative; margin-top: 150px;" >
            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
            
        </footer>
    </body>
</html>
