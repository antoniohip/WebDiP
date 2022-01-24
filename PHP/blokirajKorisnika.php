<?php

require '../baza.class.php';

$baza = new Baza();
$baza->spojiDB();

if (isset($_POST["id"])) {
    $id = $_POST['id'];
    $sql="SELECT * FROM korisnik WHERE id_korisnik='{$id}'";
    $rezultat = $baza->selectDB($sql);
    $postoji= mysqli_num_rows($rezultat);
    
    if ($id != "" && $postoji!=0) {
        $radi = $_POST['odabrano2'];
        if ($radi == "blokiraj") {
            $sql = "UPDATE korisnik SET broj_pokusaja='99' WHERE id_korisnik='{$id}'";
            $rezultat = $baza->updateDB($sql);
            echo "Blokirali ste korisnika čiji ID je "."$id".".";
        }
        if ($radi == "odblokiraj") {
            $sql = "UPDATE korisnik SET broj_pokusaja='0' WHERE id_korisnik='{$id}'";
            $rezultat = $baza->updateDB($sql);
            echo "Odblokirali ste korisnika čiji ID je "."$id".".";
        }
    } else {
        echo "Niste unjeli id ili ne postoji korisnik!";
    }
} else {
    echo "Niste unjeli id ili ne postoji korisnik!";
}
    
    
    
    
    
    
    
    
    
    
    
    
    
    




