<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */
defined('APLICATIVO') or die();

$frm = new TForm('Tabelas do Banco',200,450);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addHtmlField('gd','');

$dbType   = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
$user     = $_SESSION[APLICATIVO]['DBMS']['USER'];
$password = $_SESSION[APLICATIVO]['DBMS']['PASSWORD'];
$dataBase = $_SESSION[APLICATIVO]['DBMS']['DATABASE'];
$host     = $_SESSION[APLICATIVO]['DBMS']['HOST'];
$port     = $_SESSION[APLICATIVO]['DBMS']['PORT'];
$schema   = $_SESSION[APLICATIVO]['DBMS']['SCHEMA'];  

$dao = new TDAO(null,$dbType,$user,$password,$dataBase,$host,$port,$schema);
$dados = $dao->loadFieldsFromDatabase();
if( ! $dao->getError() ) {
	$g = new TGrid('gd','Resultado SQL',$dados);
	$g->setCreateDefaultEditButton(false);
	$g->setCreateDefaultDeleteButton(false);
	prepareReturnAjax(2,null,$g->show(false));
}
prepareReturnAjax(0,null, $dao->getError());

$frm->show();
?>