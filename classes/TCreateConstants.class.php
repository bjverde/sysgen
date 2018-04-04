<?php
/**
 * SysGen - System Generator with Formdin Framework
 * https://github.com/bjverde/sysgen
 */

if(!defined('EOL')){ define('EOL',"\n"); }
if(!defined('TAB')){ define('TAB',chr(9)); }
if(!defined('DS')){ define('DS',DIRECTORY_SEPARATOR); }
class TCreateConstants extends  TCreateFileContent{

	public function __construct(){
	    $this->setFileName('constantes.php');
	    $path = TGeneratorHelper::getPathNewSystem().DS.'includes'.DS;
	    $this->setFilePath($path);
	}
	//--------------------------------------------------------------------------------------
	public function show($print=false) {
		$this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('define(\'SYSTEM_NAME\'    , \''.$_SESSION[APLICATIVO]['GEN_SYSTEM_NAME'].'\');');
        $this->addLine('define(\'SYSTEM_ACRONYM\' , \''.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'].'\');');
        $this->addLine('define(\'SYSTEM_VERSION\' , \''.$_SESSION[APLICATIVO]['GEN_SYSTEM_VERSION'].'\');');
        $this->addLine('define(\'APLICATIVO\'     , SYSTEM_ACRONYM);');
        $this->addLine('define(\'DS\'   , DIRECTORY_SEPARATOR);');
        $this->addLine('?>');
        if( $print){
        	echo $this->getLinesString();
		}else{
			return $this->getLinesString();
		}
	}
}
?>