<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
//connexion à la base de données
require('../personnels/connect.php');
// Sélectionnez les options à partir de la base de données avec une pagination
require('../personnels/requete.php');
// Pagination
require('../personnels/pagination.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COUD: CODIFICATION</title>
    <link rel="stylesheet" href="../personnels/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php ////appel de la navigation
                require('../personnels/navBar.php'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6>Liste des lits pour la : <span><?= $_SESSION['classe']; ?></span> </h6>
            </div>
            <div class="col-md-12">
                <ul class="options">
                    <form id="myForm" action="traitementCodifier.php" method="GET">
                        <!-- Affichez chaque option dans une liste -->
                        <div class='options-container'>
                            <?php
                            while ($row = mysqli_fetch_array($resultRequeteLitClasseEtudiant)) {
                                // print_r($row);
                                if ($counter % 8 == 0) { ?>
                                    <div class='column'>
                                    <?php
                                }
                                // print_r($row);
                                if ($row['statut_migration'] == 'Migré vers quotas uniquement') {
                                    ?>
                                        <label class="optionEtu" title="Lit non choisi !">
                                            <input type="checkbox" name="<?= $row['id_lit'] ?>" id="<?= $row['id_lit'] ?>"><?= $row['lit'] ?></input>
                                        </label>
                                    <?php
                                }
                                if ($row['statut_migration'] == 'Migré dans les deux') {
                                    ?>
                                        <label class="archive" title="Lit affecté"><?= $row['lit'] ?> </label>
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
                <div class="col-md-2">
                    <input type='reset' onclick="resetAndReload()" class="btn btn-outline-danger fw-bold" title="Annulé la selectionnée">
                </div>
                <div class="col-md-2">
                    <select class='form-select' onchange='location = this.value;'>
                        <?php
                        // Affichage de la liste déroulante de pagination
                        for ($i = 1; $i <= $total_pagesEtudiant; $i++) {
                            $offset_value = ($i - 1) * $limit;
                            $selected = ($i == $page) ? "selected" : "";
                            $lower_bound = $offset_value + 1;
                            $upper_bound = min($offset_value + $limit, $count_dataEtudiant['total']);
                            echo "<option value='codifier.php?page=$i' $selected>De $lower_bound à $upper_bound</option>";
                        } ?>
                    </select>
                </div>
                <?php
                // Fermez la connexion
                mysqli_close($connexion);
                ?>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary fw-bold" type='submit' title="Sauvegarder les lits selectionnés">Codifier</button>
                </div>
            </div>
            </form>
            </ul>
        </div>
    </div>
</body>

<script>
    function resetAndReload() {
        document.getElementById("myForm").reset(); // Réinitialise le formulaire
        window.location.reload(); // Actualise la page
    }
</script>
<script src="../personnels/script.js"></script>

</html>