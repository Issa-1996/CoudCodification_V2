<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
if (empty($_SESSION['classe'])) {
    $_SESSION['classe'] = $_GET['classe'];
}
// Récupérer l'objet de la session
if ($_SESSION['monObjetRequeteFilter']) {
    unset($_SESSION['monObjetRequeteFilter']);
}
//connexion à la base de données
require_once(__DIR__ . '/connect.php');
// Pagination
require_once(__DIR__ . '/pagination.php');
require_once(__DIR__ . '/requete.php');

//filter total lits
if (isset($_POST['filter'])) {
    $filter = isset($_POST['filter']) ? $_POST['filter'] : '';
    $sql = "SELECT codif_lit.*, CASE WHEN quotas.id_lit_q IS NOT NULL AND affectation.id_lit IS NOT NULL THEN 'Migré dans les deux' WHEN quotas.id_lit_q IS NOT NULL THEN 'Migré vers quotas uniquement' WHEN affectation.id_lit IS NOT NULL THEN 'Migré vers affectation uniquement' ELSE 'Non migré' END AS statut_migration FROM codif_lit LEFT JOIN quotas ON codif_lit.id_lit = quotas.id_lit_q LEFT JOIN affectation ON codif_lit.id_lit = affectation.id_lit where pavillon='$filter' LIMIT $limit OFFSET $offset";
    $_SESSION['monObjetRequeteFilter'] = $sql;
    $_SESSION['monFilter'] = $filter;


    // Comptez le nombre total d'options dans la base de données: pagination total lit dans pa page listeLits.php
    // $count_queryTotalLit = "SELECT COUNT(*) as total FROM codif_lit";
    $count_queryTotalLit = "SELECT COUNT(*) as total, CASE WHEN quotas.id_lit_q IS NOT NULL AND affectation.id_lit IS NOT NULL THEN 'Migré dans les deux' WHEN quotas.id_lit_q IS NOT NULL THEN 'Migré vers quotas uniquement' WHEN affectation.id_lit IS NOT NULL THEN 'Migré vers affectation uniquement' ELSE 'Non migré' END AS statut_migration FROM codif_lit LEFT JOIN quotas ON codif_lit.id_lit = quotas.id_lit_q LEFT JOIN affectation ON codif_lit.id_lit = affectation.id_lit where pavillon='$filter' LIMIT $limit OFFSET $offset";
    $count_resultat_total = mysqli_query($connexion, $count_queryTotalLit);
    if ($count_resultat_total) {
        $count_data_total = mysqli_fetch_assoc($count_resultat_total);
        $_SESSION['paginationFilter'] = ceil($count_data_total['total'] / $limit);
    } else {
        $_SESSION['paginationFilter'] = 1; // Définir une valeur par défaut pour éviter une division par zéro
    }



    header('location: listeLits.php');
    exit();
} else {
    header('location: listeLits.php');
    exit();
}

// if (!$resultatRequeteTotal) {
//     die("Erreur dans la requête : " . mysqli_error($connexion));
// }
