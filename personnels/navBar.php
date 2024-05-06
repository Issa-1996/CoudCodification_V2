<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /');
    exit();
}
require_once(__DIR__ . '/connect.php');
$idEtu = $_SESSION['id_etu'];
$requeteAffectEtu = "SELECT * FROM `affectation` where `id_etu`=$idEtu";
$inforequeteAffectEtu = $connexion->query($requeteAffectEtu);
$affecter = 0;
while ($row = $inforequeteAffectEtu->fetch_assoc()) {
    $affecter++;
}
$requeteLitEtu = "SELECT codif_lit.* FROM affectation JOIN codif_lit ON affectation.id_lit = codif_lit.id_lit where `id_etu`='$idEtu'";
$resultatReqLitEtu = $connexion->query($requeteLitEtu);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">
        <img src="../images/logo.png" width="200" class="d-inline-block align-top" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php if (($_SESSION['statut'] == 'personnels') && isset($_SESSION['classe'])) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="listeLits.php">Accueil <span>(<?= $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="niveau.php">Changer niveau</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="detailsLits.php">Détail</a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['statut'] == 'etudiants') { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="../etudiants/resultat.php">Accueil <span>(<?= $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>)</span></a>
                </li>
                <?php
                if ($affecter == 0) {
                    $_SESSION['lit_choisi'] = ''; ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="../etudiants/codifier.php">Codifier</a>
                    </li>
                <?php } else {
                    while ($rows = $resultatReqLitEtu->fetch_assoc()) {
                        $_SESSION['lit_choisi'] = "Vous avez déja choisi le lit: " . $rows['lit'];
                    }
                }
                ?>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="/"><i class="fa fa-sign-out" aria-hidden="true"></i> Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>
<!-- Bootstrap JS (optionnel, nécessaire pour le fonctionnement de la navbar) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>