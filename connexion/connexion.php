<?php
$db_config = array();
$db_config['SGBD'] = 'mysql';
$db_config['HOST'] = 'devbdd.iutmetz.univ-lorraine.fr';
$db_config['DB_NAME'] = 'azancoth1u_ProjetWeb';
$db_config['USER'] = 'azancoth1u_appli';
$db_config['PASSWORD'] = '31901886';
try {
    $objPdo = new PDO($db_config['SGBD'] . ':host=' . $db_config['HOST'] . ';dbname=' .
        $db_config['DB_NAME'], $db_config['USER'], $db_config['PASSWORD'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    //echo '<span style="display: none;">connexion ok</span>';
    unset($db_config);
} catch (Exception $exception) {
    die($exception->getMessage());
}
