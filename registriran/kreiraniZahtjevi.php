<?php
require '../baza.class.php';
error_reporting(0);

require '../sesija.class.php';
Sesija::kreirajSesiju();
$korisnik = Sesija::dajkorisnika();
$kor = $korisnik['korisnik'];
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
        <link href="../css/ahip.css" rel="stylesheet" type="text/css">
        <link href="../css/ahip_600.css" rel="stylesheet" type="text/css">
        <link href="../css/formaModerator.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style type="text/css"></style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 



    </head>
    <body>
        <header>
           <ul>
                <li><a href="../index.php">Autokuće</a></li>
                <li><a href="../lokacijeServisi.php">Servisi</a></li>
                <?php
                error_reporting(0);
                

                if (isset($_SESSION['korisnik'])) {
                    echo '<li style="float:right"><a class="active" href="../obrasci/odjava.php">Odjava</a></li>';
                    echo "<div class='dropdown'>";
                    echo '<button class="dropbtn">Zahtjevi za servis';
                    echo '<i class="fa fa-caret-down"></i>';
                    echo ' </button>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="../registriran/kreirajZahtjev.php">Kreiraj zahjev za servis</a>';
                    echo '<a href="../registriran/kreiraniZahtjevi.php">Kreirani zahjevi za servis</a>';
                    echo '<a href="../registriran/azurirajZahtjev.php">Ažuriraj stanje zahtjeva za servis</a>';
                    echo '<a href="../registriran/evidencija.php">Informacije o završenim servisima</a>';
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
                        echo '<a href="../moderator/kreirajTermin.php">Kreiranje termina</a>';
                        echo '<a href="../moderator/azurirajZahtjev.php">Ažuriraj zahtjev</a>';
                        echo '<a href="../moderator/evidencija.php">Informiraj korisnika o sevisu</a>';
                        echo ' </div>';
                        echo " </div>";
                      
                    }
                    if($uloga > 2){
                          echo "<div class='dropdown'>";
                        echo '<button class="dropbtn">Administrator';
                        echo '<i class="fa fa-caret-down"></i>';
                        echo ' </button>';
                        echo '<div class="dropdown-content">';
                        echo '<a href="upravljanjeRacunima.php">Upravljanje korisničkim računima</a>';
                        echo '<a href="konfiguracija.php">Konfiguracija sustava</a>';
                        echo '<a href="upravljanjeModeratorima.php">Kreiranje i dodjela moderatora</a>';
                        echo '<a href="kreiranjeAutokuce.php">Kreiraj autokuću</a>';
                        echo '<a href="kreiranjeServisa.php">Kreiraj lokaciju servisa</a>';
                        echo ' </div>';
                        echo " </div>";
                    }
                }
                if (!isset($_SESSION['korisnik'])) {
                    echo '<li style="float:right"><a class="active" href="../obrasci/prijava.php">Prijava</a></li>';
                    echo '<li style="float:right"><a class="active" href="../obrasci/registracija.php">Registracija</a></li>';
                }
                ?>

            </ul>
        </header>
        <section>
            <div>

                
<?php

$baza=new Baza();
$baza->spojiDB();
$upit1 = "select id_korisnik from korisnik where korisnicko_ime = '{$kor}'";
$rezultat = $baza->selectDB($upit1);
$red2 = mysqli_fetch_array($rezultat);
$id = $red2['id_korisnik'];


$upit = "select z.naziv as 'naziv_zahtjeva', z.opis, t.naziv as 'naziv_termina', t.datum_i_vrijeme_pocetka,s.id_status, s.opis_statusa from zahtjev_za_servis z join termin t on z.termin_id = t.id_termin join status s on s.id_status = z.status_id_status where z.korisnik_id_korisnik = '{$id}'";

$rezultat2 = $baza->selectDB($upit);
echo "<table class='sviservisi' border>";
    echo "<tr>";
    echo "<th>Naziv zahtjeva</th>";    
    echo "<th>Opis</th>";    
    echo "<th>Naziv termina</th>";    
    echo "<th>Početak termina</th>";
    echo "<th>Status</th>";        
    echo "</tr>";
    while ($red = mysqli_fetch_array($rezultat2)) {
        
        if($red["id_status"]==4 || $red["id_status"]==6){
        echo "<tr bgcolor='##FFBFBF';>";
        echo "<td>" . $red['naziv_zahtjeva'] . "</td>";        
        echo "<td>" . $red['opis'] . "</td>";
        echo "<td>" . $red['naziv_termina'] . "</td>";
        echo "<td>" . $red['datum_i_vrijeme_pocetka'] . "</td>";
        echo "<td>" . $red['opis_statusa'] . "</td>";
        echo "</tr>";
        }
        else{
            echo "<tr>";
        echo "<td>" . $red['naziv_zahtjeva'] . "</td>";        
        echo "<td>" . $red['opis'] . "</td>";
        echo "<td>" . $red['naziv_termina'] . "</td>";
        echo "<td>" . $red['datum_i_vrijeme_pocetka'] . "</td>";
        echo "<td>" . $red['opis_statusa'] . "</td>";
        echo "</tr>";
        }
    }
    echo "</table>";



$baza->zatvoriDB();
?>
                   
            </div>



        </section>
        <footer  style="position: relative; margin-top: 150px;" >
            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
          
        </footer>
    </body>
</html>
