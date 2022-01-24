<?php
require '../baza.class.php';
error_reporting(0);


if (isset($_POST["submit"])) {
    $baza = new Baza();
    $baza->spojiDB();



    if (isset($_POST["naziv"])) {
    
        if (isset($_POST["informacije"])) {
            if (!empty($_FILES)) {


                $naziv = $_POST["naziv"];
                $informacije = $_POST["informacije"];
                $logo = basename($_FILES['userfile']['name']);
                $putanja = "multimedija/logo/" . $logo;
                $upit = "INSERT INTO autokuca (naziv,logo,informacije) VALUES ('{$naziv}','{$putanja}','{$informacije}')";
                $baza->updateDB($upit);

                require '../uploaderA.php';
            }
        }
    }
    $baza->zatvoriDB();
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
        <script type="text/javascript" src="../js/autokuce.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    </head>
    <body>
        <header>
            <h1 class="nPrijava" style="text-align: center">Autokuce</h1>
           <ul>
                <li><a href="../index.php">Autokuće</a></li>
                <li><a href="../lokacijeServisi.php">Servisi</a></li>
                <?php
                error_reporting(0);
                require '../sesija.class.php';
                Sesija::kreirajSesiju();

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
            <div style="text-align: center;" class="in" class="container">

                <form id="formamod" name="formamod" novalidate enctype="multipart/form-data" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                    <label style="font-size: 20px; color: #777; text-align: left;">Autokuca</label><br>

                    <br>
                    <input type="text" id="naziv" name="naziv" placeholder="naziv autokuće">
                    <p ></p>

                    <textarea  style="width: 70%" id="informacije" rows="3" placeholder="informacije..." name="informacije"></textarea>

                    <p>Dodajte sliku autokuce</p><br>

                    <input type="file" name="userfile" id="logo"><br>

                    <button type="submit" id="gumb" name="submit"> Izradi novu autokuću  </button>
                </form>

            </div>



        </section>

        

    <footer  style="position: relative; margin-top: 150px;" >
        <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
        <p><strong>&copy; 2019 Antonio Hip</strong></p>
       
    </footer>
</body>
</html>
