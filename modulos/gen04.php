<?php
/**
 * SysGen - System Generator with Formdin Framework
 * Download Formdin Framework: https://github.com/bjverde/formDin 
 *
 * @author  Bjverde <bjverde@yahoo.com.br>
 * @license https://github.com/bjverde/sysgen/blob/master/LICENSE GPL-3.0
 * @link    https://github.com/bjverde/sysgen
 *
 * PHP Version 5.6
 */
defined('APLICATIVO') or die();

$frm = new TForm(Message::GEN04_TITLE,200,900);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/sysgen.css');

$frm->addGroupField('gpx1',Message::GEN02_GPX1_TITLE);
	$html = $frm->addHtmlField('conf','');
$frm->closeGroup();

$frm->addButton(Message::BUTTON_LABEL_BACK , 'back' , null, null, null, true, false);
$frm->addButton(Message::BUTTON_LABEL_CLEAN, 'clean', null, null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'back':
		$frm->redirect('gen03.php','Redirect realizado com sucesso.',true);
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
	    $tableSchema = $listTables['TABLE_SCHEMA'][$key];
		$listFieldsTable = TGeneratorHelper::loadFieldsTablesSelectedWithFormDin($table,$tableSchema);
		$tableType = strtoupper($listTables['TABLE_TYPE'][$key]);
		$key = $key + 1;
		if($tableType == TGeneratorHelper::TABLE_TYPE_TABLE){
		    TGeneratorHelper::createFilesFormClassDaoVoFromTable($table, $listFieldsTable,$tableSchema,$tableType);
			$html->add('<br>'.$key.Message::CREATED_TABLE_ITEN.$table);
		}else{
		    TGeneratorHelper::createFilesFormClassDaoVoFromTable($table, $listFieldsTable,$tableSchema,$tableType);
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
	echo $e->getMessage();
	$frm->setMessage( $e->getMessage() );
}


$frm->show();
?>