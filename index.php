<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 *
 * @author  Bjverde <bjverde@yahoo.com.br>
 * @license https://github.com/bjverde/sysgen/blob/master/LICENSE GPL-3.0
 * @link    https://github.com/bjverde/sysgen
 *
 * PHP Version 5.6
 */

//Constantes e configurações
require_once 'includes/constantes.php';
require_once '../base/classes/webform/TApplication.class.php';
require_once 'classes/autoload_sysgen.php';


$app = new TApplication(); // criar uma instancia do objeto aplicacao
$app->setTitle(SYSTEM_NAME);
$app->setSUbTitle(SYSTEM_NAME_SUB);
$app->setSigla(SYSTEM_ACRONYM);
$app->setVersionSystem(SYSTEM_VERSION);

$app->setUnit('Show Me the code');
$app->setLoginInfo('Feito é melhor que perfeito !!<br>v'.SYSTEM_VERSION);
$app->setMainMenuFile('includes/menu.php');

$app->setWaterMark('images/2-code-gen-database-first.png');
$app->setMainMenuFile('includes/menu.php');
$app->setDefaultModule('gen00.php');
$app->run();
?>
