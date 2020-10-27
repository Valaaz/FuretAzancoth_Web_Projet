<?php
session_start();
if (isset($_POST['user'],$_SESSION['mdp'], $_POST['mdp2'])) {
    $bSoumis = 1;
	$mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];
    header('creercompte.php');
    if ($_POST['user'] == 'valaz' && $_POST['mdp'] == 'secret') {
        $_SESSION['isLogged'] = true;
        if (isset($_GET['target'])) {
            header('Location:' . $_GET['target']);
        } else {
            header('Location:accueil.php');
        }
    }
	if ($mdp != $mdp2)
         
        {
            echo 'Les mots de passe ne correspondent pas';
        }
}
if (isset($_SESSION["isLogged"]))
    header('Location:index.php');

if (isset($_POST['url']))
    echo 'Pour accéder à cette page il est nécessaire de se connecter avec votre identifiant :';
?>

<html>

<head>
    <title>Création de compte</title>
</head>

<body>
    <form method="post" action="creercompte.php">
        <h1>Créer un compte</h1>
        <label>Identifiant</label> </br>
        <input type="text" value="" name="user"> </br>
        <label>Mot de passe</label> </br>
        <input type="text" value="" name="mdp"> </br> 
		<label>Confirmation</label> </br>
        <input type="text" value="" name="mdp2"> </br> </br>
        <input type="submit" value="Validez" name="valider">
    </form>
</body>

</html>