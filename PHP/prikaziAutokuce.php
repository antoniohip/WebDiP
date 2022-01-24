<?php

require '../baza.class.php';
$baza = new Baza();
$baza->spojiDB();
$sql = "select * from autokuca";
$rezultat = $baza->selectDB($sql);
$a="../";
while ($red = mysqli_fetch_array($rezultat)) {
        
        echo "<tr>";
        echo "<td>" . $red['id_autokuca'] . "</td>";        
        echo "<td>" . $red['naziv'] . "</td>";
        echo "<td>" . '<img class="servisi" src="' . $a. $red['logo'] . '" width="100" height="100" >' . "</td>";
        echo "<td>" . $red['informacije'] . "</td>";
        echo "</tr>";
    }




$baza->zatvoriDB();
