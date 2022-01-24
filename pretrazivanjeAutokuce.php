<?php

require 'baza.class.php';

if (isset($_POST["unos"])) {

   
    $veza = new Baza();
    $veza->spojiDB();

    $naziv = $_POST['unos'];
    $pronaden = 1;
    if ($naziv == "") {
        $veza = new Baza();
        $veza->spojiDB();

        $upit = "SELECT * FROM autokuca order by naziv";
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat)) {
            echo '<div  class="card">';
            echo '<img class="logo" src="' . $red['logo'] . '" width="100" height="100">';
            echo '<div class="container">';
            $naziv = $red['naziv'];
            echo '<h4><b>' . $naziv . '</b></h4> ';
            echo '<div>';
            echo '<a href="informacije.php?autokuca=' . $red['id_autokuca'] . '">Informacije</a><br><br><br>';
            echo '<a href="lokacijeServisi.php?autokuca=' . $red['naziv'] . '">Lokacije servisa</a><br><br><br>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        if ($naziv !== "") {

            $upit = "SELECT * FROM autokuca WHERE naziv LIKE '$naziv%'";
            $rezultat = $veza->selectDB($upit);
            $pronaden=0;
            while ($red = mysqli_fetch_array($rezultat)) {
                echo '<div  class="card">';
                echo '<img class="logo" src="' . $red['logo'] . '" width="100" height="100">';
                echo '<div class="container">';
                $naziv = $red['naziv'];
                echo '<h4><b>' . $naziv . '</b></h4> ';
                echo '<div>';
                echo '<a href="informacije.php?autokuca=' . $red['id_autokuca'] . '">Informacije</a><br><br><br>';
                echo '<a href="proba_lokacije.php?autokuca=' . $red['naziv'] . '">Lokacije servisa</a><br><br><br>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                $pronaden = 1;
            }
         if($pronaden==0){
             echo "Nema rezultata!";
         }
        }
    }







    $veza->zatvoriDB();
}
?>

