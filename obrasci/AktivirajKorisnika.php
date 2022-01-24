<?php
require '../baza.class.php';
$poruka = null;
error_reporting(0);
if (isset($_GET['kljuc'])) {
    $akt = $_GET['kljuc'];

    $baza = new Baza();
    $baza->spojiDB();


    $sql = "SELECT verificiran,aktivacijski_kljuc,vrijeme_registracije,ime FROM korisnik WHERE verificiran=0 AND aktivacijski_kljuc='{$akt}' LIMIT 1";
    $rezultat = $baza->selectDB($sql);
    $red = mysqli_num_rows($rezultat);

    $zapis = mysqli_fetch_array($rezultat);
    $vrijeme_registracije = $zapis['vrijeme_registracije'];
    $verificiran = $zapis['verificiran'];
    $vr = date('Y-m-d H:i:s');
    $sada = strtotime(date('Y-m-d H:i:s'));
    $razlika = ($sada - strtotime($vrijeme_registracije)) / (60 * 60);

    $upitnik = "SELECT trajanje_emaila FROM konfiguracija";
    $ans = $baza->selectDB($upitnik);
    $vrat = mysqli_fetch_array($ans);
    $st = $vrat[0];
    
    if ($red == 1 && $verificiran == 0 && $razlika < $st) {
        $sql = "UPDATE korisnik SET verificiran='1' WHERE aktivacijski_kljuc='{$akt}'";
        $insert = $baza->updateDB($sql);

        $poruka = "Aktivacija uspješna! Možete se prijaviti." . "<br><br>" . '<ul><li><a href="prijava.php">Prijava</a></li></ul>';
    }
    if ($razlika > 7 && $verificiran == 0) {
        $poruka = "Aktivacijski link je istekao. Registrirajte se ponovo.";
    }

    if ($red == 0 || $verificiran == 1) {
        $poruka = "Već ste verificirani ili ne postoji registracija!";
    }


    $baza->zatvoriDB();
}
?>


<html>
    <head>
        <title>Registracija</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Registracija">
        <meta name="autor" content="Antonio Hip">
        <meta name="kljucneRijeci" content="Korisničko ime, registracija, korisnik">
        <link href="../css/ahip.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <header>
        </header>

        <p style="color:red; text-align: center; font-size: 28px;"><?php
echo "$poruka";
?></p>
        <footer>

        </footer>
    </body>
</html>
