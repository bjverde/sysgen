<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */
defined('APLICATIVO') or die();

$frm = new TForm('Gerador',500,700);
$frm->setFlat(true);
$frm->setMaximize(true);


$dbType = array(DBMS_MYSQL=>'MySQL',DBMS_SQLITE=>'SQLITE',DBMS_SQLSERVER=>'MS SQL SERVER',DBMS_POSTGRES =>'POSTGRES', DBMS_ORACLE => 'ORACLE',DBMS_ACCESS => 'ACCESS',DBMS_FIREBIRD => 'FIREBIRD');
$frm->addSelectField('TPBANCO','Escolha o tipo de Banco de Dados:',null,$dbType,null,null,'0');

$frm->addTextField('GEN_SYSTEM_ACRONYM', 'Sigla do Sistema',50,true);
$frm->addTextField('GEN_SYSTEM_NAME', 'Nome do sistem',50,true);


$frm->addButton('Salvar', null, 'Salvar', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$frm->setVo( $vo );
			if($resultado==1) {
				$frm->setMessage('Registro gravado com sucesso!!!');
				$frm->clearFields();
			}else{
				$frm->setMessage($resultado);
			}
		}
	break;
	//--------------------------------------------------------------------------------
	case 'Limpar':
		$frm->clearFields();
	break;
}



$frm->show();

?>