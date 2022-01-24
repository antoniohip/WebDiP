<?php
require '../baza.class.php';

error_reporting(0);

if (isset($_POST["submit"])) {
    $baza=new Baza();
    $baza->spojiDB();


    if (isset($_POST["naziv"])) {
 
        if (isset($_POST["kontakt"])) {
            if (!empty($_FILES)) {
                
                $autokuca=$_POST['autokuca'];
                $lokacija=$_POST['lokacija'];
                $naziv = $_POST["naziv"];
                $kontakt = $_POST["kontakt"];
                $logo = basename($_FILES['userfile']['name']);
                $putanja = "multimedija/servisi/" . $logo;
                $upit = "INSERT INTO servis (lokacija_id,autokuca_id,naziv_servisa,slika,kontakt) VALUES ('{$lokacija}','{$autokuca}','{$naziv}','{$putanja}','{$kontakt}')";
                $baza->updateDB($upit);

                require '../uploaderB.php';
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


                    <select  style="width: 70%; height: 30px;" id="autokuca" name="autokuca">
                        <?php
                        $baza=new Baza();
                        $baza->spojiDB();
                        $sql = "SELECT * FROM autokuca";

                        $rezultat = $baza->selectDB($sql);


                        while ($red = mysqli_fetch_array($rezultat)) {
                            $naz = $red['naziv'];
                            $id = $red['id_autokuca'];
                            echo "<option value='$id'>$naz</option>";
                        }
                        ?>
                    </select><br>
                    <label style="font-size: 20px; color: #777; text-align: left;">Lokacija</label><br>

                    <select  style="width: 70%; height: 30px;" id="lokacija" name="lokacija">
                            <?php
                            $baza->spojiDB();
                            $sql2 = "SELECT * FROM lokacija";

                            $rezultat2 = $baza->selectDB($sql2);


                            while ($red = mysqli_fetch_array($rezultat2)) {
                                $naz = $red['grad'];
                                $id = $red['id_lokacija'];
                                echo "<option value='$id'>$naz</option>";
                            }
                            ?>
                    </select>

                    <br>
                    <input type="text" id="naziv" name="naziv" placeholder="naziv servisa">
                    <p ></p>

                    <input type="text"  id="kontakt" placeholder="kontakt" name="kontakt">

                    <p>Dodajte sliku servisa</p><br>

                    <input type="file" name="userfile" id="logo"><br>

                    <button type="submit" id="gumb" name="submit"> Izradi novu lokaciju servisa  </button>
                </form>

            </div>

            <div id="pretraga"></div>

        </section>
        <footer  style="position: relative; margin-top: 150px;" >
            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
         
        </footer>
    </body>
</html>
