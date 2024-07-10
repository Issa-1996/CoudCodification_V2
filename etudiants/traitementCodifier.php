<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
require_once('../personnels/connect.php');
$_SESSION['errorSaisi']=0;
if (isset($_GET) && count($_GET) > 0) {
    $countError = 0;
    $lastValue = null;
    $_SESSION['erreurLitCodifier']='';
    // Parcourir le tableau associatif pour récupérer les ID des boutons sélectionnés
    foreach ($_GET as $buttonId => $value) {
        // Vérifier si la valeur est "on" (ce qui signifie que la case à cocher est cochée)
        if ($value === "on") {
            $_SESSION['errorSaisi']=1;
            $lastValue = $buttonId;
        } else {
            $countError++;
        }
    }
    $idEtu = $_SESSION['id_etu'];
    $requeteInsertAff = "INSERT INTO `affectation` (`id_lit`, `id_etu`, `dateTime`) VALUES ($lastValue, $idEtu, NOW())";
    $requeteEtu = $connexion->prepare($requeteInsertAff);
    $requeteEtu->execute();
    header('Location: resultat.php');
    exit();
    if ($countError == 0) {
        header('Location: codifier.php');
        exit();
    }
} else {
    header('Location: codifier.php?erreurLitCodifier=VEUILLER SELECTIONNER UN LIT !!!');
    exit();
}


// require_once('close.php');