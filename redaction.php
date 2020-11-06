<?php
include 'connexion.php';

session_start();

$err_news = array();
if (isset($_POST['valider'])) {
    if (!empty($_POST['titre']) && !empty($_POST['choixtheme']) && !empty($_POST['contenu'])) {

        $titre = htmlentities($_POST['titre']);
        $choixtheme = htmlentities($_POST['choixtheme']);
        $contenu = htmlentities($_POST['contenu']);

        $pdostat = $objPdo->prepare("INSERT INTO `news`(`idtheme`, `titrenews`, `textenews`, `idredacteur`) VALUES (:theme, :titre, :contenu, :redacteur);");
        $pdostat->bindvalue(':theme', $choixtheme, PDO::PARAM_INT);
        $pdostat->bindvalue(':titre', $titre, PDO::PARAM_STR);
        $pdostat->bindvalue(':contenu', $contenu, PDO::PARAM_STR);
        $pdostat->bindvalue(':redacteur', $_SESSION['id'], PDO::PARAM_INT);


        if (!$pdostat->execute()) // Si le résultat de la requête est faux ou null, c'est qu'il y a eu un problème
            echo "<script>alert('Erreur MySQL.')</script>";
        else
            header('location:accueil.php');
    } else
        echo "<script>alert('Remplir les champs vides.')</script>";
}
?>

<html>

<head>
    <title>Rédaction</title>
    <link rel="stylesheet" href="css/redaction.css" />
</head>

<body>
    <header>
        <h1>Créer une news</h1>
    </header>
    <form method="post" action="redaction.php" onsubmit="return Valider()" name="formulaire">
        <label>Titre</label> </br>
        <input class="conteneur" type="text" value="" name="titre"> </br>

        <label>Choisir un thème</label> </br>
        <div class="classtheme">
            <select class="theme" name="choixtheme">
                <option value=''></option>

                <?php
                $query = $objPdo->prepare("SELECT * FROM theme");
                $query->execute();
                foreach ($query as $row) {
                    echo '<option value="' . $row['idtheme'] . '">' . $row['description'] . '</option>';
                }
                ?>
            </select> </br> </br>

            <input class="creertheme" type="button" value="Créer un nouveau thème" name="creertheme" onclick="CreerTheme()"> </br>
        </div>

        <label>Contenu</label> </br>
        <textarea class="conteneur" name="contenu" id="contenu" rows="40" cols="100"></textarea> </br>

        <input type="submit" value="Validez" name="valider"> </br>
        <input type="button" value="Retour" name="annuler" onclick="Annuler()"> </br>
    </form>
</body>

<script language="javascript" type="text/javascript">
    function CreerTheme() {
        if (confirm("Voulez-vous créer un nouveau thème ?"))
            window.location.href = "creertheme.php"
    }

    function Annuler() {
        if (confirm("Souhaitez-vous vous annuler la rédaction en cours ?"))
            window.location.href = "accueil.php"
    }

    function Valider() {
        var titre = document.forms['formulaire'].titre;
        var theme = document.forms['formulaire'].choixtheme;
        var contenu = document.forms['formulaire'].contenu;
        var ok = true;

        if (!titre.value.replace(/\s+/, '').length) {
            alert("Titre de la news vide");
            ok = false;
            ChangerCouleur(titre);
        } else
            ReinitialiserCouleur(titre);

        if (!theme.value.replace(/\s+/, '').length) {
            alert("Thème vide");
            ok = false;
            ChangerCouleur(theme);
        } else
            ReinitialiserCouleur(theme);

        if (!contenu.value.replace(/\s+/, '').length) {
            alert("Contenu vide");
            ok = false;
            ChangerCouleur(contenu);
        } else
            ReinitialiserCouleur(contenu);

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