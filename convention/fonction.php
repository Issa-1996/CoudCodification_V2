<?php
include('../personnels/connect.php');

require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
$i = 1;
if ($connexion) {
    $req1 = "SELECT * FROM `personne`";
    if ($result = mysqli_query($connexion, $req1)) {
        while ($row = mysqli_fetch_array($result)) {
            if(count($row)<=12){
                $q = "true";
            }else{
                $q = "none";
            }
            // for ($j = 0; $j < $result->rowCount(); $j++) {
            //     # code...
            //     if ($j > 10) {
            //         $l = "<div class='breakafter'></div>";
            //         $i = $i + 1;
            //         break;
            //     }
            // }
            return $row;

        }
    }
}

function liste()
{
    include('../personnels/connect.php');
    $req1 = "SELECT * FROM `personne`";
    if ($result = mysqli_query($connexion, $req1)) {
        return "Nous avons " . $result . "enregistrements </br>";
    }
}