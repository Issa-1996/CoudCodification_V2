<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: http://localhost/COUD/testes123');
    exit();
}
require_once('connect.php');
if (isset($_GET) && count($_GET) > 0) {
    // Parcourir le tableau associatif pour récupérer les ID des boutons sélectionnés
    foreach ($_GET as $buttonId => $value) {
        // Vérifier si la valeur est "on" (ce qui signifie que la case à cocher est cochée)
        if ($value === "on") {
            $sql0 = "DELETE FROM quotas WHERE id_lit_q = '$buttonId'";
            $query0 = $connexion->prepare($sql0);
            $query0->execute();
            header('Location: detailsLits.php');
        }
    }
} else {
    header('Location: detailsLits.php');
    exit();
}
require_once('close.php');
