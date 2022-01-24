<?php

require '../baza.class.php';

$baza = new Baza();
$baza->spojiDB();



if (isset($_POST["odabrano"])) {
    $servis = $_POST["odabrano"];
  
    $sql = "select s.id_servis, s.naziv_servisa,a.naziv, s.autokuca_id,t.naziv as 'naziv_termina',t.id_termin,t.broj_mjesta from servis s join termin t on s.id_servis = t.servis_id join autokuca a on s.autokuca_id=a.id_autokuca where s.id_servis = '{$servis}' and t.broj_mjesta > '0'";

    $rezultat = $baza->selectDB($sql);




    echo '<option selected="selected">Odaberite termin...</option>';
    while ($red = mysqli_fetch_array($rezultat)) {
        $naz = $red['naziv_termina'];
        $id = $red['id_termin'];
        echo "<option value='$id'>$naz</option>";
    }

 
}
else{
    echo "nisam dobil nis!";
}

// ovaj decko roka van select za termine. to sve izgleda ovak: 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

   

  

    



