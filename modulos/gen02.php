<link href="css/sysgen_resumo.css" rel="stylesheet" type="text/css" />
<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */
defined('APLICATIVO') or die();

$frm = new TForm(Message::GEN02_TITLE,500,700);
$frm->setFlat(true);
$frm->setMaximize(true);

if (!ArrayHelper::has('USER', $_SESSION[APLICATIVO]['DBMS']) ){
	$frm->redirect('gen01.php','Seu Mané teste as configurações de banco!!',true);
}

$frm->addGroupField('gpx1',Message::GEN02_GPX1_TITLE);
	$html = $frm->addHtmlField('conf','');
$frm->closeGroup();

$frm->addButton('Voltar', null, 'Voltar', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);
$frm->addButton('Gerar estrutura', 'Gerar', 'Gerar', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Voltar':
		$frm->redirect('gen01.php','Redirect realizado com sucesso.',true);
		break;
		//--------------------------------------------------------------------------------
	case 'Limpar':
		$frm->clearFields();
		break;
		//--------------------------------------------------------------------------------
	case 'Gerar':
		$frm->redirect('gen02.php','Redirect realizado com sucesso.',true);
		break;
}


try {
	$path = ROOT_PATH.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
	FolderHelper::mkDir($path);
	$html->add(TestConfigHelper::showMsg(true, Message::GEN02_MKDIR_SYSTEM.$path));
	
	FolderHelper::copySystemSkeletonToNewSystem();
	
	$dbType   = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
	$user     = $_SESSION[APLICATIVO]['DBMS']['USER'];
	$password = $_SESSION[APLICATIVO]['DBMS']['PASSWORD'];
	$dataBase = $_SESSION[APLICATIVO]['DBMS']['DATABASE'];
	$host     = $_SESSION[APLICATIVO]['DBMS']['HOST'];
	$port     = $_SESSION[APLICATIVO]['DBMS']['PORT'];
	$schema   = $_SESSION[APLICATIVO]['DBMS']['SCHEMA'];
	
	$dao = new TDAO(null,$dbType,$user,$password,$dataBase,$host,$port,$schema);
	$dados = $dao->loadTablesFromDatabase();
	
	$gride = new TGrid( 'gd'        // id do gride
			,'Lista de Tabelas'     // titulo do gride
			,$dados 	      // array de dados
			);
	$gride->setCreateDefaultEditButton(false);
	$gride->setCreateDefaultDeleteButton(false);
	$frm->addHtmlField('gride',$gride);
} catch (Exception $e) {
	echo $dao->getError();
	echo $e->getMessage();
}

$frm->show();
?>