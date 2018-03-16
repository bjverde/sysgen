<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */


// 
//Constantes e configurações
require_once('includes/constantes.php');
require_once('classes/FolderHelper.class.php');
require_once('classes/Message.class.php');
require_once('classes/TestConfigHelper.class.php');

include ('../base/classes/webform/TApplication.class.php');


$app = new TApplication(); // criar uma instancia do objeto aplicacao
$app->setTitle(SYSTEM_NAME);
$app->setSUbTitle(SYSTEM_NAME_SUB);
$app->setSigla(SYSTEM_ACRONYM);
$app->setVersionSystem(SYSTEM_VERSION);

$app->setUnit('Show Me the code');
$app->setLoginInfo('Feito é melhor que perfeito !!');
$app->setMainMenuFile('includes/menu.php');

/*
$app->setLoginFile('sysview/login.php');
if (ArrayHelper::has('USER', $_SESSION[APLICATIVO]) ){
	$app->setLoginInfo($_SESSION[APLICATIVO]['USER']['LOGIN']);
}
*/


//$app->setMenuIconsPath('images/');
$app->setWaterMark('images/2-code-gen-database-first.png');
$app->setMainMenuFile('includes/menu.php');
$app->setDefaultModule('gen00.php');
$app->run();
?>