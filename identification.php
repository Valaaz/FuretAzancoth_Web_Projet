<?php
include 'connexion.php';

session_start();
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

        if ($pdostat->rowCount() > 0 || $pdostat2->rowCount() > 0) // utilisateur bon
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
                    $_SESSION['nom'] = $row['nom'];
                    $_SESSION['prenom'] = $row['prenom'];
                } else {
                    $_SESSION['id'] = $row2['idredacteur'];
                    $_SESSION['pseudo'] = $row2['pseudo'];
                    $_SESSION['mail'] = $row2['adressemail'];
                    $_SESSION['nom'] = $row2['nom'];
                    $_SESSION['prenom'] = $row2['prenom'];
                }
                header('location:accueil.php');
                exit();
            } else
                echo "<script>alert('Mot de passe incorrect.')</script>";
        } else
            echo "<script>alert('Identifiant incorrect.')</script>";
    } else
        echo "<script>alert('Remplissez tous les champs obligatoires.')</script>";
}
?>

<html>

<head>
    <title>Identification</title>
    <link rel="stylesheet" href="css/identification.css" />
</head>

<body>
    <header>
        <h1>Identifiez vous</h1>
    </header>

    <hr>

    <form method="post" action="identification.php" onsubmit="return Valider()" name="formulaire">
        <label>Identifiant</label> </br>
        <input type="text" value="" name="utilisateur"> </br>
        <label>Mot de passe</label> </br>
        <input type="password" value="" name="mdp" id="mdp" autocomplete="off">
        <input type="checkbox" onclick="VueMdp()"> Voir mot de passe </br>

        <div class="bouton">
            <input class="valid" type="submit" value="Valider" name="valider">
            <input class="retour" type="button" value="Retour" name="annuler" onclick="Annuler()">
        </div>
        <a href="creercompte.php"> Créer un compte </a>
    </form>
</body>

<script language="javascript" type="text/javascript">
    function Annuler() {
        if (confirm("Souhaitez-vous revenir à l'accueil ?"))
            window.location.href = "accueil.php"
    }

    function Valider() {
        var identifiant = document.forms['formulaire'].utilisateur;
        var mdp = document.forms['formulaire'].mdp;
        var ok = document.forms['formulaire'].$ok;

        if (!identifiant.value.replace(/\s+/, '').length) {
            alert("Identifiant vide");
            ok = false;
            ChangerCouleur(identifiant);
        } else
            ReinitialiserCouleur(identifiant);

        if (!mdp.value.replace(/\s+/, '').length) {
            alert("Mot de passe vide");
            ok = false;
            ChangerCouleur(mdp);
        } else
            ReinitialiserCouleur(mdp);

        return ok;
    }

    function ChangerCouleur(objet) {
        objet.setAttribute('style', 'border: 2px solid red;');
    }

    function ReinitialiserCouleur(objet) {
        objet.setAttribute('style', 'border-color: black;');
    }

    function VueMdp() {
        var mdp = document.getElementById("mdp");
        if (mdp.type === "password") {
            mdp.type = "text";
        } else {
            mdp.type = "password";
        }
    }
</script>

</html>