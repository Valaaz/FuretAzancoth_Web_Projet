<?php
include '../connexion/connexion.php';

session_start();

if (isset($_POST['valider'])) {
    if (!empty($_POST['theme'])) {

        $theme = htmlentities($_POST['theme']);

        $pdostat = $objPdo->prepare("INSERT INTO `theme`(`description`) VALUES (:theme);");
        $pdostat->bindvalue(':theme', $theme, PDO::PARAM_STR);

        if (!$pdostat->execute()) // Si le résultat de la requête est faux ou null, c'est qu'il y a eu un problème
            echo "<script>alert('Erreyr MySQL.')</script>";
        else
            header('location:./redaction.php');
    } else
        echo "<script>alert(Remplir les champs vides.')</script>";
}
?>
<html>

<head>
    <title>Nouveau thème</title>
    <link rel="stylesheet" href="../css/creertheme.css" />
</head>

<body>
    <header>
        <h1>Créer un theme</h1>
    </header>

    <hr>

    <form method="post" action="creertheme.php" onsubmit="return Valider()" name="formulaire">
        <label>Ecrivez le titre de votre nouveau thème</label> </br>
        <input type="text" value="" name="theme"> </br>

        <div class="bouton">
            <input class="valid" type="submit" value="Valider" name="valider">
            <input class="retour" type="button" value="Retour" name="annuler" onclick="Annuler()">
        </div>
    </form>
</body>

<script language="javascript" type="text/javascript">
    function Annuler() {
        if (confirm("Souhaitez-vous vous annuler la création d'un nouveau thème ?"))
            window.location.href = "./redaction.php"
    }

    function Valider() {
        var theme = document.forms['formulaire'].theme;
        var ok = true;

        if (!theme.value.replace(/\s+/, '').length) {
            alert("Thème vide");
            ok = false;
            ChangerCouleur(theme);
        } else
            ReinitialiserCouleur(theme);

        return ok;
    }

    function ChangerCouleur(objet) {
        objet.setAttribute('style', 'border: 2px solid red;');
    }

    function ReinitialiserCouleur(objet) {
        objet.setAttribute('style', 'border: 2 px solid# C09E73;');
        objet.setAttribute('style', 'border-radius: 5 px;')
    }
</script>

</html>