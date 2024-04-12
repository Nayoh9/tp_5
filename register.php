    <?php
    include "includes/functions.php";

    $error = false;
    $error_redirect = "index.php";

    if (!check_identifiers($_POST["username"], "username")) {
        $error = "invalid_username";
    }

    if (!check_identifiers($_POST["email"], "email")) {
        $error = "invalid_email";
    }

    if (!check_identifiers($_POST["password"], "password")) {
        $error = "invalid_password";
    }

    if (empty($_POST["gender"])) {
        $error = "invalid_gender";
    }

    switch ($_POST["gender"]) {
        case "male":
        case "female":
            $sex =  clean_string($_POST["gender"]);
            break;
        default:
            $sex = "male";
            break;
    }


    if (!empty($_POST["movies"])) {
        $movies_list = $_POST["movies"];

        foreach ($movies_list as $movie) {
            htmlspecialchars($movie);
        }

        if (count($movies_list) > $user_max_movies) {
            $error = "more_than_3_movies_selected";
        }
    } else {
        $movies_list = [];
    }


    $username = clean_string($_POST["username"]);
    $email = clean_string($_POST["email"]);
    $password = clean_string($_POST["password"]);
    $movies_list = implode(",", $movies_list);
    $uuid = guidv4();
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $user_ip_address = $_SERVER['REMOTE_ADDR'];


    if ($error) {
        header("Location: $error_redirect?error=$error");
    }

    try {
        $is_email_already_in_db = $db->query("SELECT user.id FROM user WHERE user.email = '$email'");
        $result = $is_email_already_in_db->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // var_dump("erreur :" . $e->getMessage() . "<br />");
        echo $error_db;
        die();
    }

    if (!empty($result)) {
        $error = "email_already_in_use";
    }

    if ($error) {
        header("Location: $error_redirect?error=$error");
    } else {

        try {
            $create_user = $db->prepare("INSERT INTO USER (
                    uid,
                    username,
                    email,
                    password,
                    sex,
                    movies_list,
                    ip_address
                ) VALUES (
                    :uid,
                    :username,
                    :email,
                    :password,
                    :sex,
                    :movies_list,
                    :ip_address
                )");

            $create_user->execute(
                [
                    'uid' => $uuid,
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashed_password,
                    'sex' => $sex,
                    'movies_list' => $movies_list,
                    'ip_address' => $user_ip_address
                ]
            );

            header("Location: user.php?id=$uuid");
        } catch (PDOException $e) {
            // var_dump("erreur :" . $e->getMessage() . "<br />");
            // var_dump($create_user->errorInfo());
            echo $error_db;
            die();
        }
    }
