<link href="css/sysgen_resumo.css" rel="stylesheet" type="text/css" />

<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */
defined('APLICATIVO') or die();

function testar($extensao=null,$html){
	if( extension_loaded($extensao) )	{
		$html->add('<b>'.$extensao.'</b>: <span class="verde">Instalada.</span><br>');
		return true;
	}else {
		$html->add('<b>'.$extensao.'</b>: <span class="failure">Não instalada</span><br>');
		return false;
	}
}

function phpVersionOK(){
	$texto = '<b>Versão do PHP</b>: ';
	if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
		$texto =  $texto.'<span class="verde">'.phpversion().'</span><br>';
	}else{
		$texto =  $texto.'<span class="failure">'.phpversion().' atualize seu sistema para o PHP 5.4.0 ou seperior </span><br>';
	}
	return $texto;
}



$frm = new TForm('Configurações do PHP',500,700);
$frm->setFlat(true);
$frm->setMaximize(true);
$html = $frm->addHtmlField('conf','');


if(TestConfigHelper::phpVersionValid($html)){
		
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
		case 'Salvar':
			if ( $frm->validate() ) {
				$_SESSION[APLICATIVO]['DBMS']=$frm->get('DBMS');
				$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM']=$frm->get('GEN_SYSTEM_ACRONYM');
				$_SESSION[APLICATIVO]['GEN_SYSTEM_NAME']=$frm->get('GEN_SYSTEM_NAME');
				$frm->redirect('gen01.php','Redirect realizado com sucesso.',true);
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