<?php
require '../baza.class.php';


$ak="nije postavljn ak";
if(isset($_POST['ak'])){
    $ak=$_POST['ak'];
    $id=$_POST['id'];
}



    $baza = new Baza();
    $baza->spojiDB();
    
    

    if($ak==0){
        $upit="UPDATE korisnik SET autokuca_id = NULL , uloga_id = '1' WHERE id_korisnik = '{$id}'";
        echo "Moderator izbrisan";
        $insert = $baza->updateDB($upit);
    }
    else{
      
        $upit="UPDATE korisnik SET autokuca_id = '{$ak}' , uloga_id = '2' WHERE id_korisnik = '{$id}'";
        echo "Moderator promjenjen";
        $insert = $baza->updateDB($upit);
    }
    





$baza->zatvoriDB();


