<ul>
    <li><a href="index.php">Autokuće</a></li>
    <li><a href="lokacijeServisi.php">Servisi</a></li>
    <?php
    error_reporting(0);
    require 'sesija.class.php';
    Sesija::kreirajSesiju();

    if (isset($_SESSION['korisnik'])) {
        echo '<li style="float:right"><a class="active" href="obrasci/odjava.php">Odjava</a></li>';
        echo "<div class='dropdown'>";
        echo '<button class="dropbtn">Zahtjevi za servis';
        echo '<i class="fa fa-caret-down"></i>';
        echo ' </button>';
        echo '<div class="dropdown-content">';
        echo '<a href="registriran/kreirajZahtjev.php">Kreiraj zahjev za servis</a>';
        echo '<a href="registriran/kreiraniZahtjevi.php">Kreirani zahjevi za servis</a>';
        echo '<a href="registriran/azurirajZahtjev.php">Ažuriraj stanje zahtjeva za servis</a>';
        echo '<a href="registriran/evidencija.php">Informacije o završenim servisima</a>';
        echo ' </div>';
        echo " </div>";
    }
    if (isset($_SESSION["korisnik"])) {
        $korisnik = Sesija::dajkorisnika();
        $uloga = $korisnik['tip'];

        if ($uloga > 1) {

            echo "<div class='dropdown'>";
            echo '<button class="dropbtn">Moderator';
            echo '<i class="fa fa-caret-down"></i>';
            echo ' </button>';
            echo '<div class="dropdown-content">';
            echo '<a href="moderator/kreirajTermin.php">Kreiranje termina</a>';
            echo '<a href="moderator/azurirajZahtjev.php">Ažuriraj zahtjev</a>';
            echo '<a href="moderator/evidencija.php">Informiraj korisnika o sevisu</a>';
            echo '<a href="administrator/kreiranjeAutokuce.php">Kreiraj autokuću</a>';
            echo '<a href="administrator/kreiranjeServisa.php">Kreiraj lokaciju servisa</a>';
            echo ' </div>';
            echo " </div>";
        }
        if ($uloga > 2) {
            echo "<div class='dropdown'>";
            echo '<button class="dropbtn">Administrator';
            echo '<i class="fa fa-caret-down"></i>';
            echo ' </button>';
            echo '<div class="dropdown-content">';
            echo '<a href="administrator/upravljanjeRacunima.php">Upravljanje korisničkim računima</a>';
            echo '<a href="administrator/konfiguracija.php">Konfiguracija sustava</a>';
            echo '<a href="administrator/upravljanjeModeratorima.php">Kreiranje i dodjela moderatora</a>';
            echo '<a href="administrator/kreiranjeAutokuce.php">Kreiraj autokuću</a>';
            echo '<a href="administrator/kreiranjeServisa.php">Kreiraj lokaciju servisa</a>';
            echo ' </div>';
            echo " </div>";
        }
    }
    if (!isset($_SESSION['korisnik'])) {
        echo '<li style="float:right"><a class="active" href="obrasci/prijava.php">Prijava</a></li>';
        echo '<li style="float:right"><a class="active" href="obrasci/registracija.php">Registracija</a></li>';
    }
    ?>

</ul>