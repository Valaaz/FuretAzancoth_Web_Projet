<?php
include 'connexion.php';

session_start();

$err_theme = array();
if (isset($_POST['valider'])) {
    if (!empty($_POST['theme'])) {

        $theme = htmlentities($_POST['theme']);

        $pdostat = $objPdo->prepare("INSERT INTO `theme`(`description`) VALUES (:theme);");
        $pdostat->bindvalue(':theme', $theme, PDO::PARAM_STR);

        if (!$pdostat->execute()) { // Si le résultat de la requête est faux ou null, c'est qu'il y a eu un problème
            $err_theme[] = 'Erreur MySQL.';
        } else {
            $err_theme[] = 'Thème créé';
            header('location:redaction.php');
        }
    } else {
        $err_theme[] = 'Remplir les champs vides';
    }
}
?>
<html>

<body>
    <form method="post" action="creertheme.php">
        <?php if (!empty($err_theme)) { ?>
            <div class="error"><?php echo implode('<br/>', $err_theme); ?></div>
        <?php     } ?>
        <h1>Créer un theme</h1>
        <label>Ecrivez le titre de votre nouveau thème</label> </br>
        <input type="text" value="" name="theme"> </br>

        <input type="submit" value="Validez" name="valider">
    </form>
</body>

</html>