<?php
/*
session_start();
if (isset($_POST['user'], $_SESSION['mdp'], $_POST['mdp2'], $_POST['mail'])) {
    $bSoumis = 1;
    $user = $_POST['user'];
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];
    $mail = $_POST['mail'];

    header('creercompte.php');
    if ($_POST['user'] == 'valaz' && $_POST['mdp'] == 'secret') {
        $_SESSION['isLogged'] = true;
        if (isset($_GET['target'])) {
            header('Location:' . $_GET['target']);
        } else {
            header('Location:accueil.php');
        }
    }
}
if (isset($_SESSION["isLogged"]))
    header('Location:index.php');

if (isset($_POST['url']))
    echo 'Pour accéder à cette page il est nécessaire de se connecter avec votre identifiant :';
    */

//unset($_SESSION['isLogged']);
//unset($_SESSION['pseudo']);

include 'connexion.php';

// --------------
// 1- INSCRIPTION
$err_inscription = array();
if (isset($_POST['valider'])) {
    if (!empty($_POST["pseudo"]) && !empty($_POST["mail"]) && !empty($_POST["mdp"]) && !empty($_POST["mdp2"]) && !empty($_POST["nom"]) && !empty($_POST["prenom"])) {
        if ($_POST["mdp"] == $_POST["mdp2"]) {
            // INSERT en bdd
            $pdostat =  $objPdo->prepare("INSERT INTO redacteur(nom, prenom, pseudo, adressemail, motdepasse) VALUES(:nom, :prenom, :pseudo, :mail, :mdp);");
            $pdostat->bindvalue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            $pdostat->bindvalue(':mdp', password_hash($_POST["mdp"], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $pdostat->execute();

            // Mise en SESSION
            $_SESSION['isLogged'] = true;
            $_SESSION['pseudo'] = $row['pseudo'];
            // ATTENTION ! ON NE MET JAMAIS LE MOT DE PASSE EN SESSION !!
            // on redirige vers l'espace membre
            header('location:accueil.html');
            exit();
        } else {
            $err_inscription[] = 'Les deux mots de passe sont différents.';
        }
    } else {
        $err_inscription[] = 'Remplissez tous les champs obligatoires.';
    }
}

?>

<html>

<head>
    <title>Création de compte</title>
</head>

<body>
    <form method="post" action="creercompte.php">
        <?php if (!empty($err_inscription)) { ?>
            <div class="error"><?php echo implode('<br/>', $err_inscription); ?></div>
        <?php     } ?>
        <h1>Créer un compte</h1>
        <label>Nom</label> </br>
        <input type="text" value="" name="nom"> </br>

        <label>Prénom</label> </br>
        <input type="text" value="" name="prenom"> </br>

        <label>Identifiant</label> </br>
        <input type="text" value="" name="pseudo"> </br>

        <label>Mail</label> </br>
        <input type="text" value="" name="mail"> </br>

        <label>Mot de passe</label> </br>
        <input type="text" value="" name="mdp"> </br>

        <label>Confirmation</label> </br>
        <input type="text" value="" name="mdp2"> </br> </br>

        <input type="submit" value="Validez" name="valider">
    </form>
</body>

</html>