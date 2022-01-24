

<html>
    <head>
        <title>Autokuce</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Prijava">
        <meta name="autor" content="Antonio Hip">
        <meta name="kljucneRijeci" content="Korisničko ime, lozinka, korisnički račun">
        <link href="css/ahip.css" rel="stylesheet" type="text/css">
        <link href="css/ahip_600.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style type="text/css"></style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 


    </head>
    <body>
        <?php
        if (isset($_GET["autokuca"])) {
            $autokuca = $_GET["autokuca"];
            require 'baza.class.php';
            $baza = new Baza();
            $baza->spojiDB();
            $upit = "SELECT informacije FROM autokuca where id_autokuca='{$autokuca}'";
            $rezultat = $baza->selectDB($upit);
            $red = mysqli_fetch_array($rezultat);
            echo "<p>". $red['informacije']. "</p>";
        }
     
        ?>
        

        <footer  style="position: relative; margin-top: 150px;" >
            <address><strong>Kontakt: <a href="mailto:ahip@foi.hr">ahip@foi.hr</a></strong></address>
            <p><strong>&copy; 2019 Antonio Hip</strong></p>

        </footer>
    </body>
</html>
