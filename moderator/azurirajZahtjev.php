<?php
require '../baza.class.php';

error_reporting(0);
require '../sesija.class.php';
Sesija::kreirajSesiju();
$korisnik = Sesija::dajkorisnika();
$kor = $korisnik['korisnik'];
$baza = new Baza();
$baza->spojiDB();
if (isset($_POST["zahtjev"])) {

    $doslo = $_POST["zahtjev"];
    $zahtjev_razdvoji=explode('|', $doslo);
    $zahtjev=$zahtjev_razdvoji[0];
    $termin=$zahtjev_razdvoji[1];
    
       

    if (isset($_POST["odobri"])) {

        $upit = "update zahtjev_za_servis set status_id_status = '2' where id_zahtjev = '$zahtjev'";

        $rezultat2 = $baza->updateDB($upit);
    }

    if (isset($_POST["odbij"])) {
        $upit2 = "update zahtjev_za_servis set status_id_status = '3' where id_zahtjev = '$zahtjev'";

        $rezultat = $baza->updateDB($upit2);
        
        $sql="update termin set broj_mjesta = (broj_mjesta + 1) where id_termin='{$termin}'";
        $rezultat2=$baza->updateDB($sql);
    }
     if (isset($_POST["nije"])) {
        $upit2 = "update zahtjev_za_servis set status_id_status = '4' where id_zahtjev = '$zahtjev'";

        $rezultat = $baza->updateDB($upit2);
    }
     if (isset($_POST["dosao"])) {
        $upit2 = "update zahtjev_za_servis set status_id_status = '8' where id_zahtjev = '$zahtjev'";

        $rezultat = $baza->updateDB($upit2);
    }
}
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
            <h1 class="nPrijava" style="text-align: center">Autokuce</h1>
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
                        echo '<a href="kreirajTermin.php">Kreiranje termina</a>';
                        echo '<a href="azurirajZahtjev.php">Ažuriraj zahtjev</a>';
                        echo '<a href="evidencija.php">Informiraj korisnika o sevisu</a>';
                        echo ' </div>';
                        echo " </div>";
                      
                    }
                    if($uloga > 2){
                          echo "<div class='dropdown'>";
                        echo '<button class="dropbtn">Administrator';
                        echo '<i class="fa fa-caret-down"></i>';
                        echo ' </button>';
                        echo '<div class="dropdown-content">';
                        echo '<a href="../administrator/upravljanjeRacunima.php">Upravljanje korisničkim računima</a>';
                        echo '<a href="../administrator/konfiguracija.php">Konfiguracija sustava</a>';
                        echo '<a href="../administrator/upravljanjeModeratorima.php">Kreiranje i dodjela moderatora</a>';
                        echo '<a href="../administrator/kreiranjeAutokuce.php">Kreiraj autokuću</a>';
                        echo '<a href="../administrator/kreiranjeServisa.php">Kreiraj lokaciju servisa</a>';
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

                <form novalidate enctype="multipart/form-data" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <select  style="width: 70%; height: 30px;" id="zahtjev" name="zahtjev">
                        <?php
                        $upit = "select t.id_termin, z.id_zahtjev, k.korisnicko_ime, z.naziv as 'naziv_zahtjeva', z.opis, t.naziv as 'naziv_termina', s.opis_statusa from zahtjev_za_servis z join korisnik k on z.korisnik_id_korisnik=k.id_korisnik join termin t on z.termin_id=t.id_termin join status s on z.status_id_status = s.id_status";

                        $rezultat2 = $baza->selectDB($upit);



                        echo '<option selected="selected">Odaberite zahtjev...</selected>';
                        while ($red = mysqli_fetch_array($rezultat2)) {

                            $naz = $red['korisnicko_ime'] . " | " . $red["naziv_zahtjeva"] . " | " . $red["opis"] . " | " . $red["naziv_termina"] . " | " . $red["opis_statusa"];
                            $id = $red['id_zahtjev']."|".$red["id_termin"];
                            echo "<option value='$id'>$naz</option>";
                        }
                        ?>
                    </select><br>



                    <button type="submit" id="odobri" name="odobri"> Odobri  </button>
                    <button type="submit" id="odbij" name="odbij"> Odbij  </button>
                    <button type="submit" id="dosao" name="dosao"> Došao  </button>
                    <button type="submit" id="nije" name="nije"> Nije došao  </button>
                   
                 



                </form>


            </div>



        </section>
        <footer  style="position: relative; margin-top: 150px;" >
            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
            
        </footer>
    </body>
</html>
