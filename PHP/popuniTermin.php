<?php

require '../baza.class.php';

$baza = new Baza();
$baza->spojiDB();


if(isset($_POST["pocetak"])){
    $id = $_POST["pocetak"];
    $sql = "select datum_i_vrijeme_pocetka from termin where id_termin = '{$id}'";
    $rezultat = $baza->selectDB($sql);
    $red = mysqli_fetch_array($rezultat);
    echo $red['datum_i_vrijeme_pocetka'];
            
}

if(isset($_POST["zavrsetak"])){
    $id = $_POST["zavrsetak"];
    $sql = "select datum_i_vrijeme_zavrsetka from termin where id_termin = '{$id}'";
    $rezultat = $baza->selectDB($sql);
    $red = mysqli_fetch_array($rezultat);
    echo $red['datum_i_vrijeme_zavrsetka'];
            
}
if(isset($_POST["broj"])){
    $id = $_POST["broj"];
    $sql = "select broj_mjesta from termin where id_termin = '{$id}'";
    $rezultat = $baza->selectDB($sql);
    $red = mysqli_fetch_array($rezultat);
    echo $red['broj_mjesta'];
            
}
if(isset($_POST["slika"])){
    $id = $_POST["slika"];
    $sql = "select slika from termin where id_termin = '{$id}'";
    $rezultat = $baza->selectDB($sql);
    $red = mysqli_fetch_array($rezultat);
    $a="../";
    echo "<p>Slika: </p><br>";
    echo '<img class="logo" src="' . $a . $red['slika'] . '" width="100" height="100">';
            
}
$baza->zatvoriDB();


