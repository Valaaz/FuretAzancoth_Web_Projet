<?php
include 'connexion.php';

session_start();

if (isset($_POST['valider'])) {
    if (!empty($_POST['titre']) && !empty($_POST['contenu'])) {

        $titre = htmlentities($_POST['titre']);
        $contenu = htmlentities($_POST['contenu']);

        $modifnews = $objPdo->prepare("UPDATE news SET titrenews = :nouvtitre, textenews = :nouvcontenu WHERE idnews = :idnews");
        $modifnews->bindValue(':nouvtitre', $titre, PDO::PARAM_STR);
        $modifnews->bindValue(':nouvcontenu', $contenu, PDO::PARAM_STR);
        $modifnews->bindValue(':idnews', $_GET['idnews'], PDO::PARAM_INT);

        if (!$modifnews->execute())  // Si le résultat de la requête est faux ou null, c'est qu'il y a eu un problème
            echo "<script>alert('Erreur MySQL.')</script>";
        else
            header('location:mesnews.php');
    } else
        echo "<script>alert('Remplir les champs vides.')</script>";
}
?>

<html>

<head>
    <title>Modifier une news</title>
    <link rel="stylesheet" href="css/redaction.css" />
</head>

<body>
    <header>
        <h1>Modifier une news</h1>
    </header>

    <hr>

    <form method="post" onsubmit="return Valider()" name="formulaire">
        <label>Titre</label> </br>
        <input class="conteneur" id="titre" type="text" value="<?php echo $_GET['titre'] ?>" name="titre"> </br>

        <label>Contenu</label> </br>
        <textarea class="conteneur" name="contenu" id="contenu" rows="40" cols="100" wrap="hard"><?php echo $_GET['contenu'] ?></textarea> </br>

        <div class="bouton">
            <input class="valid" type="submit" value="Valider" name="valider">
            <input class="retour" type="button" value="Retour" name="annuler" onclick="Annuler()">
        </div>
    </form>
</body>


<script language="javascript" type="text/javascript">
    function Annuler() {
        if (confirm("Souhaitez-vous vous annuler la rédaction en cours ?"))
            window.location.href = "mesnews.php"
    }

    function Valider() {
        var titre = document.forms['formulaire'].titre;
        var contenu = document.forms['formulaire'].contenu;
        var ok = true;

        if (!titre.value.replace(/\s+/, '').length) {
            alert("Titre de la news vide");
            ok = false;
            ChangerCouleur(titre);
        } else
            ReinitialiserCouleur(titre);

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
        objet.setAttribute('style', 'border: 2 px solid# C09E73;');
        objet.setAttribute('style', 'border-radius: 5 px;')
    }
</script>

</html>