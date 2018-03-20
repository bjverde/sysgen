<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */

//Constantes e configurações
require_once('includes/constantes.php');
require_once('../base/classes/webform/TApplication.class.php');
require_once('classes/autoload_sysgen.php');


$app = new TApplication(); // criar uma instancia do objeto aplicacao
$app->setTitle(SYSTEM_NAME);
$app->setSUbTitle(SYSTEM_NAME_SUB);
$app->setSigla(SYSTEM_ACRONYM);
$app->setVersionSystem(SYSTEM_VERSION);

$app->setUnit('Show Me the code');
$app->setLoginInfo('Feito é melhor que perfeito !!<br>'.SYSTEM_VERSION);
$app->setMainMenuFile('includes/menu.php');

$app->setWaterMark('images/2-code-gen-database-first.png');
$app->setMainMenuFile('includes/menu.php');
$app->setDefaultModule('gen00.php');
$app->run();
?>