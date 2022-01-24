<?php

require '../baza.class.php';

$baza = new Baza();
$baza->spojiDB();


if(isset($_POST["odabrano"])){
    $zahtjev = $_POST["odabrano"];
    
  
    
    $upit = "select i.opis_radnji, i.cijena_servisa from zahtjev_za_servis z join informacije_o_servisu i on z.informacije_o_servisu = i.id_informacije where z.id_zahtjev = '{$zahtjev}'";
    $rezultat = $baza->selectDB($upit);
    echo "<table class='sviservisi' border>";
    echo "<tr>";
    echo "<th>Opis radnji</th>";    
    echo "<th>Cijena servisa</th>";           
    echo "</tr>";
    while ($red = mysqli_fetch_array($rezultat)) {
        
        
        echo "<tr>";
        echo "<td>" . $red['opis_radnji'] . "</td>";        
        echo "<td>" . $red['cijena_servisa'] . "kn". "</td>";
        
        echo "</tr>";
        
    }
    echo "</table>";
    
  
            
}
