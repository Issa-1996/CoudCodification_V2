<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
require_once('../personnels/connect.php');

if (isset($_GET) && count($_GET) > 0) {
    $idEtu = $_SESSION['id_etu'];
    $requeteInsert = "INSERT INTO `politique_conf` (`id_etu`, `dateTime`) VALUES ($idEtu, NOW())";
    $sql = $connexion->prepare($requeteInsert);
    $sql->execute();
    header('Location: resultat.php');
    exit();
}