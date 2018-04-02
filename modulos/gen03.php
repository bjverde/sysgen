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

d($_REQUEST);

$frm->addGroupField('gpx1',Message::GEN02_GPX1_TITLE);
	$html = $frm->addHtmlField('conf','');
$frm->closeGroup();

$frm->addGroupField('gpx2',Message::GPX_TYPE_CONFIG);	
	$logType = array('1'=>'Tudo menos Domain','2'=>'Tudo Mesmo', '3'=>'Nada será logado');
	$frm->addRadioField('logType', Message::FIELD_LOG,true,$logType,null,true,null,3,null,null,null,false);
$frm->closeGroup();

$frm->addButton(Message::BUTTON_LABEL_BACK , 'back' , null, null, null, true, false);
$frm->addButton(Message::BUTTON_LABEL_CLEAN, 'clean', null, null, null, false, false);
$frm->addButton(Message::BUTTON_GEN_FORM, 'Gerar', 'Gerar', null, null, false, false);
$frm->addButton('Post Test', 'Post Test', 'Post Test', null, null, false, false);

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
    
    $listFkFieldsTableSelected = TGeneratorHelper::getFKFieldsTablesSelected();

    $gride = new TGrid('gd'                // id do gride
    		          ,Message::GRID_LIST_FK  // titulo do gride
    		          ,$listFkFieldsTableSelected 	      // array de dados
    		          );
    $gride->setCreateDefaultEditButton(false);
    $gride->setCreateDefaultDeleteButton(false);
    $frm->addHtmlField('gride',$gride);
    
} catch (Exception $e) {
	echo $dao->getError();
	echo $e->getMessage();
	$frm->setMessage( $e->getMessage() );
}


$frm->show();
?>