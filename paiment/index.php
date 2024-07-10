<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="coud\logo_coud.png" alt="" width="150" height="100">
            </a>
            <div class="collapse navbar-collapse nav justify-content-end">
                <a class="navbar-brand" href="#">
                    <img src="coud\logo_ucad.jpg" alt="" width="150" height="100">
            </div>
        </div>
    </nav>
    <br><br><br>
    <div class="d-flex justify-content-center">
        <form class="row g-3" action="etudiant.php" method="POST"
            style="display: flex;justify-content: center;color:black;">
            <div class="col-auto">
                <label class="visually-hidden">num etudiant</label>
                <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Numero Etudiant">
            </div>
            <div class="col-auto">
                <label class="visually-hidden">etu</label>
                <input type="text" class="form-control" placeholder="code permanent">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Rechercher</button>
            </div>
        </form>
    </div>
</body>

</html>