<?php
// Connexion à la base de données 
try {
    $conn = new PDO('mysql:host=localhost; dbname=salaire', 'root', '');
    echo "reussi </br>";
    
} catch (PDOException $e) {
    die("Erreur:" . $e->getMessage());
}
?>