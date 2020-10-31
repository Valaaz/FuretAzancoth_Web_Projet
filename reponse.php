<?php
	header('Content-Type:text/xml');
	echo "<?xml version=\"1.0\" encoding='UTF-8'?>\n";
	echo "<sites>\n";
	include("connexion.php");
	$debut = $_GET['Choix'];
	$strSql = "SELECT * FROM theme";
	$result = $objPdo->Prepare($strSql);
	$result->execute();
	foreach ($result as $row) {
    echo "<theme>" . $row['description'] . "</theme>";
}
echo "</sites>\n";