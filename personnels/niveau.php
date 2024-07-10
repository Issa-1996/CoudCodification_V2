<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
// Supprimer une variable de session spécifique
unset($_SESSION['classe']);
// Sélectionnez les options à partir de la base de données avec une pagination
require_once(__DIR__ . '/connect.php');
require_once(__DIR__ . '/requete.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COUD: CODIFICATION</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php ////appel de la navigation
                require_once(__DIR__ . '/navBar.php'); ?>
            </div>
        </div>
        <div class="row">
            <form class="form" id="selectForm" action="" method="post">
                <div class="col-md-12">
                    <h4>Choisissez la Classe :</h4>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <select class="form-select" id="selectFac" aria-label="Default select example" onchange="populateData()" required="required">
                            <option value="" selected>Choisir Faculté</option>
                            <?php
                            while ($rowNiv = mysqli_fetch_array($resultatRequeteEtablissement)) { ?>
                                <option value="<?= $rowNiv['etablissement']; ?>"><?= $rowNiv['etablissement']; ?></option>
                            <?php } ?>
                        </select>
                        <span><?= $messageErreurFaculte ?></span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <select class="form-select" aria-label="Default select example" id="selectDep" required="required">
                            <option value="" selected>Choisir Département</option>
                            <?php
                            for ($i = 0; $i < count($tableauDataFaculte); $i++) { ?>
                                <option value="<?= $tableauDataFaculte[$i]; ?>"><?= $tableauDataFaculte[$i]; ?></option>
                            <?php } ?>
                        </select>
                        <span><?= $messageErreurDepartement ?></span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <select class="form-select" aria-label="Default select example" required="required" id="selectClasse">
                            <option value="" selected>Choisir Classe</option>
                            <?php
                            for ($i = 0; $i < count($tableauDataDepartement); $i++) { ?>
                                <option value="<?= $tableauDataDepartement[$i]; ?>"><?= $tableauDataDepartement[$i]; ?></option>
                            <?php 
                            } ?>
                        </select>
                        <span><?= $erreurClasse ?></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="script.js"></script>

</html>