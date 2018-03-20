<?php
/**
 * SysGen - System Generator with Formdin Framework
 * https://github.com/bjverde/sysgen
 */

if(!defined('EOL')){ define('EOL',"\n"); }
if(!defined('TAB')){ define('TAB',chr(9)); }
if(!defined('DS')){ define('DS',DIRECTORY_SEPARATOR); }
class TCreateAutoload extends  TCreateFileContent{

    private $gen_system_acronym;
    
	public function __construct(){
	    $this->gen_system_acronym = $_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
	    $this->setFileName('autoload_'.$this->gen_system_acronym.'.php');
	    $path = TGeneratorHelper::getPathNewSystem().DS.'classes'.DS;
	    $this->setFilePath($path);
	}	
	//--------------------------------------------------------------------------------------
	public function show($print=false) {
	    $autoloadName = $this->gen_system_acronym.'_autoload';		
	    $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('if ( !function_exists( \''.$autoloadName.'\') ) {');
        $this->addLine(TAB.'function '.$autoloadName.'( $class_name )	{');
        $this->addLine(TAB.TAB.'require_once $class_name . \'.class.php\';');
        $this->addLine(TAB.'}');
        $this->addLine('spl_autoload_register(\''.$autoloadName.'\');');
        $this->addLine('}');        
        if( $print){
        	echo $this->getLinesString();
		}else{
			return $this->getLinesString();
		}
	}
}
?>