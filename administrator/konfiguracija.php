<?php
require '../baza.class.php';

error_reporting(0);

if (isset($_POST["submit"])) {
    $baza = new Baza();
    $baza->spojiDB();



    if (isset($_POST["str_servisi"])) {
    
        if (isset($_POST["str_korisnici"])) {
            if(isset($_POST["trajanje"])){
                if(isset($_POST["broj"])){
                    if(isset($_POST["email"])){
                        $ss=$_POST["str_servisi"];
                        $sk=$_POST["str_korisnici"];
                        $trajanje=$_POST["trajanje"];
                        $br=$_POST["broj"];
                        $em=$_POST["email"];
                        
                        $sql="update konfiguracija set str_servisi='{$ss}', str_korisnici='{$sk}', trajanje_kolacica='{$trajanje}', broj_neuspjelih='{$br}',trajanje_emaila='{$em}' where naziv='A'";
                        $baza->updateDB($sql);
                        
                    }
                }
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

                    <label style="font-size: 20px; color: white; text-align: left;">Konfiguracija</label><br>

                    <br>
                    <input type="text" id="str_servisi" name="str_servisi" placeholder="Broj zapisa na stranici servisa">
                
                    <input type="text" id="str_korisnici" name="str_korisnici" placeholder="Broj zapisa na stranici korisnika">
                    
                    <input type="text" id="trajanje" name="trajanje" placeholder="Trajanje kolačića (s)">

                    <input type="text" id="broj" name="broj" placeholder="Broj pogrešnih prijava za blokiranje">
                    
                     <input type="text" id="email" name="email" placeholder="Trajanje linka za aktivaciju računa (h)">
                     <br>

                    <button type="submit" id="gumb" name="submit"> Primjeni  </button>
                </form>

            </div>



        </section>

        <br>
      

    <footer  style="position: relative; margin-top: 150px;" >
        <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
        <p><strong>&copy; 2019 Antonio Hip</strong></p>
  
    </footer>
</body>
</html>
