<?php
include 'connexion.php';

session_start();

$err_connexion = array();
if (isset($_POST['valider'])) {
    if (!empty($_POST['utilisateur']) && !empty($_POST['mdp'])) {
        // Pseudo
        $pdostat = $objPdo->prepare("SELECT * FROM redacteur WHERE pseudo = :pseudo");
        $pdostat->bindvalue(':pseudo', $_POST['utilisateur'], PDO::PARAM_STR);
        $pdostat->execute();
        // Mail
        $pdostat2 = $objPdo->prepare("SELECT * FROM redacteur WHERE adressemail = :mail");
        $pdostat2->bindvalue(':mail', $_POST['utilisateur'], PDO::PARAM_STR);
        $pdostat2->execute();

        if ($pdostat->rowCount() > 0 || $pdostat2->rowCount() > 0) // username OK
        {
            $row = $pdostat->fetch();
            $row2 = $pdostat2->fetch();
            // On compare le mot de passe entré avec celui de la bdd
            if (password_verify($_POST['mdp'], $row['motdepasse']) || password_verify($_POST['mdp'], $row2['motdepasse'])) // pwd OK
            {
                // Mise en session
                $_SESSION['isLogged'] = true;
                if ($_POST['utilisateur'] == $row['pseudo']) {
                    $_SESSION['id'] = $row['idredacteur'];
                    $_SESSION['pseudo'] = $row['pseudo'];
                    $_SESSION['mail'] = $row['adressemail'];
                } else {
                    $_SESSION['id'] = $row2['idredacteur'];
                    $_SESSION['pseudo'] = $row2['pseudo'];
                    $_SESSION['mail'] = $row2['adressemail'];
                }
                $err_connexion[] = 'Connecté';
                // On renvoie a l'accueil
                header('location:accueil.php');
                exit();
            } else {
                $err_connexion[] = 'erreur : mot de passe : ' . $_POST['mdp'];
                $err_connexion[] = 'Identifiant et/ou mot de passe incorrect.';
            }
        } else {
            $err_connexion[] = 'rowCount : ' . $pdostat->rowCount();
            $err_connexion[] = 'erreur Identifiant : ' . $_POST['utilisateur'];
            $err_connexion[] = 'Identifiant et/ou mot de passe incorrect.';
        }
    } else {
        $err_connexion[] = 'Remplissez tous les champs obligatoires.';
    }
}




/*
if (isset($_POST['valider'])) {
if (isset($_POST["utilisateur"]) and isset($_POST["mdp"])) {
    if ($_POST["utilisateur"] == "valaz" and $_POST["mdp"] == "val") {
            $_SESSION["isLogged"] = true;
            if (isset($_GET['target']))
                header('Location:' . $_GET["target"]);
            else
                header('Location:accueil.php');
        }*/
//}
/*
if (isset($_SESSION["isLogged"]))
    header('Location:accueil.php');
*/
/*if (isset($_POST['url']))
    echo 'Vous devez vous connecter si vous voulez accéder à cette page :';*/
?>

<html>

<head>
    <title>Identification</title>
    <link rel="stylesheet" href="css/identification.css" />
</head>

<body>
    <header>
    </header>
    <form method="post" action="identification.php">
        <?php if (!empty($err_connexion)) { ?>
            <div class="error"><?php echo implode('<br/>', $err_connexion); ?></div>
        <?php     } ?>
        <label>Identifiant</label> </br>
        <input type="text" value="" name="utilisateur"> </br>
        <label>Mot de passe</label> </br>
        <input type="text" value="" name="mdp"> </br> </br>
        <input type="submit" value="Validez" name="valider"> <br>
        <a href="creercompte.php"> Créer un compte </a>
    </form>
</body>

</html>