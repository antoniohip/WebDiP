<?php
error_reporting(0);
if (isset($_GET['stranica']) && $_GET['stranica'] != "") {
    $page_no = $_GET['stranica'];
} else {
    $page_no = 1;
}




$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
?>
<!DOCTYPE html>

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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/lokacije.js"></script>
        <style type="text/css"></style>

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
        <div>
            <input type="text" name="search" id="search" value="<?php if (isset($_GET['autokuca'])) {
    echo $_GET['autokuca'];
} ?>" >
        </div>
        <div class="w3-container"><div class="w3-responsive" id="rezultat"></div></div>
        <footer  style="position: relative; margin-top: 150px;" >
            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
           
  
        </footer>
    </body>
</html>
