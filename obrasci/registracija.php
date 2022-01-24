<?php
require '../baza.class.php';
error_reporting(0);
$poruka = null;

if (isset($_POST["submit"])) {
    $secretKey = "6Lc89qYUAAAAAJfNdhKwSmc0udlmXPpbUjZKte8h";

    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
    $responese = file_get_contents($url);
    $odgovor = json_decode($responese);
    if ($odgovor->success) {
        $korime = $_POST['korime'];
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $email = $_POST['email'];
        $lozinka = $_POST['lozinka1'];
        $drzava = $_POST['drzava'];
        $datum = $_POST['datum'];
        $kript = sha1($lozinka);
        $akt_kljuc = md5(time() . $korime);
        $vrijeme = time();
        $vr = date('Y-m-d H:i:s');
        $baza = new Baza();
        $baza->spojiDB();
        $sql = "INSERT INTO korisnik (uloga_id,ime,prezime,datum_rodenja,korisnicko_ime,email,lozinka,aktivacijski_kljuc,verificiran,vrijeme_registracije,kriptirana_lozinka,drzava)"
                . " VALUES ('1','{$ime}','{$prezime}','{$datum}','{$korime}','{$email}','{$lozinka}','{$akt_kljuc}','0','{$vr}','{$kript}','{$drzava}')";
        $insert = $baza->updateDB($sql);
        $baza->zatvoriDB();

        if ($insert) {
            $to = $email;
            $subject = "Molimo Vas potvrdite email";
            $message = "<a href='http://barka.foi.hr/WebDiP/2018_projekti/WebDiP2018x049/obrasci/AktivirajKorisnika.php?kljuc=$akt_kljuc'>Potvrdite email</a>";
            $headers = "From: info@autokuce.hr \r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail($to, $subject, $message, $headers);
            header('location:PoslanMail.php');
        } else {
            $poruka = "Došlo je do greške, pokušajte ponovo!";
        }
    }else{
        $po="Nije dokazano da niste robot!";
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
        <title>Registracija</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Registracija">
        <meta name="autor" content="Antonio Hip">
        <meta name="kljucneRijeci" content="Korisničko ime, registracija, korisnik">
        <link href="../css/ahip.css" rel="stylesheet" type="text/css">
        <link href="../css/ahip_600.css" rel="stylesheet" type="text/css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="text/javascript" src="../js/provjeriRegistraciju.js"></script>


        <style type="text/css"></style>



        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 

        <script>
            $(document).ready(function () {
                $("#submit").prop("disabled", true);
                var greska1 = 1;
                var greska2 = 1;
                var greska3 = 1;
                var greska4 = 1;
                var greska5 = 1;
                var greska6 = 1;
                $('#korime').blur(function () {
                    var korime = $(this).val();

                    $.ajax({
                        url: "ProvjeriKorIme.php",
                        method: "POST",
                        data: {korisnicko_ime: korime},
                        dataType: "text",
                        success: function (html)
                        {
                            $('#korimeDostupnost').html(html);
                        }
                    });
                });
            });
        </script>


    </head>
    <body>
        <header>
            <h1 class="nRegistracija" style="text-align: center">Registracija</h1>
            <ul>
                <li><a href="../index.php">Autokuće</a></li>
                <li><a href="../lokacijeServisi.php">Servisi</a></li>
                <li style="float:right"><a class="active" href="prijava.php">Prijava</a></li>
                <li style="float:right"><a class="active" href="registracija.php">Registracija</a></li>
            </ul>

        </header>

        <form novalidate class="registracija" id="form1" method="post" name="form1"   action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <h1 style="font-size: 25px">Registriraj se</h1>
            <div class="unos">
                <input type="text" onchange="provjeri_korime()" id="korime" name="korime" size="15" maxlength="20"  placeholder="korisničko ime" autofocus="autofocus"><br>
            </div>
            <p id="korimeDostupnost" style="margin-bottom: 0px;"></p>

            <div class="unos">
                <input placeholder="ime" onchange="provjeri_ime()" id="ime"  name="ime" ></input>
            </div>



            <div class="unos">
                <input placeholder="prezime" onchange="provjeri_prezime()" id="prezime" style="width: 100%;" name="prezime" ></input>
            </div>

            <div class="unos">
                <input placeholder="Datum rođenja" onchange="provjeri_datum()"type="text" onfocus="(this.type = 'date')" id="datum" name="datum" required="required"> 
            </div>
            <div class="unos">
                <label style="font-size: 20px; color: #777">Država</label>
                <select  style="width: 100%" id="drzava" name="drzava">
                    <option value="hrvatska" selected="selected">Hrvatska</option>
                    <option value="slovenija">Slovenija</option>
                    <option value="austrija">Austrija</option>
                    <option value="ostalo">Ostalo</option>
                </select>
            </div>
            <div id="mail" class="unos">
                <input  onchange="provjeri_mail()" type="email" id="email" name="email" size="35" maxlength="35" placeholder="ime.prezime@posluzitelj.xxx" required="required"><br>
            </div>
            <div class="unos">
                <input type="password" onchange="provjeri_lozinku()"id="lozinka1" name="lozinka1" size="15" maxlength="15"  placeholder="lozinka" ><br>
            </div>
            <div id="loz2" class="unos">
                <input  type="password" onchange="provjeri_match()"id="lozinka2" name="lozinka2" size="15" maxlength="15"  placeholder="lozinka" ><br> 
            </div>

            <div class="g-recaptcha" data-sitekey="6Lc89qYUAAAAALNImeD3NyF8HCAB0eRhP5xQfGA5"></div>

            <input class="regumb" name="submit" id="submit" type="submit" value=" Registriraj se ">         
        </form>

        <p style="color:red; text-align: center; font-size: 28px;"><?php
echo "$poruka"; if(isset($po)){echo "$po";}
?></p>
    </section>
    <footer style="position: relative; margin-top: 150px;" class="regfo">

        <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
        <p><strong>&copy; 2019 Antonio Hip</strong></p>
 
    </footer>

</body>
</html>



