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

class CreateAutoloadAPI extends TCreateFileContent
{

    private $gen_system_acronym;
    
    public function __construct()
    {
        $this->gen_system_acronym = $_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
        $this->setFileName('autoload_'.$this->gen_system_acronym.'_api.php');
        $path = TGeneratorHelper::getPathNewSystem().DS.'api'.DS;
        $this->setFilePath($path);
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $autoloadName = $this->gen_system_acronym.'_api_autoload';
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('if ( !function_exists( \''.$autoloadName.'\') ) {');
        $this->addLine(ESP.'function '.$autoloadName.'( $class_name )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$class_name = str_replace(\'\\\',DS,$class_name);');
		$this->addLine(ESP.ESP.'$path = __DIR__.DS.$class_name.\'.class.php\';');
		$this->addLine(ESP.ESP.'if (file_exists($path)){');
        $this->addLine(ESP.ESP.ESP.'require_once $path;');
		$this->addLine(ESP.ESP.'} else {');
        $this->addLine(ESP.ESP.ESP.'return false;');
		$this->addLine(ESP.ESP.'}');
        $this->addLine(ESP.'}');
        $this->addLine('spl_autoload_register(\''.$autoloadName.'\');');
        $this->addLine('}');
        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
