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

class CreateApiIndex extends TCreateFileContent
{

    private $gen_system_acronym;
    
    public function __construct()
    {   
        $this->gen_system_acronym = $_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
        $this->setFileName('index.php');
        $path = TGeneratorHelper::getPathNewSystem().DS.'api'.DS;
        $this->setFilePath($path);
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('if (! defined ( \'DS\' )) {');
        $this->addLine(ESP.'define ( \'DS\', DIRECTORY_SEPARATOR );');
        $this->addLine('}');
        $this->addLine('$current_dirApi = dirname ( __FILE__ );');
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addLine('require_once $current_dirApi.DS.\'..\'.DS.\'includes\'.DS.\'constantes.php\';');
        $this->addLine('require_once $current_dirApi.DS.\'..\'.DS.\'includes\'.DS.\'config_conexao.php\';');
        $this->addLine('require_once $current_dirApi.DS.\'..\'.DS.\'..\'.DS.\'base/classes/webform/TApplication.class.php\';');
        $this->addLine('require_once $current_dirApi.DS.\'..\'.DS.\'controllers\'.DS.\'autoload_'.$this->gen_system_acronym.'.php\';');
        $this->addLine('require_once $current_dirApi.DS.\'..\'.DS.\'dao\'.DS.\'autoload_'.$this->gen_system_acronym.'_dao.php\';');
        $this->addLine('require_once $current_dirApi.DS.\'autoload_'.$this->gen_system_acronym.'_api.php\';');
        $this->addBlankLine();
        $this->addLine();
        $this->addLine('require_once $current_dirApi.DS.\'env.php\';');
        $this->addLine('require_once $current_dirApi.DS.\'slimConfiguration.php\';');
        $this->addLine('require_once $current_dirApi.DS.\'routes.php\';');

        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
