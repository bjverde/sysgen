<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */
defined('APLICATIVO') or die();

$frm = new TForm(Message::GEN02_TITLE,200,700);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/sysgen.css');

if (!ArrayHelper::has('USER', $_SESSION[APLICATIVO]['DBMS']) ){
    $frm->redirect('gen01.php',Message::GEN02_NOT_READY,true);
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
	    if(ArrayHelper::has('idTableNameSelected', $_POST)){
	       $_SESSION[APLICATIVO]['idTableNameSelected'] = $_POST['idTableNameSelected'];
	       $frm->redirect('gen03.php',Message::GEN02_REDIRECT_STEP03,true);
	    }else{
	        $frm->setMessage(Message::WARNING_NO_TABLE);
	    }
		break;
}


try {	
	$listTables = TGeneratorHelper::loadTablesFromDatabase();
	
	$path = ROOT_PATH.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
	TGeneratorHelper::mkDir($path);
	$html->add(TGeneratorHelper::showMsg(true, Message::GEN02_MKDIR_SYSTEM.$path));
	TGeneratorHelper::copySystemSkeletonToNewSystem();
	$html->add(TGeneratorHelper::showMsg(true, Message::GEN02_COPY_SYSTEM_SKELETON));
	TGeneratorHelper::createFileConstants();
	$html->add(TGeneratorHelper::showMsg(true, Message::GEN02_CREATED_CONSTANTS));
	TGeneratorHelper::createFileConfigDataBase();
	$html->add(TGeneratorHelper::showMsg(true, Message::GEN02_CREATED_CONFIG_DATABASE));
	TGeneratorHelper::createFileAutoload();
	$html->add(TGeneratorHelper::showMsg(true, Message::GEN02_CREATED_AUTOLOAD));
	TGeneratorHelper::createFileIndex();
	$html->add(TGeneratorHelper::showMsg(true, Message::GEN02_CREATED_INDEX));
	$_SESSION[APLICATIVO]['STEP2']=true;
	
	$gride = new TGrid('gd'        // id do gride
			          ,'Lista de Tabelas'     // titulo do gride
			          ,$listTables 	      // array de dados
			          );
	$gride->setCreateDefaultEditButton(false);
	$gride->setCreateDefaultDeleteButton(false);
	
	$gride->addColumn('TABLE_SCHEMA','TABLE_SCHEMA');
	$gride->addCheckColumn('idTableNameSelected','TABLE_NAME','TABLE_NAME','TABLE_NAME',true,true);
	$gride->addColumn('COLUMN_QTD','COLUMN_QTD');
	$gride->addColumn('TABLE_TYPE','TABLE_TYPE');
	
	$frm->addHtmlField('gride',$gride);
} catch (Exception $e) {
	echo $e->getMessage();
	$frm->setMessage( $e->getMessage() );
}


$frm->show();
?>