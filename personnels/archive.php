<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
require_once('connect.php');
if (isset($_GET) && count($_GET) > 0) {
    $countError = 0;
    // Parcourir le tableau associatif pour récupérer les ID des boutons sélectionnés
    foreach ($_GET as $buttonId => $value) {
        // Vérifier si la valeur est "on" (ce qui signifie que la case à cocher est cochée)
        if ($value === "on") {
            $NiveauFormation = $_SESSION['classe'];
            $date=date("Y-n-j");
            $requeteInsertQuotas = "INSERT INTO `quotas` (`id_lit_q`, `NiveauFormation`, `annee`) VALUES ('$buttonId', '$NiveauFormation', '$date')";
            $requete = $connexion->prepare($requeteInsertQuotas);
            $requete->execute();
            header('Location: listeLits.php');
        } else {
            $countError++;
        }
    }
    if ($countError == 0) {
        header('Location: listeLits.php');
        exit();
    }
} else {
    header('Location: listeLits.php');
    exit();
}
require_once('close.php');
