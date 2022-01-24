
<?php

if (isset($_GET['stranica']) && $_GET['stranica'] != "") {
    $page_no = $_GET['stranica'];
} else {
    $page_no = 1;
}
$total_records_per_page = 5;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Autokuce</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Prijava">
        <meta name="autor" content="Antonio Hip">
        <meta name="kljucneRijeci" content="Korisničko ime, lozinka, korisnički račun">
        <link href="../css/ahip.css" rel="stylesheet" type="text/css">
        <link href="../css/ahip_600.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style type="text/css"></style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 


    </head>
    <body>
        <header>
            <h1 class="nPrijava" style="text-align: center">Autokuce</h1>
           <?php            require '../navigacija.php'; ?>
        </header>
        <section>

            <div> <?php
                require '../baza.class.php';
                
                $veza = new Baza();
                $veza->spojiDB();
               
              
                    $upit = "SELECT * FROM korisnik limit $offset , $total_records_per_page";
               
                $rezultat = $veza->selectDB($upit);
                
                    $ukupnoServisa = $veza->selectDB("SELECT * FROM korisnik");
                
				$total_records = mysqli_num_rows($ukupnoServisa);
				$total_no_of_pages = ceil($total_records/$total_records_per_page);
				$second_last = $total_no_of_pages-1;
                              
                echo "<table class='sviservisi' border>";
                echo "<tr>";
                echo "<th>Ime</th>";
                echo "<th>Prezime</th>";
                echo "<th>Email</th>";  
                
                echo "</tr>";
                while ($red = mysqli_fetch_array($rezultat)) {
                    echo "<tr>";
                    
                    echo "<td>" . $red['ime'] . "</td>";
                    
                    echo "<td>" . $red['prezime'] . "</td>";
                    echo "<td>" . $red['email'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                ?>
            </div>
		
            <nav aria-label="pagination pagination-lg">
                    <ul class="pagination justify-content-center">
                        <li <?php
                        if ($page_no <= 1) {
                            echo "class='page-item disabled'";
                        } else {
                            echo "class='page-item'";
                        }
                        ?>>
                            <a class="page-link" <?php
                            if ($page_no > 1) {
                                
                                    echo "href='?stranica=$previous_page'";
                                
                            }
                            ?>>Prethodna</a>
                        </li>
                        <?php
                        
                            echo "<li class='page-item'><a class='page-link' href='?stranica=1'>Prva</a></li>";
                        
                        

                        if ($total_no_of_pages <= 100) {
                            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                } else {
                                    
                                        echo "<li class='page-item'><a class='page-link' href='?stranica=$counter'>$counter</a></li>";
                                   
                                }
                            }
                        }
                       
                            echo "<li class='page-item'><a class='page-link' href='?stranica={$total_no_of_pages}'>Posljednja</a></li>";
                        
                        ?>
                        <li <?php
                        if ($page_no >= $total_no_of_pages) {
                            echo "class='page-item disabled'";
                        } else {
                            echo "class='page-item'";
                        }
                        ?>>
                            <a class='page-link' <?php
                               if ($page_no < $total_no_of_pages) {
                                   
                                       echo "href='?stranica=$next_page'";
                                  
                               }
                               ?>>Sljedeća &rsaquo;&rsaquo;</a>
                        </li>
                    </ul>
                </nav>

        </section>
        <footer  style="position: relative; margin-top: 150px;" >
            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>
            <img src="../multimedija/CSS3.png" height="50" width="50" alt="CSSikona" />
            <img src="../multimedija/HTML5.png" height="50" width="50" alt="HTMLikona"/>
            <p>Zadnja promjena: 28.3.2019. 22:50 </p>  
        </footer>
    </body>
</html>
