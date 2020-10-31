<?php
include 'connexion.php';

$creertheme = $_POST['creer_theme'];
$titre = $_POST['titre'];
$contenu = $_POST['contenu'];

$err_news = array();
if (isset($_POST['valider'])) {
    if (!empty($_POST['contenu']) && empty($_POST['material'])) {
        if (!empty($_POST['titre']) && !empty($_POST['contenu']) && !empty($_POST['material'])) {
            $pdostat = $objPdo->prepare("INSERT INTO `news`(`idtheme`, `titrenews`, `textenews`, `idredacteur`) VALUES (:creertheme, :titre, :contenu, :redacteur);");
            $pdostat->bindvalue(':creertheme', $creertheme, PDO::PARAM_INT);
            $pdostat->bindvalue(':titre', $titre, PDO::PARAM_STR);
            $pdostat->bindvalue(':contenu', $contenu, PDO::PARAM_STR);
            $pdostat->bindvalue(':redacteur', $_SESSION['id'], PDO::PARAM_INT);
            $err_news[] = 'Coucou';
            header('location:redaction.php');
        } else {
            $err_news[] = 'Remplir les champs vides';
        }
    } else if (!empty($_POST['titre']) && !empty($_POST['contenu']) && !empty($_POST['material'])) {
        $pdostat = $objPdo->prepare("INSERT INTO `news`(`idtheme`, `titrenews`, `textenews`, `idredacteur`) VALUES (:creertheme, :titre, :contenu, :redacteur);");
        $pdostat->bindvalue(':creertheme', $creertheme, PDO::PARAM_INT);
        $pdostat->bindvalue(':titre', $titre, PDO::PARAM_STR);
        $pdostat->bindvalue(':contenu', $contenu, PDO::PARAM_STR);
        $pdostat->bindvalue(':redacteur', 5, PDO::PARAM_INT);
        $err_news[] = 'Coucou 2';
        header('location:redaction.php');
    }
}
?>
<html>

<head>
    <title>Rédaction</title>
</head>

<body>
    <form method="post" action="redaction.php">
        <?php if (!empty($err_news)) { ?>
            <div class="error"><?php echo implode('<br/>', $err_news); ?></div>
        <?php     } ?>
        <h1>Créer une news</h1>
        <label>Titre</label> </br>
        <input type="text" value="" name="titre"> </br>

        <label>Choisir un thème</label> </br>
        <select name='material'>
            <option value=''></option>

            <?php
            $query = $objPdo->prepare("SELECT * FROM theme");
            $query->execute();
            foreach ($query as $row) {
                echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
            }
            ?>
        </select> </br> </br>

        <label>Contenu</label> </br>
        <textarea name="contenu" id="contenu" rows="40" cols="100"> </textarea> </br>

        <input type="submit" value="Validez" name="valider">
    </form>
</body>

</html>