<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
//connexion à la base de données
require('../personnels/connect.php');

//Information du lit
$i = 0;
$lit = $_SESSION['lit_choisi'];
$requeteLit = "SELECT * FROM `codif_lit` WHERE `id_lit`='$lit'";
$resultRequeteLit = mysqli_query($connexion, $requeteLit);
while ($row = mysqli_fetch_array($resultRequeteLit)) {
    $tab[$i] = $row;
    $i++;
}

$idLit = $_SESSION['lit_choisi'];
$requeteDateLit = "SELECT * FROM `affectation` WHERE `id_lit`='$idLit'";
$resultRequeteDateLit = mysqli_query($connexion, $requeteDateLit);
while ($row = mysqli_fetch_array($resultRequeteDateLit)) {
    $dateLit= $row;
}
$_SESSION['pavillon'] = $tab[0]['pavillon'];
$_SESSION['campus'] = $tab[0]['campus'];
$_SESSION['chambre'] = $tab[0]['chambre'];
// print_r($tab[0]);
?>
<?php
print_r("teste 1\n");
include('fonction.php');
$prenom = $_SESSION['prenom'];
$nom = $_SESSION['nom'];
$lit = $_SESSION['lit_choisi'];
$chambre = $_SESSION['chambre'];
$campus = $_SESSION['campus'];
$pavillon = $_SESSION['pavillon'];
$dateNaissance = $_SESSION['dateNaissance'];
$lieuNaissance = $_SESSION['lieuNaissance'];
$sexe = $_SESSION['sexe'];
$nationalite = $_SESSION['nationalite'];
$niveau = $_SESSION['niveau'];
$num_etu = $_SESSION['num_etu '];
$etablissement = $_SESSION['etablissement'];


$pdfcontent = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <header>
                <div class="row">
                    <div class="col-md-6">
                        <p>Ministére de l\'Enseignement<br>Supérieur et de la Recherche <br/>
                            <u>________________________</u><br/>
                            <b> CENTRE DES ŒUVRES UNIVERSITAIRES DE DAKAR</b>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="data-room">
                            N° Chambre : <b>' . $chambre . '</b><br>
                            Pallion : <b>' . $pavillon . '</b><br>
                            Campus : <b>' . $campus . '</b><br>
                            Caution : <br> 
                            Taux / Mois : 
                        </div>
                    </div>
                    <h4>N°:________________________________</h4>
                </div>                
            </header>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        CONVENTION D\'HEBERGEMENT
                    </div>
                    <h6>ANNEE UNIVERSITAIRE '.date("Y")-1 .'/'.date("Y"). '</h6> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Prénoms (s) : ..............<b>' . $prenom . '</b>.....................</label>
                    <label>Nom : ......................<b>' . $nom . '</b>.....................</label>
                </div><br/>
                <div class="col-md-12">
                    <label>Date de naissance : ....<b>' . $dateNaissance . '</b>.......................</label>
                    <label>Lieu : .....................<b>' . $lieuNaissance . '</b>....................</label>
                </div><br/>
                <div class="col-md-12">
                    <label>Nationalité : ................<b>' . $nationalite . '</b>.....................</label>
                    <label>Bourse : .....................................</label>
                </div><br/>
                <div class="col-md-12">
                    <label>Faculté : ......................<b>' . $etablissement . '</b>.........................</label>
                    <label>Niveau : ..................<b>' . $niveau . '</b>........................</label>
                </div><br/>
                <div class="col-md-12">
                    <label>N° carte COUD : .........<b>' . $num_etu . '</b>......................</label>
                    <label>N° CE : ...................<b>' . $num_etu . '</b>.....................</label>
                </div><br/>
                <div class="col-md-12">
                    <label>Bénéficie de l\'hebergement : .........................................................................................</label>
                </div>
            </div><br/>
            <div class="row">
                <div class="col-md-12">
                    <div class="extrait">
                        EXTRAIT DU REGLEMENT INTERIEUR
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="reglement">
                        <p>
                            <b>Article 16</b><br/>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt sint, architecto, asperiores labore rem quibusdam praesentium porro aperiam ipsum quis optio consequatur temporibus! Doloremque ad nulla nam incidunt asperiores. Ab.
                        </p>    
                        <p>
                            <b>Article 17</b><br/>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt sint, architecto, asperiores labore rem quibusdam praesentium porro aperiam ipsum quis optio consequatur temporibus! Doloremque ad nulla nam incidunt asperiores. Ab.
                        </p>
                        <p>   
                            <b>Article 18</b><br/>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt sint, architecto, asperiores labore rem quibusdam praesentium porro aperiam ipsum quis optio consequatur temporibus! Doloremque ad nulla nam incidunt asperiores. Ab.
                        </p>
                        <p>    
                            <b>N.B</b><br/>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt sint, architecto, asperiores labore rem quibusdam praesentium porro aperiam ipsum quis optio consequatur temporibus! Doloremque ad nulla nam incidunt asperiores. Ab.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="faitDakar">Dakar, le ....'.$dateLit.'...20.................</div>
                </div>
            </div>
            <div class="row">  
                <div class="col-md-3">
                    <div class="table-cell">Pour le Directeur du COUD <br/> Le Chef du service de l\'hebergement</div>
                </div>
                <div class="col-md-3">
                    <div class="right-align">Lu et Appouvé<br/>Le Locataire</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
                ';
$mpdf->WriteHTML($pdfcontent);
if ($result > 10) {
    $i++;
}
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;

//call watermark content and image
//$mpdf->SetWatermarkText('COUD');
$mpdf->showWatermarkText = true;
$mpdf->watermarkTextAlpha = 0.1;

//output in browser
$mpdf->Output();
