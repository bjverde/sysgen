<?php
defined('APLICATIVO') or die();

$login = ( array_key_exists('USER',$_SESSION[APLICATIVO]) ? $_SESSION[APLICATIVO]['USER']['LOGIN']:null );
$grupo = ( array_key_exists('USER',$_SESSION[APLICATIVO]) ? $_SESSION[APLICATIVO]['USER']['GRUPO_NOME']:null );

$frm = new TForm('Sobre',300,500);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addTextField('systemName', 'Sistema:',50,false,50,SYSTEM_NAME)->setReadOnly(true);
$frm->addTextField('systemAcronym', 'Sigla:',20,false,50,SYSTEM_ACRONYM)->setReadOnly(true);
$frm->addTextField('versionSystem', 'Versão do Sistema:',20,false,20,SYSTEM_VERSION)->setReadOnly(true);
$frm->addHtmlField('html1','');
$frm->addTextField('user', 'Usuário Logado:',50,false,50,$login)->setReadOnly(true);
$frm->addTextField('group','Grupo:',50,false,50,$grupo )->setReadOnly(true);
$frm->addHtmlField('html2','');
$frm->addTextField('versionFormDin', 'Versão do FormDin:',20,false,20,FORMDIN_VERSION)->setReadOnly(true);
$frm->addHtmlField('html3','');
$pathChangeLog = 'ajuda/changelog.php';
$frm->addTextField('changelog', 'Arquivo ChangeLog:',20,false,20,$pathChangeLog)->setReadOnly(true);
$frm->addBoxField('bxchangelog',null,$pathChangeLog,'ajax',null,null,null,null,null,'Ver arquivo de ajuda');

$frm->show();
?>