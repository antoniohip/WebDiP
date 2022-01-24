<?php
require '../baza.class.php';
error_reporting(0);
$poruka=null;
if (isset($_POST["korime"])) {

    $veza = new Baza();
    $veza->spojiDB();

    $korime = $_POST['korime'];



    $upit = "SELECT *FROM korisnik WHERE "
            . "korisnicko_ime='{$korime}'";
    $rezultat = $veza->selectDB($upit);


    $red = mysqli_num_rows($rezultat);
    $zapis = mysqli_fetch_array($rezultat);
    $email=$zapis['email'];

    if ($red > 0 && $korime != "") {
        $nova = substr(md5(mt_rand()), 0, 7);
        $sql = "UPDATE korisnik SET lozinka='{$nova}' WHERE korisnicko_ime='{$korime}'";
        $insert = $veza->updateDB($sql);
        if ($insert) {
            $to = $email;
            $subject = "Zatrazili ste novu lozinku";
            $message = "Vasa nova lozinka je: "."$nova";
            $headers = "From: info@autokuce.hr \r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail($to, $subject, $message, $headers);

            $poruka="Na vaš email "."$email"." poslali smo novu lozinku!";
        }
    }
    if ($red < 1 && $korime != "") {
        $poruka="Ne postoji korisnik s unešenim korisničkim imenom!";
    }

    $veza->zatvoriDB();
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





            <nav>
                <ul>
                    <li><a href="../index.php">Početna stranica</a></li>
                    <li><a href="prijava.php">Prijava</a></li>
                    <li><a href="registracija.php">Registracija</a></li>
                    <li><a href="obrazac.php">Obrazac</a></li>
                    <li><a href="../ostalo/popis.php">Popis</a></li>  
                    <li><a href="../ostalo/multimedija.php">Multimedija</a></li>         
                </ul>
            </nav>

        </header>
        <section>

            <form novalidate class="prijava" id="form1" method="post" name="form1"  action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <h1 style="font-size: 25px">Zaboravljena lozinka</h1>
                <p>Generirat će vam se nova lozinka i bit će poslana na vašu email adresu.</p>
                <div class="unos">
                    <input type="text" name="korime" placeholder="korisničko ime" size="20" maxlength="20" autofocus="autofocus" required="required" >
                </div>

                <input class="prijavagumb" type="submit" name="submit" value="Pošalji lozinku" >

            </form>
             <p style="color:red; text-align: center; font-size: 28px;"><?php
            echo "$poruka";
            ?></p>



        </section>
        <footer  style="position: relative; margin-top: 150px;" >

            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
      
        </footer>

    </body>
</html>

