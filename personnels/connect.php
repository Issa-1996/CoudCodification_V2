<?php
// Connectez-vous à votre base de données MySQL
$connexion = mysqli_connect("mysql-supercoud.alwaysdata.net", "supercoud", "Douware96@...", "supercoud_codif");
// Vérifiez la connexion
if ($connexion === false) {
    die("Erreur : Impossible de se connecter. " . mysqli_connect_error());
}
$error = "";
if (!empty($_GET['username']) && !empty($_GET['mdp'])) {
    $username = $_GET['username'];
    $password = $_GET['mdp'];
    $users = "SELECT * FROM `users`";
    $info = $connexion->query($users);
    if ($info) {
        // Parcours les résultats de la requête ligne par ligne
        while ($row = $info->fetch_assoc()) {
            // Ajoute les données de chaque utilisateur dans le tableau
            $usersData[] = $row;
        }
        $countError = 0;
        for ($i = 0; $i < count($usersData); $i++) {
            if (($usersData[$i]['num_etu'] == $username) && ($usersData[$i]['mdp'] == $password)) {
                $countError++;
                session_start();
                $_SESSION['id_etu'] = $usersData[$i]['id_etu'];
                $_SESSION['username'] = $username;
                $_SESSION['mdp'] = $password;
                $_SESSION['prenom'] = $usersData[$i]['prenoms'];
                $_SESSION['nom'] = $usersData[$i]['nom'];
                $_SESSION['statut'] = $usersData[$i]['statut'];
                if ($usersData[$i]['statut'] == 'personnels') {
                    header('Location: /personnels/niveau.php');
                    exit();
                } else if ($usersData[$i]['statut'] == 'etudiants') {
                    session_start();
                    $_SESSION['classe'] = $usersData[$i]['niveauFormation'];
                    header('Location: ../etudiants/resultat.php');
                    exit();
                }
            }
        }
        if ($countError == 0) {
            $error = "Nom d'utilisateur ou mot de passe Incorrect";
            header('Location: /?error=' . $error);
            exit();
        }
    }
}
