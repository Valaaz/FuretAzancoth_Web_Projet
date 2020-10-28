<?php
include 'connexion.php';

/*
$result = $objPdo->query('SELECT * FROM redacteur');
while ($row = $result->fetch()) {
    if ($row['adressemail'] == $row['motdepasse'])
        echo 'Hehe';
}
$id = $objPdo->query('SELECT adressemail FROM redacteur WHERE idredacteur = 1');
$mdp = $objPdo->query('SELECT motdepasse FROM redacteur WHERE idredacteur = 1');
*/

session_start();


$err_connexion = array();
if (isset($_POST['valider'])) {
    if (!empty($_POST['utilisateur']) && !empty($_POST['mdp'])) {
        // requete : username existe ?
        $pdostat = $objPdo->prepare("SELECT pseudo, motdepasse FROM redacteur WHERE pseudo = :pseudo");
        $pdostat->bindvalue(':pseudo', $_POST['utilisateur'], PDO::PARAM_STR);
        $pdostat->execute();
        if ($pdostat->rowCount() > 0) // username OK
        {
            $row = $pdostat->fetch();
            // on compare le mot de passe entré avec celui enregistré en bdd
            if (password_verify($_POST['mdp'], $row['motdepasse'])) // pwd OK
            {
                // Mise en SESSION
                $_SESSION['isLogged'] = true;
                $_SESSION['adressemail'] = $row['adressemail'];
                $err_connexion[] = 'Connecté';
                // ATTENTION ! ON NE MET JAMAIS LE MOT DE PASSE EN SESSION !!
                // on redirige vers l'espace membre
                header('location:accueil.html');
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
                header('Location:accueil.html');
        }*/
//}
if (isset($_SESSION["isLogged"]))
    header('Location:accueil.html');

/*if (isset($_POST['url']))
    echo 'Vous devez vous connecter si vous voulez accéder à cette page :';*/
?>

<html>

<head>
    <title>Identification</title>
</head>

<body>
    <form method="post" action="identification.php">
        <?php if (!empty($err_connexion)) { ?>
            <div class="error"><?php echo implode('<br/>', $err_connexion); ?></div>
        <?php     } ?>
        <h1>Pour accéder à cette page il est nécessaire de se connecter avec votre identifiant</h1>
        <label>Identifiant</label> </br>
        <input type="text" value="" name="utilisateur"> </br>
        <label>Mot de passe</label> </br>
        <input type="text" value="" name="mdp"> </br> </br>
        <input type="submit" value="Validez" name="valider"> <br>
        <a href="creercompte.php"> Créer un compte </a>
    </form>
</body>

</html>