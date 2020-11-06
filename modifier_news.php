<?php
include 'connexion.php';

session_start();

if (isset($_POST['valider'])) {
    if (!empty($_POST['titre']) && !empty($_POST['contenu'])) {

        $titre = htmlentities($_POST['titre']);
        $contenu = htmlentities($_POST['contenu']);

        $suppnews = $objPdo->prepare("UPDATE news SET titrenews = :nouvtitre, textenews = :nouvcontenu WHERE idnews = :idnews");
        $suppnews->bindValue(':nouvtitre', $titre, PDO::PARAM_STR);
        $suppnews->bindValue(':nouvcontenu', $contenu, PDO::PARAM_STR);
        $suppnews->bindValue(':idnews', $_GET['idnews'], PDO::PARAM_INT);

        if (!$suppnews->execute())  // Si le résultat de la requête est faux ou null, c'est qu'il y a eu un problème
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
    </header>
    <form method="post" onsubmit="return Valider()" name="formulaire">
        <h1>Modifier une news</h1>
        <label>Titre</label> </br>
        <input type="text" value="<?php echo $_GET['titre'] ?>" name="titre"> </br>

        <label>Contenu</label> </br>
        <textarea name="contenu" id="contenu" rows="40" cols="100"><?php echo $_GET['contenu'] ?></textarea> </br>

        <input type="submit" value="Validez" name="valider"> </br>
        <input type="button" value="Retour" name="annuler" onclick="Annuler()"> </br>
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
        objet.setAttribute('style', 'border-color: black;');
    }
</script>

</html>