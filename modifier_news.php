<?php
include 'connexion.php';

session_start();

$err_news = array();
if (isset($_POST['valider'])) {
    if (!empty($_POST['titre']) && !empty($_POST['contenu'])) {

        $titre = htmlentities($_POST['titre']);
        $contenu = htmlentities($_POST['contenu']);

        $suppnews = $objPdo->prepare("UPDATE news SET titrenews = :nouvtitre, textenews = :nouvcontenu WHERE idnews = :idnews");
        $suppnews->bindValue(':nouvtitre', $titre, PDO::PARAM_STR);
        $suppnews->bindValue(':nouvcontenu', $contenu, PDO::PARAM_STR);
        $suppnews->bindValue(':idnews', $_GET['idnews'], PDO::PARAM_INT);

        if (!$suppnews->execute()) { // Si le résultat de la requête est faux ou null, c'est qu'il y a eu un problème
            $err_news[] = 'Erreur MySQL.';
        } else {
            $err_news[] = 'News modifiée';
            header('location:mesnews.php');
        }
    } else {
        $err_news[] = 'Remplir les champs vides';
    }
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
    <form method="post">
        <?php if (!empty($err_news)) { ?>
            <div class="error"><?php echo implode('<br/>', $err_news); ?></div>
        <?php     } ?>
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
</script>

</html>