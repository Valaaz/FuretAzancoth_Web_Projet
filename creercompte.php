<?php

include 'connexion.php';

$query = $objPdo->prepare("SELECT * FROM redacteur");
$query->execute();

$ok = true;

$err_inscription = array();
if (isset($_POST['valider'])) {
    // Vérifie si les champs sont remplis on non 
    if (!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['mdp']) && !empty($_POST['mdp2']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
        // Vérifie si le pseudo et/ou le mail rentré(-s) existe(-nt) déjà
        foreach ($query as $row) {
            if ($row['pseudo'] == $_POST['pseudo']) {
                $err_inscription[] = 'Ce pseudo existe déjà';
                $ok = false;
            }
            if ($row['adressemail'] == $_POST['mail']) {
                $err_inscription[] = 'Cette adresse mail existe déjà';
                $ok = false;
            }
        }
        if ($ok == true) {
            if ($_POST['mdp'] == $_POST['mdp2']) {

                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $pseudo = $_POST['pseudo'];
                $mail = $_POST['mail'];
                $mdp = crypt(htmlentities($_POST['mdp']), '$2a$07$usesomesillystringforsalt');

                // INSERT en bdd
                $pdostat = $objPdo->prepare("INSERT INTO `redacteur`(`nom`, `prenom`, `pseudo`, `adressemail`, `motdepasse`) VALUES(:nom, :prenom, :pseudo, :mail, :mdp);");
                $pdostat->bindvalue(':pseudo', $pseudo, PDO::PARAM_STR);
                $pdostat->bindvalue(':mdp', $mdp, PDO::PARAM_STR);
                $pdostat->bindvalue(':nom', $nom, PDO::PARAM_STR);
                $pdostat->bindvalue(':prenom', $prenom, PDO::PARAM_STR);
                $pdostat->bindvalue(':mail', $mail, PDO::PARAM_STR);

                if (!$pdostat->execute()) { // Si le résultat de la requête est faux ou null, c'est qu'il y a eu un problème
                    $err_inscription[] = 'Erreur MySQL : Ce pseudo ou cette adresse mail existe déjà.';
                } else {
                    if (session_id() == "") // Si l'id de session est vide, c'est que la session n'est pas démarée
                        session_start();
                    // Mise en SESSION
                    $_SESSION['isLogged'] = true;
                    $_SESSION['pseudo'] = $pseudo;

                    // ATTENTION ! ON NE MET JAMAIS LE MOT DE PASSE EN SESSION !!
                    // on redirige vers l'espace membre
                    header('location:accueil.php');
                    exit();
                }
            } else
                $err_inscription[] = 'Les deux mots de passe sont différents.';
        }
    } else
        $err_inscription[] = 'Remplissez tous les champs obligatoires.';
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