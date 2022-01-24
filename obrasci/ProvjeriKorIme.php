<?php
require '../baza.class.php';
if(isset($_POST["korisnicko_ime"]))
{
    
        $veza = new Baza();
        $veza->spojiDB();

        $korime = $_POST['korisnicko_ime'];
       


        $upit = "SELECT *FROM korisnik WHERE "
                . "korisnicko_ime='{$korime}'";
        $rezultat = $veza->selectDB($upit);
            
        
        
        $red=mysqli_num_rows($rezultat);


       if($korime==""){
           echo '<p></p>';
       }
       if($red>0 && $korime!=""){
           echo '<p style="color: red;" >Zauzeto!</p>';
       }
       if($red<1 && $korime!=""){
           echo '<p style="color:green;">Dostupno!</p>';
       }
       
         $veza->zatvoriDB();
}


?>

