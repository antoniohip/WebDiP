<?php

require '../baza.class.php';

$baza = new Baza();
$baza->spojiDB();

$upitnik = "SELECT str_servisi FROM konfiguracija";
$ans = $baza->selectDB($upitnik);
$vrat = mysqli_fetch_array($ans);
$st=$vrat[0];
$total_records_per_page = $st;


if (isset($_POST["txtbox"])) {
    $string = $_POST["txtbox"];

    if ($string == "") {
        $sql = $sql = "SELECT s.slika, s.naziv_servisa, s.kontakt, a.naziv, a.logo, l.grad FROM servis s join autokuca a ON a.id_autokuca = s.autokuca_id JOIN lokacija l ON l.id_lokacija = s.lokacija_id";
    } else {
        $sql = $sql = "SELECT s.slika, s.naziv_servisa, s.kontakt, a.naziv, a.logo, l.grad FROM servis s join autokuca a ON a.id_autokuca = s.autokuca_id JOIN lokacija l ON l.id_lokacija = s.lokacija_id WHERE a.naziv LIKE '$string%' OR s.naziv_servisa LIKE '$string%' OR l.grad LIKE '$string%'";
    }
    $rezultat4 = $baza->selectDB($sql);
    $brojZapisa = mysqli_num_rows($rezultat4);

    $brojStranica = ceil($brojZapisa / $total_records_per_page);


    if (!isset($_POST["str"])) {
        $redniBrojStranice = 1;
    } else {
        $redniBrojStranice = $_POST["str"];
    }
    
    if (!isset($_POST['stupac'])) {
        $stupac = 'naziv_servisa';
    } else {
        $stupac = $_POST['stupac'];
    }


    if (!isset($_POST['smjer'])) {
        $smjer = 'DESC'; 
    } else {
        $smjer = $_POST['smjer'];
    }

    $smjer == 'ASC' ? $smjer = 'DESC' : $smjer = 'ASC';
   
        
    

    $prviZapis = ($redniBrojStranice - 1) * $total_records_per_page;

    if ($string == "") {
        $sql = "SELECT s.slika, s.naziv_servisa, s.kontakt, a.naziv, a.logo, l.grad FROM servis s join autokuca a ON a.id_autokuca = s.autokuca_id JOIN lokacija l ON l.id_lokacija = s.lokacija_id order by $stupac $smjer LIMIT $prviZapis, $total_records_per_page";
    } else {
        $sql = "SELECT s.slika, s.naziv_servisa, s.kontakt, a.naziv, a.logo, l.grad FROM servis s join autokuca a ON a.id_autokuca = s.autokuca_id JOIN lokacija l ON l.id_lokacija = s.lokacija_id WHERE a.naziv LIKE '$string%' OR s.naziv_servisa LIKE '$string%' OR l.grad LIKE '$string%' order by $stupac $smjer LIMIT $prviZapis, $total_records_per_page";
    }
    $rezultat = $baza->selectDB($sql); 


    echo "<table bgcolor='#a0a0a0'  class='sviservisi' border>";
    echo "<tr>";
    echo "<th>Slika</th>";
    echo "<th><a class='sort' id='naziv_servisa' data-order='" . $smjer . "' href='#'>Naziv</a></th>";    
    echo "<th><a class='sort' id='grad' data-order='" . $smjer . "' href='#'>Grad</a></th>";
    echo "<th><a class='sort' id='kontakt' data-order='" . $smjer . "' href='#'>Kontakt</a></th>";
    echo "</tr>";
    while ($red = mysqli_fetch_array($rezultat)) {
        
        echo "<tr>";
        echo "<td>" . '<img class="servisi" src="' . $red['slika'] . '" >' . "</td>";
        echo "<td>" . $red['naziv_servisa'] . "</td>"; 
        /*if ($id == 0) {
            echo "<td>" . '<img  src="' . $red3['logo'] . '"  width="100" height="100">' . "</td>";
        } */
        echo "<td>" . $red['grad'] . "</td>";
        echo "<td>" . $red['kontakt'] . "</td>";
        echo "</tr>";
        
    }
    echo "</table>";




    echo '<div class="pagination" style="clear:both">';

    $redniBrojStranice == $brojStranica ? $sljedeci = $brojStranica : $sljedeci = $redniBrojStranice  + 1;
    $redniBrojStranice  == 1 ? $prethodni = $redniBrojStranice  : $prethodni = $redniBrojStranice  - 1;
    for ($i = 1; $i <= $brojStranica; $i++) {
        if ($i == 1) {
            echo '<button class="pagination_link" type="button" id="first" value="' . $i . '" > &laquo; </button>';
            echo '<button class="pagination_link" type="button" id="prev" value="' . $prethodni . '" > Prethodna </button>';
        }
        echo '<button class="pagination_link" value="' . $i . '"  type="button" id="first" > ' . $i . ' </button>';
        if ($i == $brojStranica) {
            echo '<button class="pagination_link" type="button" id="next" value="' . $sljedeci . '" > Sljedeca </button>';
            echo '<button class="pagination_link" type="button" id="last" value="' . $i . '" > &raquo; </button>';
        }
    }
    echo '</div>'; 
            
} 

