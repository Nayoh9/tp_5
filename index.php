<?php
$page_title = "Accueil";

include "header.php";

?>

<h1 class="col-md-12 text-center mt-5 ">Créer un compte</h1>

<div class="row">
    <div class="col-md-12">
        <form action="register.php" method="post" class="mt-5 align-items-center flex-column d-flex">
            <label for="username">Pseudo</label>
            <input type="text" name="username" id="username" class="w-25">

            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="w-25">

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" class="w-25">

            <fieldset class="mb-3 text-center">
                <p class="my-2">Sexe </p>

                <label for="homme">
                    Homme
                </label>
                <input class="form-check-input" type="radio" id="homme" name="gender" value="male">

                <label for="femme">
                    Femme
                </label>
                <input class="form-check-input" type="radio" id="femme" name="gender" value="female">
            </fieldset>

            <div>
                <h2>Veuillez choisir trois films</h2>

                <?php
                try {
                    foreach ($db->query("SELECT title, id FROM movies") as $movie) {
                        $movie['title'] = htmlspecialchars($movie['title']);
                ?>
                        <div class='mb-1'>
                            <input type='checkbox' class='mx-2' id='movie_<?php echo $movie['id']; ?>' name='movies[]' value='<?php echo $movie['id']; ?>' />
                            <label for='movie_<?php echo $movie['id']; ?>'><?php echo $movie['title']; ?></label>
                        </div>
                <?php
                    }
                } catch (PDOException $e) {
                    // var_dump("erreur :" . $e->getMessage() . "<br />");
                    var_dump($error_db);
                    die();
                }
                ?>
                <button type="submit" class="btn btn-primary col-md-6">Envoyer</button>
        </form>
    </div>
</div>


<?php include "footer.php" ?>