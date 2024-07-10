<?php
// Verifier la session si elle est actif, sinon on redirige vers la racine
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
// Verifier si la session stock toujours la valeur du niveau de la classe, sinon on l'initialise
if (isset($_SESSION['classe'])) {
    $classe = $_SESSION['classe'];
} else {
    $classe = "";
}
// appelle des pages de connexion et celle de la pagination
require_once(__DIR__ . '/connect.php');
require_once(__DIR__ . '/pagination.php');

// Requete pour l'affichage des niveaux de formation dans la page niveau.php
$requeteEtablissement = "SELECT DISTINCT (etablissement) FROM `codif_etudiant`";
$resultatRequeteEtablissement = mysqli_query($connexion, $requeteEtablissement);

// Requete pour synchroniser les champs select entre etablishment et departement
$tableauDataFaculte = [];
$tableauDataDepartement = [];
$erreurClasse = "";
$messageErreurFaculte = "";
$messageErreurDepartement = "";
if (isset($_GET['fac']) && !empty($_GET['fac'])) {
    $getDataFaculte = $_GET['fac'];
    $requeteDepartement = "SELECT DISTINCT(departement) FROM `codif_etudiant` WHERE `etablissement`='" . $getDataFaculte . "'";
    $resultatRequeteDepartement = mysqli_query($connexion, $requeteDepartement);
    $i = 0;
    while ($rowDepartement = mysqli_fetch_array($resultatRequeteDepartement)) {
        $tableauDataFaculte[$i] = $rowDepartement['departement'];
        $i++;
    }
    if (isset($_GET['dep']) && !empty($_GET['dep'])) {
        $getDataDepartement = $_GET['dep'];
        $requeteNiveauFormation = "SELECT DISTINCT(niveauFormation) FROM `codif_etudiant` WHERE `departement`='" . $getDataDepartement . "'";
        $resultatRequeteNiveauFormation = mysqli_query($connexion, $requeteNiveauFormation);
        $i = 0;
        while ($rowNiveauFormation = mysqli_fetch_array($resultatRequeteNiveauFormation)) {
            $tableauDataDepartement[$i] = $rowNiveauFormation['niveauFormation'];
            $i++;
        }
        if (isset($_GET['fac']) && $_GET['dep'] && $_GET['classe']) {
            header("location:listeLits.php?classe=" . $_GET['classe']);
        } else {
            $erreurClasse = "La Classe est obligatoire !";
        }
    } else {
        $messageErreurDepartement = "Le Département est obligatoire !";
    }
} else {
    $messageErreurFaculte = "La Faculté est obligatoire !";
}
// Liste des chambres deja affecter a une classe selon le niveau de la classe
$requeteLitClasse = "SELECT codif_lit.*, CASE WHEN quotas.id_lit_q IS NOT NULL AND affectation.id_lit IS NOT NULL THEN 'Migré dans les deux' WHEN quotas.id_lit_q IS NOT NULL THEN 'Migré vers quotas uniquement' WHEN affectation.id_lit IS NOT NULL THEN 'Migré vers affectation uniquement' ELSE 'Non migré' END AS statut_migration FROM codif_lit LEFT JOIN quotas ON codif_lit.id_lit = quotas.id_lit_q LEFT JOIN affectation ON codif_lit.id_lit = affectation.id_lit WHERE quotas.NiveauFormation = '$classe' LIMIT $limit OFFSET $offset";
$resultatRequeteLitClasse = mysqli_query($connexion, $requeteLitClasse);
// affichage de toutes les lits de la table cofif_lit avec les option migré et non migré
$sql = "SELECT codif_lit.*, CASE WHEN quotas.id_lit_q IS NOT NULL THEN 'Migré' ELSE 'Non migré' END AS statut_migration FROM codif_lit LEFT JOIN quotas ON codif_lit.id_lit = quotas.id_lit_q LIMIT $limit OFFSET $offset";
$resultatRequeteTotalLit = mysqli_query($connexion, $sql);
// Liste des chambres deja affecter a une classe selon le niveau de la classe
// $classe = $_SESSION['classe'];
$requeteLitClasseEtudiant = "SELECT codif_lit.*, CASE WHEN quotas.id_lit_q IS NOT NULL AND affectation.id_lit IS NOT NULL THEN 'Migré dans les deux' WHEN quotas.id_lit_q IS NOT NULL THEN 'Migré vers quotas uniquement' WHEN affectation.id_lit IS NOT NULL THEN 'Migré vers affectation uniquement' ELSE 'Non migré' END AS statut_migration FROM codif_lit LEFT JOIN quotas ON codif_lit.id_lit = quotas.id_lit_q LEFT JOIN affectation ON codif_lit.id_lit = affectation.id_lit WHERE quotas.NiveauFormation = '$classe' LIMIT $limit OFFSET $offset";
$resultRequeteLitClasseEtudiant = mysqli_query($connexion, $requeteLitClasseEtudiant);

//Affiché la liste total des pavillon
$requetePavillon = "SELECT DISTINCT (pavillon) FROM `codif_lit`";
$resultatRequetePavillon = mysqli_query($connexion, $requetePavillon);

// //filter total lits
// $filter = isset($_POST['filter']) ? $_POST['filter'] : '';

// // if ($filter) {
//     $sql = "SELECT codif_lit.*, CASE WHEN quotas.id_lit_q IS NOT NULL AND affectation.id_lit IS NOT NULL THEN 'Migré dans les deux' WHEN quotas.id_lit_q IS NOT NULL THEN 'Migré vers quotas uniquement' WHEN affectation.id_lit IS NOT NULL THEN 'Migré vers affectation uniquement' ELSE 'Non migré' END AS statut_migration FROM codif_lit LEFT JOIN quotas ON codif_lit.id_lit = quotas.id_lit_q LEFT JOIN affectation ON codif_lit.id_lit = affectation.id_lit";
//     $sql .= " WHERE pavillon LIKE '%" . $connexion->real_escape_string($filter) . "%' && quotas.NiveauFormation = '$classe' LIMIT $limit OFFSET $offset";
//     $resultatRequeteTotal = mysqli_query($connexion, $sql);
//     // header('Location: listeLits.php');
// // }
