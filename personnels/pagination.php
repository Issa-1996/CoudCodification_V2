<?php
// demarrerer la session
session_start();
// appelle des pages de connexion et celle de la pagination
require_once(__DIR__ . '/connect.php');
// Pagination par page de 54 elements
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 54;
$offset = ($page - 1) * $limit;
$counter = 0;

// Comptez le nombre total d'options dans la base de données: pagination total lit dans pa page listeLits.php
$count_queryTotalLit = "SELECT COUNT(*) as total FROM codif_lit";
$count_resultat_total = mysqli_query($connexion, $count_queryTotalLit);
if ($count_resultat_total) {
    $count_data_total = mysqli_fetch_assoc($count_resultat_total);
    $total_lit_pages = ceil($count_data_total['total'] / $limit);
} else {
    $total_lit_pages = 1; // Définir une valeur par défaut pour éviter une division par zéro
}

// Comptez le nombre total d'options dans la base de données: pagination liste lits d'une classe selon l'etudiant connecté dans la page codifier.php
$count_queryEtudiant = "SELECT COUNT(*) as total FROM quotas JOIN codif_lit ON quotas.id_lit_q = codif_lit.id_lit where `NiveauFormation`='$classe' LIMIT $limit OFFSET $offset";
$count_resultEtudiant = mysqli_query($connexion, $count_queryEtudiant);
if ($count_resultEtudiant) {
    $count_dataEtudiant = mysqli_fetch_assoc($count_resultEtudiant);
    $total_pagesEtudiant = ceil($count_dataEtudiant['total'] / $limit);
} else {
    $total_pagesEtu = 1; // Définir une valeur par défaut pour éviter une division par zéro
}

// Comptez le nombre total d'options dans la base de données details lits affecter (quotas)
$count_querys = "SELECT COUNT(*) as total FROM quotas JOIN codif_lit ON quotas.id_lit_q = codif_lit.id_lit where `NiveauFormation`='$classe'";
$count_results = mysqli_query($connexion, $count_querys);
if ($count_results) {
    $count_datas = mysqli_fetch_assoc($count_results);
    $total_pagess = ceil($count_datas['total'] / $limit);
} else {
    $total_pagess = 1; // Définir une valeur par défaut pour éviter une division par zéro
}
