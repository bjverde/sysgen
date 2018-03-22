<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */
defined('APLICATIVO') or die();

$frm = new TForm(Message::GEN03_TITLE,200,900);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/sysgen.css');

if (!ArrayHelper::has('STEP2', $_SESSION[APLICATIVO]) ){
	$frm->redirect('gen02.php','Seu Mané teste as configurações de banco!!',true);
}

$frm->addGroupField('gpx1',Message::GEN02_GPX1_TITLE);
	$html = $frm->addHtmlField('conf','');
$frm->closeGroup();

$frm->addButton(Message::BUTTON_LABEL_BACK , 'back' , null, null, null, true, false);
$frm->addButton(Message::BUTTON_LABEL_CLEAN, 'clean', null, null, null, false, false);

d($_POST);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'back':
		$frm->redirect('gen02.php','Redirect realizado com sucesso.',true);
		break;
		//--------------------------------------------------------------------------------
	case 'clean':
		$frm->clearFields();
		break;
}


try {
    $listTables = TGeneratorHelper::loadTablesSelected();
    
    TGeneratorHelper::createFileMenu($listTables);
    $html->add(TGeneratorHelper::showMsg(true, Message::CREATED_MENU));
    
	$html->add(TGeneratorHelper::showMsg(true,Message::NEW_SYSTEM_OK));
	$html->add('<a href="'.TGeneratorHelper::getUrlNewSystem().'" target="_blank">'.TGeneratorHelper::getUrlNewSystem().'</a>');
	$html->add('<br>');

	foreach ($listTables['TABLE_NAME'] as $key=>$table){
	    $schema = $listTables['TABLE_SCHEMA'][$key];
	    $dao = TGeneratorHelper::getTDAOConect($table,$schema);
		$listFieldsTable = $dao->loadFieldsOneTableFromDatabase();
		$tableType = strtoupper($listTables['TABLE_TYPE'][$key]);
		$key = $key + 1;
		if($tableType == 'TABLE'){
		    TGeneratorHelper::createFilesDaoVoFromTable($table, $listFieldsTable);
		    TGeneratorHelper::createFilesClasses($table, $listFieldsTable);
			TGeneratorHelper::createFilesForms($table, $listFieldsTable);
			$html->add('<br>'.$key.Message::CREATED_TABLE_ITEN.$table);
		}else{
		    TGeneratorHelper::createFilesDaoVoFromTable($table, $listFieldsTable);
		    $html->add('<br>'.$key.Message::CREATED_VIEW_ITEN.$table);
		}
		
		$gride = new TGrid( 'gd'      // id do gride
		                   ,$key.Message::FIELDS_TABLE_VIEW.$table   // titulo do gride
				           ,$listFieldsTable 	      // array de dados
				           );
		$gride->setCreateDefaultEditButton(false);
		$gride->setCreateDefaultDeleteButton(false);
		$frm->addHtmlField('gride'.$table,$gride);
	}

} catch (Exception $e) {
	echo $dao->getError();
	echo $e->getMessage();
}


$frm->show();
?>