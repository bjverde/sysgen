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


class TCreateIndex extends TCreateFileContent
{
    public function __construct()
    {
        $this->setFileName('index.php');
        $path = TGeneratorHelper::getPathNewSystem().DS;
        $this->setFilePath($path);
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('require_once(\'includes/constantes.php\');');
        $this->addLine('require_once(\'includes/config_conexao.php\');');
        $this->addBlankLine();
        $this->addLine('//FormDin version: '.FORMDIN_VERSION);
        $this->addLine('require_once(\'../base/classes/webform/TApplication.class.php\');');
        $this->addLine('require_once(\'controllers/autoload_'.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'].'.php\');');
        $this->addLine('require_once(\'dao/autoload_'.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'].'_dao.php\');');
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addLine('define(\'ROOT_FOLDER\'     , basename(__DIR__)); //Folder root name');
        $this->addBlankLine();
        $this->addLine('$app = new TApplication(); //criar uma instancia do objeto aplicacao');        
        $this->addLine('$app->setAppRootDir(__DIR__); //Caminho completo no sistema operacional');
        $this->addLine('$app->setFormDinMinimumVersion(FORMDIN_VERSION_MIN_VERSION);');
        $this->addLine('//$app->setTitleTag(SYSTEM_NAME); //Title Header Page HTML');
        $this->addLine('$app->setTitle(SYSTEM_NAME);  //Title Header System');
        //$this->addLine('$app->setSUbTitle(SYSTEM_NAME_SUB);');
        $this->addLine('$app->setSigla(SYSTEM_ACRONYM);');
        $this->addLine('$app->setVersionSystem(SYSTEM_VERSION);');
        $this->addLine('//$app->setFavIcon(\'../base/imagens/favicon-16x16.png\');');
        $this->addLine('//$app->setCssDefaultFormFile(\'css/css_form_default.css\');');
        $this->addBlankLine();
        if( $_SESSION[APLICATIVO][TableInfo::TP_SYSTEM] != TGeneratorHelper::TP_SYSTEM_REST ){
            $this->addLine('$app->setMainMenuFile(\'includes/menu.php\');');
        }
        $this->addLine('$app->run();');
        $this->addLine('?>');
        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
