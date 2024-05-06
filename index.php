<?php
require_once(__DIR__ . '/personnels/connect.php');
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (!empty($_SESSION['username']) && !empty($_SESSION['mdp'])) {
  session_destroy();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COUD: CODIFICATION</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f3f3f3;
    }

    .login-form {
      max-width: 350px;
      margin: 0 auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .login-form:hover {
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
    }

    .login-form h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: bold;
    }

    .form-control {
      border-radius: 5px;
    }

    .btn-primary {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }
    img{
      width: 60%;
      margin-top: -20%;
      margin-left: 15%;
      margin-bottom: -10%;
    }
    span{
      color: red;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <form class="login-form" action="/personnels/connect.php">
      <img src="images/images.png" width="200" alt="">
      <!-- <h2>Connexion</h2> -->
      <div class="form-group">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" class="form-control" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" name="mdp" required>
      </div>
      <button type="submit" class="btn btn-primary">Se Connecter</button>
      <span><?php if(isset($_GET['error'])){ echo $_GET['error']; } ?></span>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>