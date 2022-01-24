<?php
require '../baza.class.php';



$autokuca = $_POST['autokuca'];
$korisicko = $_POST['korisnicko'];
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$datum = $_POST['datum'];
$drzava = $_POST['drzava'];
$mail = $_POST['email'];
$lozinka = $_POST['lozinka'];
$kript = sha1($lozinka);
$vr = date('Y-m-d H:i:s');
$akt_kljuc = md5(time() . $korisicko);




    $baza = new Baza();
    $baza->spojiDB();
$sql = "INSERT INTO korisnik (autokuca_id,uloga_id,ime,prezime,datum_rodenja,korisnicko_ime,email,lozinka,aktivacijski_kljuc,verificiran,vrijeme_registracije,kriptirana_lozinka,drzava)"
        . " VALUES ('$autokuca','2','{$ime}','{$prezime}','{$datum}','{$korisicko}','{$mail}','{$lozinka}','{$akt_kljuc}','1','{$vr}','{$kript}','{$drzava}')";
$insert = $baza->updateDB($sql);
$baza->zatvoriDB();

if($insert){
    echo "Dodan moderator!";
}
else{
    echo "Greska";
}
