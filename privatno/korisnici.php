<?php 
require'../baza.class.php';
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <table class="table" id="LokacijeServisa">
            <thead>
                <tr>
                    <th>
                        Ime
                    </th>
                    <th>
                        Prezime
                    </th>
                    <th>
                        Korisnicko ime
                    </th>
                    <th>
                        Lozinka
                    </th>
                </tr>
            </thead>
            <tbody id="podaciTablice">
                <?php
                $baza = new Baza();
                $baza->spojiDB();
                $upit = "SELECT * FROM korisnik";
                $rezultat = $baza->selectDB($upit);
                while ($rez = mysqli_fetch_array($rezultat)) {
                    echo'<tr>';
                    echo"<td>{$rez["ime"]}</td>";
                    echo"<td>{$rez["prezime"]}</td>";
                    echo"<td>{$rez["korisnicko_ime"]}</td>";
                    echo"<td>{$rez["lozinka"]}</td>";
                    echo'</tr>';
                }
                ?>  
            </tbody>
        </table>
    </body>
</html>