<?php
defined('APLICATIVO') or die();

require_once 'includes/config_conexao.php';

$login = (ArrayHelper::has('USER', $_SESSION[APLICATIVO]) ? $_SESSION[APLICATIVO]['USER']['LOGIN']:null);
$grupo = null;
if (ArrayHelper::has('USER', $_SESSION[APLICATIVO])) {
    $grupo = (ArrayHelper::has('GRUPO_NOME', $_SESSION[APLICATIVO]['USER']) ? $_SESSION[APLICATIVO]['USER']['GRUPO_NOME']:null);
}

$frm = new TForm('Sobre', 400, 500);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addGroupField('gpx1', 'Sistema');
    $frm->addTextField('systemName', 'Sistema:', 50, false, 50, SYSTEM_NAME)->setReadOnly(true);
    $frm->addTextField('systemAcronym', 'Sigla:', 20, false, 50, SYSTEM_ACRONYM)->setReadOnly(true);
    $frm->addTextField('versionSystem', 'Versão do Sistema:', 20, false, 20, SYSTEM_VERSION)->setReadOnly(true);
    $pathChangeLog = 'ajuda/changelog.php';
    $changelog = $frm->addTextField('changelog', 'Arquivo ChangeLog:', 20, false, 20, $pathChangeLog);
;
    $changelog->setReadOnly(true);
    $changelog->setHelpOnLine('ChangeLog', 500, 800, $pathChangeLog);
$frm->closeGroup();


$frm->addGroupField('gpx2', 'Usuário');
    $frm->addTextField('user', 'Usuário Logado:', 50, false, 50, $login)->setReadOnly(true);
    $frm->addTextField('group', 'Grupo:', 50, false, 50, $grupo)->setReadOnly(true);
$frm->closeGroup();

$frm->addGroupField('gpx3', '');
    $frm->addTextField('versionFormDin', 'Versão do FormDin:', 20, false, 20, FORMDIN_VERSION)->setReadOnly(true);
    $frm->addTextField('servidorBD', 'Servidor de Banco:', 20, false, 20, HOST)->setReadOnly(true);
    $frm->addTextField('banco', 'Banco:', 20, false, 20, DATABASE)->setReadOnly(true);
$frm->closeGroup();



$frm->show();
