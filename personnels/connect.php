<?php
// Connectez-vous à votre base de données MySQL
$connexion = mysqli_connect("localhost", "root", "", "supercoud_codif");
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
                session_start();
                $countError++;
                $_SESSION['id_etu'] = $usersData[$i]['id_etu'];
                $_SESSION['username'] = $username;
                $_SESSION['mdp'] = $password;
                $_SESSION['prenom'] = $usersData[$i]['prenoms'];
                $_SESSION['nom'] = $usersData[$i]['nom'];
                $_SESSION['statut'] = $usersData[$i]['statut'];
                $_SESSION['dateNaissance'] = $usersData[$i]['dateNaissance'];
                $_SESSION['lieuNaissance'] = $usersData[$i]['lieuNaissance'];
                $_SESSION['sexe'] = $usersData[$i]['sexe'];
                $_SESSION['nationalite'] = $usersData[$i]['nationalite'];
                $_SESSION['niveau'] = $usersData[$i]['niveau'];
                $_SESSION['num_etu '] = $usersData[$i]['num_etu'];
                $_SESSION['etablissement'] = $usersData[$i]['etablissement'];
                $_SESSION['num_etu '] = $usersData[$i]['num_etu'];
                if ($usersData[$i]['statut'] == 'personnels') {
                    header('Location: /codif/personnels/niveau.php');
                    exit();
                } else if ($usersData[$i]['statut'] == 'etudiants') {
                    session_start();
                    $id=$_SESSION['id_etu'];
                    $_SESSION['classe'] = $usersData[$i]['niveauFormation'];
                    $usersPolitique = "SELECT *  FROM `politique_conf` where `id_etu`='$id'";
                    $infoPolitique = mysqli_query($connexion, $usersPolitique);
                    $resultat=$infoPolitique->fetch_assoc();
                    if ($resultat) {
                        header('Location: ../etudiants/resultat.php');
                        exit();
                    }else{
                        header('Location: ../etudiants/accueilEtudiant.php');
                        exit();
                    }
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
