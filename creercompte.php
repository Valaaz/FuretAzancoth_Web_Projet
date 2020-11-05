<?php

include 'connexion.php';

$query = $objPdo->prepare("SELECT * FROM redacteur");
$query->execute();

$ok = true;
echo 'pas joli';
$err_inscription = array();
if (isset($_POST['valider'])) {
    echo 'joli';
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

            $nom = htmlentities($_POST['nom']);
            $prenom = htmlentities($_POST['prenom']);
            $pseudo = htmlentities($_POST['pseudo']);
            $mail = htmlentities($_POST['mail']);
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
                $_SESSION['mail'] = $mail;

                // ATTENTION ! ON NE MET JAMAIS LE MOT DE PASSE EN SESSION !!
                // on redirige vers l'espace membre
                header('location:accueil.php');
                exit();
            }
        }
    } else
        $err_inscription[] = 'Remplissez tous les champs obligatoires.';
}
?>

<html>

<head>
    <title>Création de compte</title>
    <link rel="stylesheet" href="css/creercompte.css" />
</head>

<body>
    <header>
    </header>
    <form method="post" action="creercompte.php" onsubmit="return Valider()" name="formulaire">
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
        <input type="button" value="Retour" name="annuler" onclick="Annuler()"> </br>
    </form>
</body>

<script language="javascript" type="text/javascript">
    function Annuler() {
        if (confirm("Souhaitez-vous revenir à l'accueil ?"))
            window.location.href = "accueil.php"
    }

    function Valider() {

        var nom = document.forms['formulaire'].nom
        var prenom = document.forms['formulaire'].prenom;
        var pseudo = document.forms['formulaire'].pseudo;
        var mail = document.forms['formulaire'].mail;
        var mdp = document.forms['formulaire'].mdp;
        var mdp2 = document.forms['formulaire'].mdp2;
        var ok = document.forms['formulaire'].$ok;
        var erreur = document.forms['formulaire'].$err_inscription;
        var regex = /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;


        if (!nom.value.replace(/\s+/, '').length) {
            alert("Nom vide");
            ok = false;
            ChangerCouleur(nom);
        } else
            ReinitialiserCouleur(nom);

        if (!prenom.value.replace(/\s+/, '').length) {
            alert("Prenom vide");
            ok = false;
            ChangerCouleur(prenom);
        } else
            ReinitialiserCouleur(prenom);

        if (!pseudo.value.replace(/\s+/, '').length) {
            alert("Pseudo vide");
            ok = false;
            ChangerCouleur(pseudo);
        } else
            ReinitialiserCouleur(pseudo);

        if (!mail.value.replace(/\s+/, '').length) {
            alert("Mail vide");
            ok = false;
            ChangerCouleur(mail);
        } else
            ReinitialiserCouleur(mail);

        if (!mdp.value.replace(/\s+/, '').length) {
            alert("Mot de passe vide");
            ok = false;
            ChangerCouleur(mdp);
        }

        if (!mdp2.value.replace(/\s+/, '').length) {
            alert("Confirmation mot de passe vide");
            ok = false;
            ChangerCouleur(mdp2);
        }

        if (!mail.value.match(regex)) {
            alert("Mail pas bon");
            ok = false;
            erreur = 'Le mail n\'est pas correct';
            ChangerCouleur(mail);
        } else
            ReinitialiserCouleur(mail);

        if (mdp.value != mdp2.value) {
            alert("Les deux mots de passe sont différents");
            ok = false;
            ChangerCouleur(mdp);
            ChangerCouleur(mdp2);
        } else {
            ReinitialiserCouleur(mdp);
            ReinitialiserCouleur(mdp2);
        }

        return ok;
    }

    function ChangerCouleur(objet) {
        objet.setAttribute('style', 'border: 2px solid red;');
    }

    function ReinitialiserCouleur(objet) {
        objet.setAttribute('style', 'border-color: black;');
    }
</script>

</html>