<?php
require '../baza.class.php';
error_reporting(0);
require '../sesija.class.php';
$poruka = null;
if (isset($_POST["submit"])) {
    //var_dump($_POST);
    $greska = "";

    if (empty($greska)) {
        echo 'Povezivanje na bazu!';
        echo '<br><br>';
        $veza = new Baza();
        $veza->spojiDB();
        $upitnik = "SELECT broj_neuspjelih FROM konfiguracija";
        $ans = $veza->selectDB($upitnik);
        $vrat = mysqli_fetch_array($ans);
        $st = $vrat[0];
        
        

        $korime = $_POST['korime'];
        $lozinka = $_POST['lozinka'];


        $upit = "SELECT * FROM korisnik WHERE "
                . "korisnicko_ime='{$korime}' AND "
                . "lozinka='{$lozinka}'";
        $rezultat = $veza->selectDB($upit);


        $autenticiran = false;


        while ($red = mysqli_fetch_array($rezultat)) {

            if ($red) {
                $autenticiran = true;
                $tip = $red['uloga_id'];
                $verificiran = $red['verificiran'];
            }
            // var_dump($red);
            // echo $red['uloga_id'];
        }
        $upit = "SELECT * FROM korisnik WHERE "
                . "korisnicko_ime='{$korime}'";
        $rezultat1 = $veza->selectDB($upit);
        $zapis = mysqli_fetch_array($rezultat1);
        $broj_pokusaja = $zapis['broj_pokusaja'];

        if (!$autenticiran) {

            $broj_pokusaja = $broj_pokusaja + 1;
            $sql = "UPDATE korisnik SET broj_pokusaja='{$broj_pokusaja}' WHERE korisnicko_ime='{$korime}'";
            $insert = $veza->updateDB($sql);
            $poruka = "Unjeli ste pogrešno korisničko ime ili lozinku!";
        }
        if ($autenticiran && $verificiran == 0) {
            $poruka = "Niste potvrdili registraciju!";
        }
        if (!$autenticiran && $broj_pokusaja >= $st ) {
            $poruka = "Unjeli ste pogrešnu lozinku ".$st." puta zaredom, vaš korisnički račun je zaključan";
        }
        if ($autenticiran && $verificiran == 1 && $broj_pokusaja < $st) {
            $sql = "UPDATE korisnik SET broj_pokusaja='0' WHERE korisnicko_ime='{$korime}'";
            $insert = $veza->updateDB($sql);
            Sesija::kreirajKorisnika($korime, $tip);
            $value = $korime;
            $upitnik = "SELECT trajanje_kolacica FROM konfiguracija";
            $ans = $veza->selectDB($upitnik);
            $vrat = mysqli_fetch_array($ans);
            $st = $vrat[0];

            setcookie("uloga", $tip, time() + $st);
            setcookie("korisnik", $value, time() + $st);
            setcookie("uloga", $tip, time() + $st);
            header("location: uspjeh.php");
        }
        if ($autenticiran && $verificiran == 1 && $broj_pokusaja >= $st) {
            $poruka = "Vaš korisnički račun je zaključan!";
        }

        $veza->zatvoriDB();
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
        <title>Prijava</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Prijava">
        <meta name="autor" content="Antonio Hip">
        <meta name="kljucneRijeci" content="Korisničko ime, lozinka, korisnički račun">
        <link href="../css/ahip.css" rel="stylesheet" type="text/css">
        <link href="../css/ahip_600.css" rel="stylesheet" type="text/css">

        <style type="text/css"></style>
    </head>
    <body>
        <header>
            <h1 class="nPrijava" style="text-align: center">Prijava</h1>

            <?php if (isset($greska)) { ?>

                <?php
                echo $greska;
                ?>


            <?php } ?>

            <ul>
                <li><a href="../index.php">Autokuće</a></li>
                <li><a href="../lokacijeServisi.php">Servisi</a></li>
                <li style="float:right"><a class="active" href="prijava.php">Prijava</a></li>
                <li style="float:right"><a class="active" href="registracija.php">Registracija</a></li>
            </ul>


        </header>
        <section>

            <form novalidate class="prijava" id="form1" method="post" name="form1"  action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <h1 style="font-size: 25px">Prijavi se</h1>
                <div class="unos">
                    <input type="text" name="korime" placeholder="korisničko ime" size="20" maxlength="20" autofocus="autofocus" 
                    <?php
                    if (isset($_COOKIE["korisnik"])) {
                        $kor = $_COOKIE["korisnik"];

                        echo "value='$kor'";
                    }
                    ?> required="required" >
                </div>
                <div class="unos">
                    <input type="password" name="lozinka" placeholder="lozinka"  required="required">
                </div>
                <input style="margin-left: 10px;" type="checkbox" name="zapamti me" value="1" checked> Upamti korisničko ime<br>
                <input class="prijavagumb" type="submit" name="submit" value="Prijava" >
                <p style="margin-top: 15px" >Zaboravio si lozinku? <a href="ZaboravljenaLozinka.php">Zatraži novu lozinku</a> </p>     


            </form>
            <p style="color:red; text-align: center; font-size: 28px;"><?php
                echo "$poruka";
                ?></p>
            <div style="margin-left: 20px;">
                <h1>Kor.ime, Lozinka</h1>
                <h1>korisnik, korisnik</h1>
                <h1>moderator, moderator</h1>
                <h1>admin, admin</h1>

            </div>

        </section>
        <footer  style="position: relative; margin-top: 150px;" >

            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
        
        </footer>

    </body>
</html>
