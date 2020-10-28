<?php
session_start();
if (isset($_POST['user'],$_SESSION['mdp'], $_POST['mdp2'], $_POST['mail'])) {
    $bSoumis = 1;
	$user = $_POST['user'];
	$mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];
	$mail = $_POST['mail'];
	
    header('creercompte.php');
    if ($_POST['user'] == 'valaz' && $_POST['mdp'] == 'secret') {
        $_SESSION['isLogged'] = true;
        if (isset($_GET['target'])) {
            header('Location:' . $_GET['target']);
        } else {
            header('Location:accueil.php');
        }
    }
}
if (isset($_SESSION["isLogged"]))
    header('Location:index.php');

if (isset($_POST['url']))
    echo 'Pour accéder à cette page il est nécessaire de se connecter avec votre identifiant :';

/*include 'connexion.php'

$reponse_user = $bdd->prepare('SELECT user FROM comptes WHERE user = ?');
    $reponse_user->execute(array($user));
    $reponse_user2 = $reponse_user->fetch();
     
    $reponse_mail = $bdd->prepare('SELECT mail FROM comptes WHERE mail = ?');
    $reponse_mail->execute(array($mail));
    $reponse_mail2 = $reponse_mail->fetch();
         
    if (isset($erreur))
         
        {
             
        }
     
    elseif ($reponse_user2)
         
        {
            echo 'Cet utilisateur est déjà utilisé';
        }
         
    elseif ($reponse_mail2)
         
        {
            echo 'Cette adresse mail est déjà utilisé';
        }
         
    elseif ($mdp != $mdp2)
         
        {
            echo 'Les mots de passe sont différents';
        }
         
    else
         
        {
            $mdphacher = sha1($mdp);
             
            echo 'Vous avez bien été inscrit !';
             
            $req = $bdd->prepare('INSERT INTO comptes(user, mdp, email) VALUES(:user, :mdp, :email)');
            $req->execute(array(
                'pseudo' => $user,
                'mdp' => $mdphacher,
                'email' => $mail
                ));
        }
         
    }*/
?>

<html>

<head>
    <title>Création de compte</title>
</head>

<body>
    <form method="post" action="creercompte.php">
		<?php if (!empty($err_connexion)) { ?>
            <div class="error"><?php echo implode('<br/>', $err_connexion); ?></div>
        <?php     } ?>
        <h1>Créer un compte</h1>
        <label>Identifiant</label> </br>
        <input type="text" value="" name="user"> </br>
		<label>Mail</label> </br>
		<input type="text" value="" name="mail>  </br>
        <label>Mot de passe</label> </br>
        <input type="text" value="" name="mdp"> </br> 
		<label>Confirmation</label> </br>
        <input type="text" value="" name="mdp2"> </br> </br>
        <input type="submit" value="Validez" name="valider">
    </form>
</body>

</html>