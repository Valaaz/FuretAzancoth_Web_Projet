<?php
    session_start();
	
    if (isset($_SESSION['isLogged']))
    {
        session_unset();
        session_destroy();
    }
   ?> header('Location:accueil.php');
	
	<html>

<head>
    <title>Déconnexion</title>
</head>

<body>
</body>
<script language=" javascript " type="text/javascript">
        function MessageAlerte(message)
        {
            if ( confirm( "Message à afficher" ) ) {} 
			else {}
        }
    </script>

</html>