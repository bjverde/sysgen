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
$_SESSION[APLICATIVO] = null;

$frm = new TForm(Message::GEN00_TITLE, 800, 600);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/sysgen.css');

$frm->addGroupField('gpx1', 'Requisitos');
    $htmlConfig = $frm->addHtmlField('conf', '');
    $validFormDinPMin = TGeneratorHelper::validadeFormDinMinimumVersion($htmlConfig);
    $validPHPMin = TGeneratorHelper::validadePhpMinimumVersion($htmlConfig);
$frm->closeGroup();

if ($validFormDinPMin && $validPHPMin) {
    
    $frm->addGroupField('gpx2', null);
        $frm->addHtmlField('info', null, 'ajuda/info_gen00_info_pt-br.php')->setClass('htmlInfo', true);
    $frm->closeGroup();

    $frm->addGroupField('gpxTpSystem', Message::GPX_TYPE_SYSTEM);
        $frm->addHtmlField('info', null, 'ajuda/info_gen00_tpsys_pt-br.php')->setClass('htmlInfo', true);
        $listTpSystem = TGeneratorHelper::getListTypeSystem();
        $frm->addRadioField(TableInfo::TP_SYSTEM, Message::FIELD_TP_SYSTEM, true, $listTpSystem, null, true, TGeneratorHelper::TP_SYSTEM_FORM, 3, null, null, null, false);
    $frm->closeGroup();
    
    $frm->addGroupField('gpxEasyLabel', Message::GPX_EASYLABEL);
        $frm->addHtmlField('info', null, 'ajuda/info_gen00_easylabel_pt-br.php')->setClass('htmlInfo', true);
        $listTpSystem = array('Y'=>'Sim','N'=>'Não');
        $frm->addRadioField('EASYLABEL', Message::FIELD_TP_SYSTEM, true, $listTpSystem, null, true, 'Y', 3, null, null, null, false);
    $frm->closeGroup(); 

    $frm->addGroupField('gpx3', Message::GEN00_GPX3_TITLE);
        $dbType = array(DBMS_MYSQL =>'MySQL'
                       ,DBMS_SQLITE=>'SQLITE'
                       ,DBMS_SQLSERVER=>'MS SQL SERVER'
                       ,DBMS_POSTGRES =>'POSTGRES'
                       ,DBMS_ACCESS   =>'ACCESS'
                       ,DBMS_FIREBIRD =>'FIREBIRD'
                       ,DBMS_ORACLE   =>'ORACLE'
                       );
        $frm->addHtmlField('fields', null, 'ajuda/info_gen00_fields_pt-br.php')->setClass('htmlInfo', true);
        $frm->addSelectField('DBMS', 'Escolha o tipo de Banco de Dados:', true, $dbType, null, null, null, null, null, null, ' ', 0);
        $frm->addTextField('GEN_SYSTEM_ACRONYM', 'Sigla do Sistema', 50, true);
        $frm->addTextField('GEN_SYSTEM_VERSION', 'Versão do sistema', 10, true, 10, '0.0.0');
        $frm->addTextField('GEN_SYSTEM_NAME', 'Nome do sistem', 50, true);
        
        
        $frm->addButton('Continuar', null, 'Continuar', null, null, true, false);
        $frm->addButton('Limpar', null, 'Limpar', null, null, false, false);
    $frm->closeGroup();
 }

$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Continuar':
        if ($frm->validate()) {
            try {
                $GEN_SYSTEM_ACRONYM = strtolower($frm->get('GEN_SYSTEM_ACRONYM'));
                TGeneratorHelper::validateFolderName($GEN_SYSTEM_ACRONYM);
                $_SESSION[APLICATIVO]=null;
                $_SESSION[APLICATIVO]['DBMS']['TYPE']=$frm->get('DBMS');
                $_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM']=$GEN_SYSTEM_ACRONYM;
                $_SESSION[APLICATIVO]['GEN_SYSTEM_VERSION']=$frm->get('GEN_SYSTEM_VERSION');
                $_SESSION[APLICATIVO]['GEN_SYSTEM_NAME']=$frm->get('GEN_SYSTEM_NAME');
                $_SESSION[APLICATIVO][TableInfo::TP_SYSTEM]=$frm->get(TableInfo::TP_SYSTEM);
                $_SESSION[APLICATIVO]['EASYLABEL']=$frm->get('EASYLABEL');
                $frm->redirect('gen01.php', 'Redirect realizado com sucesso.', true);
            } catch (Exception $e) {
                $frm->setMessage($e->getMessage());
            }
        }
    break;
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
    break;
}


$frm->show();
