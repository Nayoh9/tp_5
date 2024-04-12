    <?php
    $page_title = "User";
    include "header.php";

    $user_id = $_GET["id"];

    try {
        $user_informations = $db->query("SELECT * FROM user WHERE user.uid = '$user_id'");
        $user_informations_result = $user_informations->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // echo "Erreur : " . $e->getMessage();
        echo $error_db;
        die();
    }

    if (!empty($user_informations_result["movies_list"])) {
        try {
            $user_movies_query = $db->query("SELECT title
            FROM movies
            WHERE id IN (" . $user_informations_result["movies_list"] . ")
        ");
            $user_movies_result = $user_movies_query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // echo "Erreur : " . $e->getMessage();
            echo $error_db;
            die();
        }
    } else {
        $user_movies_result = [];
    }

    switch ($user_informations_result["sex"]) {
        case 'male':
            $user_informations_result["sex"] = "Monsieur";
            break;
        case "female";
            $user_informations_result["sex"] = "Madame";
            break;
        default:
            $user_informations_result["sex"] = "Monsieur";
            break;
    }
    ?>

    <div class="row">
        <div class="col-md-12 text-center my-5">
            <h1>Bonjour <?php echo htmlspecialchars($user_informations_result["sex"])  . " " . htmlspecialchars($user_informations_result["username"]) ?>.</h1>
            <p>Bienvenue sur votre espace privé.</p>
        </div>

        <div class="col-md-12">
            <p>Votre e-mail : <?php echo htmlspecialchars($user_informations_result["email"])  ?> </p>
            <p>Vos films préférés sont : </p>
            <ul>
                <?php foreach ($user_movies_result as $movie) {
                    echo "<li>" . htmlspecialchars($movie["title"]) . "</li>";
                } ?>
            </ul>
        </div>
    </div>

    <?php include "footer.php" ?>