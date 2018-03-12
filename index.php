<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */

//Constantes e configurações
require_once('includes/constantes.php');

include ('../base/classes/webform/TApplication.class.php');


$app = new TApplication(); // criar uma instancia do objeto aplicacao
$app->setTitle(SYSTEM_NAME);
$app->setSUbTitle(SYSTEM_NAME_SUB);
$app->setSigla(SYSTEM_ACRONYM);
$app->setVersionSystem(SYSTEM_VERSION);

$app->setUnit('Show Me the code');
$app->setLoginInfo('Bem-vindo');
$app->setMainMenuFile('includes/menu.php');
$app->setWaterMark('brasao_marca_dagua.png');

/*
$app->setLoginFile('sysview/login.php');
if (ArrayHelper::has('USER', $_SESSION[APLICATIVO]) ){
	$app->setLoginInfo($_SESSION[APLICATIVO]['USER']['LOGIN']);
}
*/


$app->setMenuIconsPath('images/');
$app->setMainMenuFile('includes/menu.php');
$app->run();
?>