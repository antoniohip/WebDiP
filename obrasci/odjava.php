<?php
error_reporting(0);
require("../sesija.class.php");
Sesija::kreirajSesiju();
if (isset($_SESSION["korisnik"])) {
   
    Sesija::obrisiSesiju();
    echo "Uspješna odjava!";
     header("refresh:3; url=../index.php");
}
?>
