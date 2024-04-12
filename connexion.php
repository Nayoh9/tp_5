    <?php
    include "includes/functions.php";

    $error = false;
    $error_redirect = "index.php";
    $ok_redirect = "user.php";

    $user_last_connexion = date("Y-m-d H:i:s");

    if (empty($_POST["identifier_connexion"] || empty($_POST["password_connexion"]))) {
        $error = "invalid_username/password";
    }

    $identifier = htmlspecialchars($_POST["identifier_connexion"]);
    $password = $_POST["password_connexion"];

    try {
        $user_connexion_query = $db->prepare(" SELECT * 
            FROM user
            WHERE user.email = '$identifier' OR user.username = :identifier");
        $user_connexion_query->execute(
            array(
                "identifier" => $identifier
            )
        );
        $user_connexion_result = $user_connexion_query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // echo "Erreur : " . $e->getMessage();
        echo $error_db;
        die();
    }

    $passwords_match = password_verify($password, $user_connexion_result["password"]);

    if (empty($passwords_match)) {
        $error = "Wrong_identifer_or_password";
    }

    if ($error) {
        header("Location: $error_redirect?error=$error");
    } else {

        try {
            $last_connexion_query = $db->prepare("UPDATE user 
            SET last_connexion = :user_last_connexion");

            $last_connexion_query->execute(
                [
                    "user_last_connexion" => $user_last_connexion
                ]
            );

            $user_last_connexion_result = $last_connexion_query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // echo "Erreur : " . $e->getMessage();
            echo $error_db;
            die();
        }

        header('Location: ' . $ok_redirect . '?id=' . $user_connexion_result['uid']);
    }
