<?php

require '../baza.class.php';

$baza = new Baza();
$baza->spojiDB();


if(isset($_POST["odabrano"])){
    $zahtjev = $_POST["odabrano"];
    
  
    
    $sql = "select status_id_status from zahtjev_za_servis where id_zahtjev = '{$zahtjev}'";
    $rezultat = $baza->selectDB($sql);
    $red = mysqli_fetch_array($rezultat);
    if($red["status_id_status"]==2 || $red["status_id_status"]==6){
          echo "<button type='submit' id='dosao' name='dosao'> Došao sam  </button>";
    }
    
  
            
}
