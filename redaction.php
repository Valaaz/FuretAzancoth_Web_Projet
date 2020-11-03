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


        if (!$pdostat->execute()) { // Si le résultat de la requête est faux ou null, c'est qu'il y a eu un problème
            $err_news[] = 'Erreur MySQL.';
        } else {
            $err_news[] = 'News créée';
            header('location:accueil.php');
        }
    } else {
        $err_news[] = 'Remplir les champs vides';
    }
}
?>

<html>

<head>
    <title>Rédaction</title>
    <link rel="stylesheet" href="css/redaction.css" />
</head>

<body>
    <header>
    </header>
    <form method="post" action="redaction.php">
        <?php if (!empty($err_news)) { ?>
            <div class="error"><?php echo implode('<br/>', $err_news); ?></div>
        <?php     } ?>
        <h1>Créer une news</h1>
        <label>Titre</label> </br>
        <input type="text" value="" name="titre"> </br>

        <label>Choisir un thème</label> </br>
        <select name="choixtheme">
            <option value=''></option>

            <?php
            $query = $objPdo->prepare("SELECT * FROM theme");
            $query->execute();
            foreach ($query as $row) {
                echo '<option value="' . $row['idtheme'] . '">' . $row['description'] . '</option>';
            }
            ?>
        </select> </br> </br>

        <input type="button" value="Créer un nouveau thème" name="creertheme" onclick="CreerTheme()"> </br>

        <label>Contenu</label> </br>
        <textarea name="contenu" id="contenu" rows="40" cols="100"></textarea> </br>

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
</script>

</html>