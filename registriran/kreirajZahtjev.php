<?php
require '../baza.class.php';

error_reporting(0);


if (isset($_POST["submit"])) {
    $baza=new Baza();
    $baza->spojiDB();
    
    
    if (isset($_POST["naziv"])) {
 
        if (isset($_POST["opis"])) {
            if (!empty($_FILES)) {
                
                require '../sesija.class.php';
                Sesija::kreirajSesiju();
                $korisnik = Sesija::dajkorisnika();
                $kor = $korisnik['korisnik'];
                
                $upit1="select id_korisnik from korisnik where korisnicko_ime = '{$kor}'";
                $rezultat = $baza->selectDB($upit1);
                $red = mysqli_fetch_array($rezultat);
                
                $id=$red['id_korisnik'];
                $servis=$_POST["servis"];                
                $termin=$_POST['termin'];
                $opis=$_POST["opis"];
                $naziv = $_POST["naziv"];
                $vr = date('Y-m-d H:i:s');
                $slika = basename($_FILES['userfile']['name']);
                $putanja = "multimedija/servisi/" . $slika;
                $upit = "INSERT INTO zahtjev_za_servis (korisnik_id_korisnik,servis_id_servis,termin_id,status_id_status,naziv,opis,slika,vrijeme_kreiranja) VALUES ('{$id}','{$servis}','{$termin}','1','{$naziv}','{$opis}','{$putanja}','{$vr}')";
                $baza->updateDB($upit);

                require '../uploaderC.php';
                     
                $upit3 = "update termin set broj_mjesta = (broj_mjesta - 1) where id_termin='{$termin}'";
                $baza->updateDB($upit3);
                $poruka="Zahtjev je uspješno poslan!";
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
        <script type="text/javascript" src="../js/termini.js"></script>


    </head>
    <body>
        <header>
            <h1 class="nPrijava" style="text-align: center">Autokuce</h1>
            <ul>
                <li><a href="../index.php">Autokuće</a></li>
                <li><a href="../lokacijeServisi.php">Servisi</a></li>
                <?php
                error_reporting(0);
                if(!isset($_POST["submit"])){
                    require '../sesija.class.php';
                Sesija::kreirajSesiju();
                }

                if (isset($_SESSION['korisnik'])) {
                    echo '<li style="float:right"><a class="active" href="../obrasci/odjava.php">Odjava</a></li>';
                    echo "<div class='dropdown'>";
                    echo '<button class="dropbtn">Zahtjevi za servis';
                    echo '<i class="fa fa-caret-down"></i>';
                    echo ' </button>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="kreirajZahtjev.php">Kreiraj zahjev za servis</a>';
                    echo '<a href="kreiraniZahtjevi.php">Kreirani zahjevi za servis</a>';
                    echo '<a href="azurirajZahtjev.php">Ažuriraj stanje zahtjeva za servis</a>';
                    echo '<a href="evidencija.php">Informacije o završenim servisima</a>';
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
            <div style="text-align: center;" class="in" class="container">

                <form id="formamod" name="formamod" novalidate enctype="multipart/form-data" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                    <label style="font-size: 30px; color: white; text-align: left;">Zahtjev za servis</label><br>


                    <select  style="width: 70%; height: 30px;" id="servis" name="servis">
                        <?php
                        $baza=new Baza();
                        $baza->spojiDB();
                        $sql = "select DISTINCT s.id_servis, s.naziv_servisa from servis s join termin t on s.id_servis = t.servis_id where t.broj_mjesta>0 order by 2";

                        $rezultat = $baza->selectDB($sql);
                        
                        echo '<option selected="selected">Odaberite servis...</selected>';
                        while ($red = mysqli_fetch_array($rezultat)) {
                            $naz = $red['naziv_servisa'];
                            $id = $red['id_servis'];
                            echo "<option value='$id'>$naz</option>";
                        }
                        ?>
                    </select><br>
                    
                    
                    <select style="width: 70%; height: 30px;" id="termin" name="termin">
                        
                    </select>
                    
                     <br>
                    <label style="font-size: 12px; color: white; text-align: left;">Početak termina</label><br>
                    <input type="text" disabled="disabled" id="pocetak" name="naziv" "><br>
                    <label style="font-size: 12px; color: white; text-align: left;">Završetak termina</label><br>
                    <input type="text" disabled="disabled" id="zavrsetak" name="zavrsetak" "><br>
                    <label style="font-size: 12px; color: white; text-align: left;">Slobodnih mjesta</label><br>
                    <input type="text" disabled="disabled" id="broj" name="broj" "><br>
                    <div id="prikazisliku" name="prikazisliku"></div>
                    
                     <input type="text"  id="naziv" placeholder="Naziv zahtjeva" name="naziv"><br>
                     <textarea style="width:70%" type="text" rows="3" id="opis" placeholder="Opis" name="opis"></textarea><br>
                     

                    <p>Dodajte sliku kvara/vozila</p><br>

                    <input type="file" name="userfile" id="slika"><br>

                    <button type="submit" id="gumb" name="submit"> Pošalji zahtjev  </button>
                  
                    <p><?php if(isset($poruka)) echo "$poruka"; ?></p>
                    
                </form>

            </div>

            

        </section>
        <footer  style="position: relative; margin-top: 150px;" >
            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
  
        </footer>
    </body>
</html>
