<?php
$dozvoljeniNazivDatoteke = "/(^([A-Za-z0-9]){1,20})\.([a-z0-9]){2,3}$/";
$userfile = $_FILES['userfile']['tmp_name'];
$userfile_name = $_FILES['userfile']['name'];
$userfile_size = $_FILES['userfile']['size'];
$userfile_type = $_FILES['userfile']['type'];
$userfile_error = $_FILES['userfile']['error'];
if ($userfile_error > 0) {
    echo 'Problem: ';
    switch ($userfile_error) {
        case 1: echo 'Veličina veća od ' . ini_get('upload_max_filesize');
            break;
        case 2: echo 'Veličina veća od ' . $_POST["MAX_FILE_SIZE"] . 'B';
            break;
        case 3: echo 'Datoteka djelomično prenesena';
            break;
        case 4: echo 'Datoteka nije prenesena';
            break;
    }
    exit;
}
if(!preg_match($dozvoljeniNazivDatoteke, $userfile_name)){
        echo'Nedozvoljeni naziv datoteke!';
        exit;
    }
if (($userfile_type == 'image/jpeg' || $userfile_type == 'image/png') && $userfile_type > 250000)
    exit;
$upfile = '../multimedija/termin/' . $userfile_name;
if ($userfile_type == 'image/jpeg' || $userfile_type == 'image/png' || $userfile_type == 'audio/mpeg3' || $userfile_type == 'video/mpeg') {
    if (is_uploaded_file($userfile)) {
        if (!move_uploaded_file($userfile, $upfile)) {
            echo 'Problem: nije moguće prenijeti datoteku na odredište';
            exit;
        }
    } else {
        echo 'Problem: mogući napad prijenosom. Datoteka: ' . $userfile_name;
        exit;
    }

    echo 'Datoteka uspješno prenesena<br /><br />';
}
?>