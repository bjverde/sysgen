<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */
defined('APLICATIVO') or die();

$frm = new TForm(Message::GEN00_TITLE,200,600);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/sysgen.css');


$html = $frm->addHtmlField('conf','');
$frm->addHtmlField('info', null, 'ajuda/info_gen00_pt-br.php')->setClass('htmlInfo',true);


if(TGeneratorHelper::phpVersionValid($html)){
		
	$dbType = array(DBMS_MYSQL=>'MySQL'
			       ,DBMS_SQLITE=>'SQLITE'
			       ,DBMS_SQLSERVER=>'MS SQL SERVER'
			       ,DBMS_ACCESS =>'ACCESS'
			       ,DBMS_FIREBIRD => 'FIREBIRD'
			       ,DBMS_ORACLE =>'ORACLE'
			       ,DBMS_POSTGRES =>'POSTGRES'
			       );
	$frm->addSelectField('DBMS','Escolha o tipo de Banco de Dados:',true,$dbType,null,null,null,null,null,null,' ',0);	
	$frm->addTextField('GEN_SYSTEM_ACRONYM', 'Sigla do Sistema',50,true);
	$frm->addTextField('GEN_SYSTEM_NAME', 'Nome do sistem',50,true);
	
	
	$frm->addButton('Continuar', null, 'Continuar', null, null, true, false);
	$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);
	
	$acao = isset($acao) ? $acao : null;
	switch( $acao ) {
		case 'Continuar':
			if ( $frm->validate() ) {
				try{
					$GEN_SYSTEM_ACRONYM = strtolower($frm->get('GEN_SYSTEM_ACRONYM'));
					TGeneratorHelper::validateFolderName($GEN_SYSTEM_ACRONYM);
					$_SESSION[APLICATIVO]=null;
					$_SESSION[APLICATIVO]['DBMS']['TYPE']=$frm->get('DBMS');
					$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM']=$GEN_SYSTEM_ACRONYM;
					$_SESSION[APLICATIVO]['GEN_SYSTEM_NAME']=$frm->get('GEN_SYSTEM_NAME');
					$frm->redirect('gen01.php','Redirect realizado com sucesso.',true);
				} catch (Exception $e) {
					$frm->setMessage( $e->getMessage() );
				}
			}
			break;
			//--------------------------------------------------------------------------------
		case 'Limpar':
			$frm->clearFields();
			break;
	}
}

$frm->show();
?>