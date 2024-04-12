<?php include "includes/functions.php"; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/tp_5.css">
    <title><?= $page_title; ?></title>

</head>

<body>

    <div class="container">
        <div class="wrapper">

            <header class="row align-items-center">
                <div class="col-md-6">
                    <h2><?= $page_title ?></h2>
                </div>

                <div class="col-md-6 text-center ">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#connexionModal">
                        Se connecter
                    </button>
                </div>
            </header>

            <div class="modal fade" id="connexionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Se connecter</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="connexion.php" method="post">
                            <div class="modal-body">
                                <div class="mb-3 row align-items-center ">
                                    <label for="email_connexion" class="col-sm-2 col-form-label">Email / username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="identifier_connexion" name="identifier_connexion">
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center ">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="inputPassword" name="password_connexion">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            if (!empty($_GET["error"])) {
                $error = htmlspecialchars(parse_error($_GET["error"]));
            ?>
                <div class="alert alert-danger text-center mt-2"><?= $error ?></div>
            <?php } ?>