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

$frm->addButton(Message::BUTTON_LABEL_BACK , 'back' , null, null, null, true, false);
$frm->addButton(Message::BUTTON_LABEL_CLEAN, 'clean', null, null, null, false, false);
$frm->addButton(Message::BUTTON_LABEL_CONF, 'Gerar', 'Gerar', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'back':
		$frm->redirect('gen01.php','Redirect realizado com sucesso.',true);
		break;
		//--------------------------------------------------------------------------------
	case 'clean':
		$frm->clearFields();
		break;
		//--------------------------------------------------------------------------------
	case 'Gerar':
	    if(ArrayHelper::has('idTableSelected', $_POST)){
	       $_SESSION[APLICATIVO]['idTableSelected'] = $_POST['idTableSelected'];
	       $frm->redirect('gen03.php',Message::GEN02_REDIRECT_STEP03,true);
	    }else{
	        $frm->setMessage(Message::WARNING_NO_TABLE);
	    }
		break;
}


try {	
	$listTablesAll = TGeneratorHelper::loadTablesFromDatabase();
	
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
	$html->add('<br>');
	$html->add('<br>');
	$html->add(Message::SEL_TABLES_GENERATE);
	
	$gride = new TGrid('gd'        // id do gride
			          ,'Lista de Tabelas'     // titulo do gride
	                  ,$listTablesAll 	      // array de dados
			          );
	$gride->setCreateDefaultEditButton(false);
	$gride->setCreateDefaultDeleteButton(false);
	
	$gride->addColumn('TABLE_SCHEMA','TABLE_SCHEMA');
	$gride->addCheckColumn('idTableSelected','TABLE_NAME','idSelected','TABLE_NAME',true,true);
	$gride->addColumn('COLUMN_QTD','COLUMN_QTD');
	$gride->addColumn('TABLE_TYPE','TABLE_TYPE');
	
	$frm->addHtmlField('gride',$gride);
} catch (Exception $e) {
	echo $e->getMessage();
	$frm->setMessage( $e->getMessage() );
}


$frm->show();
?>