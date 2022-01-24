<?php
error_reporting(0);
require '../sesija.class.php';
Sesija::kreirajSesiju();
if (!isset($_SESSION["korisnik"])) {
    header("refresh:0; url=../obrasci/neovlasteno.php");
}

if (isset($_GET['stranica']) && $_GET['stranica'] != "") {
    $page_no = $_GET['stranica'];
} else {
    $page_no = 1;
}
$stranicenje = 2;
$total_records_per_page = 2;
$offset = ($page_no - 1) * $total_records_per_page;
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
        <link href="../css/ahip.css" rel="stylesheet" type="text/css">
        <link href="../css/ahip_600.css" rel="stylesheet" type="text/css">
        <link href="../css/formaModerator.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/moderatori.js"></script>
        <script type="text/javascript" src="../js/dodajModeratora.js"></script>

        <style type="text/css"></style>
        <script>
            $(document).ready(function () {
                $('#kim').blur(function () {
                    var korime = $(this).val();

                    $.ajax({
                        url: "../obrasci/ProvjeriKorIme.php",
                        method: "POST",
                        data: {korisnicko_ime: korime},
                        dataType: "text",
                        success: function (html)
                        {
                            $('#re').html(html);
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
        <div>
            <select name="selection" id="odabir" form="carform">
                <option id="svi" name="svi" value="svi">Svi korisnici</option>
                <option id="blokirani" selected="selected" name="blokirani" value="moderatori">Moderatori</option>                
            </select>
            <input type="text" name="search" id="search" placeholder="trazi" >
        </div>
        <div id="rezultat"></div>
        <br>
        <br>
        <hr>
        <h3>Pridružite moderatoru autokuću/pretvorite korisnika u moderatora</h3>
        <p>*Ako pridružite autokuću običnom korisniku, postat će moderator odabrane autokuće</p><br>
        <p>*Ako moderatoru obrišete autokuću, postat će obični korisnik</p>
        
        <label style="font-size: 20px; color: #777; text-align: left;">Autokuca</label><br>
                <select  style="width: 20%; margin-left: 20px; height: 30px;" id="ak" name="ak">
                    <?php
                    require '../baza.class.php';
                    $baza = new Baza();
                    $baza->spojiDB();
                    $sql1 = "SELECT * FROM autokuca";

                    $rezultat1 = $baza->selectDB($sql1);


                    while ($red = mysqli_fetch_array($rezultat1)) {
                        $naz = $red['naziv'];
                        $id = $red['id_autokuca'];
                        echo "<option value='$id'>$naz</option>";
                    }
                    echo "<option value='0'>Obirši autokuću</option>";
                    ?>
                </select>
        <input id="idkorisnika" value="" name="idkorisnika" placeholder="id korisnika">
        <input type="submit" value="Primjerni" id="gumb1">
        <p id="rezultat3"></p>
        
        <hr>
        <h3>Dodajte moderatora</h3>
        <div style="text-align: center;" class="in" class="container">
            <form id="formamod" name="formamod" novalidate>

                <label style="font-size: 20px; color: #777; text-align: left;">Autokuca</label><br>
                <select  style="width: 70%; height: 30px;" id="autokuca" name="autokuca">
                    <?php
                    
                    
                    $baza->spojiDB();
                    $sql = "SELECT * FROM autokuca";

                    $rezultat = $baza->selectDB($sql);


                    while ($red = mysqli_fetch_array($rezultat)) {
                        $naz = $red['naziv'];
                        $id = $red['id_autokuca'];
                        echo "<option value='$id'>$naz</option>";
                    }
                    ?>
                </select>
                <br>
                <input type="text" id="kim" name="kim" placeholder="korisničko ime">
                <p id='re'></p>


                <input type="text" id="name" name="name" value=""  placeholder="ime" >


                <input type="text" id="prez" name="prez" value=""  placeholder="prezime">

                <input placeholder="Datum rođenja" type="text" onfocus="(this.type = 'date')" id="datum" name="datum" required="required"> 
                <br>
                <label style="font-size: 20px; color: #777;text-align: left;">Država</label><br>
                <select  style="width: 70%;height: 30px;" id="drzava" name="drzava">
                    <option value="hrvatska" selected="selected">Hrvatska</option>
                    <option value="slovenija">Slovenija</option>
                    <option value="austrija">Austrija</option>
                    <option value="ostalo">Ostalo</option>
                </select>

                <input  type="email" id="email" name="email" size="35" maxlength="35" placeholder="ime.prezime@posluzitelj.xxx" required="required"><br>

                <input type="password" id="lozinka1" name="lozinka1" size="15" maxlength="15"  placeholder="lozinka" ><br>

                <input  type="password" id="lozinka2" name="lozinka2" size="15" maxlength="15"  placeholder="lozinka" ><br> 

                <input class="dodaj" id="gumb" style=" background-color: #4CAF50;
                       color: white;
                       padding: 12px 20px;
                       border: none;
                       border-radius: 4px;
                       cursor: pointer;" value="Kreiraj moderatora">
            </form>

        </div>


        <br>
        <div id="rezultat2"></div>

        <footer  style="position: relative; margin-top: 150px;" >
            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
 
        </footer>
    </body>
</html>
