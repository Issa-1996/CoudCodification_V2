<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
if (empty($_SESSION['classe'])) {
    header('location: /personnels/niveau.php');
    exit();
}
//connexion à la base de données
require_once(__DIR__ . '/connect.php');
// Sélectionnez les options à partir de la base de données avec une pagination
require_once(__DIR__ . '/requete.php');
// Pagination
require_once(__DIR__ . '/pagination.php');
$countIn = 0;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COUD: CODIFICATION</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php //appel de la navigation
                require_once(__DIR__ . '/navBar.php'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <h6>Lit déja validés:<br> <span> <?= $_SESSION['classe']; ?> </span></span></h6>
            </div>
            <div class="col-md-12">
                <ul class="options">
                    <form id="myForm" action="rearchive.php" method="GET">
                        <div class='options-container'>
                            <?php
                            while ($row = mysqli_fetch_array($resultatRequeteLitClasse)) {
                                if ($row['statut_migration'] == 'Migré dans les deux') {
                                    $countIn++;
                                }
                                if ($counter % 8 == 0) { ?>
                                    <div class='column'>
                                    <?php
                                }
                                if ($row['statut_migration'] == 'Migré vers quotas uniquement') {
                                    ?>
                                        <label class="option" title="Lit non choisi">
                                            <input type="checkbox" name="<?= $row['id_lit'] ?>" id="<?= $row['id_lit'] ?>"><?= $row['lit'] ?></input>
                                        </label>
                                    <?php
                                }
                                if ($row['statut_migration'] == 'Migré dans les deux') {
                                    ?>
                                        <label class="archive" title="Lit déja choisi!"><?= $row['lit'] ?> </label>
                                    <?php
                                }
                                $counter++;
                                if ($counter % 8 == 0) { ?>
                                    </div>
                                <?php
                                }
                            }
                            // Fermeture de la dernière colonne si le nombre total d'options n'est pas un multiple de 4
                            if ($counter % 8 != 0) { ?>
                        </div>

                    <?php
                            } ?>
            </div>
            <div class="row justify-content-center">

                </style>
                <?php if ($countIn == 0) { ?>
                    <div class="col-md-2">
                        <input type='reset' onclick="choixs()" class="btn btn-outline-danger fw-bold">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-primary fw-bold" type='submit'>ANNULER</button>
                    </div>
                <?php } else { ?> <style>
                        .option {
                            pointer-events: none;
                        }
                    </style> <?php } ?>
                <div class="col-md-2">
                    <select class='form-select' onchange='location = this.value;'>
                        <?php
                        // Affichage de la liste déroulante de pagination
                        for ($i = 1; $i <= $total_pagess; $i++) {
                            $offset_value = ($i - 1) * $limit;
                            $selected = ($i == $page) ? "selected" : "";
                            $lower_bound = $offset_value + 1;
                            $upper_bound = min($offset_value + $limit, $count_datas['total']);
                            echo "<option value='detailsLits.php?page=$i' $selected>De $lower_bound à $upper_bound</option>";
                        } ?>
                    </select>
                </div>
                <?php
                // Fermez la connexion
                mysqli_close($connexion);
                ?>

            </div>
            </form>
            </ul>
        </div>
    </div>
</body>
<script src="script.js"></script>

</html>