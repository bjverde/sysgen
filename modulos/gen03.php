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

$frm = new TForm(Message::GEN03_TITLE, 200, 980);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/sysgen.css');

//d($_REQUEST);

$frm->addGroupField('gpx1', Message::GEN02_GPX1_TITLE);
    $html = $frm->addHtmlField('conf', '');
$frm->closeGroup();

$frm->addGroupField('gpx2', Message::GPX_TYPE_CONFIG);
$logType = array(0=>Message::FIELD_LOGFILE_OPT00,1=>Message::FIELD_LOGFILE_OPT01,2=>Message::FIELD_LOGFILE_OPT02);
    $frm->addRadioField('logType', Message::FIELD_LOGFILE_LABEL, true, $logType, null, true, 2, 3, null, null, null, false);
$frm->closeGroup();


$frm->addGroupField('gpx3',Message::GRID_LIST_FK_COLUMN);
    $frm->addHtmlField('info', null, 'ajuda/info_gen03_typefields_pt-br.php')->setClass('htmlInfo', true);
$frm->closeGroup();


$frm->addButton(Message::BUTTON_LABEL_BACK, 'back', null, null, null, true, false);
$frm->addButton(Message::BUTTON_LABEL_CLEAN, 'clean', null, null, null, false, false);
$frm->addButton(Message::BUTTON_GEN_FORM, 'generate', 'Gerar', null, null, false, false);
//$frm->addButton('Post Test', 'Post Test', 'Post Test', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'back':
        $frm->redirect('gen02.php', 'Redirect realizado com sucesso.', true);
        break;
    //--------------------------------------------------------------------------------
    case 'clean':
        $frm->clearFields();
        break;
    //--------------------------------------------------------------------------------
    case 'generate':
        if ($frm->validate()) {
            try {
                $_SESSION[APLICATIVO]['logType'] = PostHelper::get('logType');
                $fk_type_screen_referenced = PostHelper::get('fk_type_screen_referenced');
                foreach ($fk_type_screen_referenced as $key => $type) {
                    $keyType = $key-1; //change index key
                    $_SESSION[APLICATIVO]['FkFieldsTableSelected']['FK_TYPE_SCREEN_REFERENCED'][$keyType] = $type;
                }
                $frm->redirect('gen04.php', 'Redirect realizado com sucesso.', true);
            } catch (Exception $e) {
                $frm->setMessage($e->getMessage());
            }
        }
        break;
}

try {
    $listTables = TGeneratorHelper::loadTablesSelected();
    
    TGeneratorHelper::createFileMenu($listTables);
    $html->add(TGeneratorHelper::showMsg(true, Message::CREATED_MENU));
    
    $listFkFieldsTableSelected = TGeneratorHelper::listFKFieldsTablesSelected();

    $gride = new TGrid('gd'                          // id do gride
                      , Message::GRID_LIST_FK_TITLE  // titulo do gride
                      , $listFkFieldsTableSelected   // array de dados
                      ,null
                      ,null
                      ,'ID_LINE'
                      );
    
    $gride->setCreateDefaultEditButton(false);
    $gride->setCreateDefaultDeleteButton(false);
    $gride->addRowNumColumn();
    $gride->addColumn('TABLE_SCHEMA', 'TABLE_SCHEMA');
    $gride->addColumn('TABLE_NAME', 'TABLE_NAME');
    $gride->addColumn('COLUMN_NAME', 'COLUMN_NAME');
    $gride->addColumn('DATA_TYPE', 'DATA_TYPE');
    $gride->addColumn('REFERENCED_TABLE_NAME', 'REFERENCED_TABLE_NAME');
    $gride->addColumn('REFERENCED_COLUMN_NAME', 'REFERENCED_COLUMN_NAME');
    $listFkType = TGeneratorHelper::getListFKTypeScreenReferenced();
    $gride->addSelectColumn(TableInfo::FK_TYPE_SCREEN_REFERENCED
        , Message::GRID_LIST_FK_COLUMN
        , TableInfo::FK_TYPE_SCREEN_REFERENCED  //ID no campo na origem dos dados no gride
        , $listFkType                  //Array de possível valores
        , 100                           //5: largura do campo em pixel
        , true                         //6: Somente Leitura
        , ''                           //7: Label do Primeiro elemento
        , 2                            //8: Valor do Primeiro elemento
        , null                         //9:
        , null                         //10:
        , null                         //11:
        );
    $frm->addHtmlField('gride', $gride);
} catch (Exception $e) {
    echo $e->getMessage();
    $frm->setMessage($e->getMessage());
}


$frm->show();
