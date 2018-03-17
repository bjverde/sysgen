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
	    $path = ROOT_PATH.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'].DS.'includes'.DS;
	    $this->setFilePath($path);
	}
	//--------------------------------------------------------------------------------------
	public function showForm($print=false) {
		$this->lines=null;
        $this->addLine('<?php');
        $this->addLine('?>');        
        if( $print){
        	echo $this->getLinesString();
		}else{
			return $this->getLinesString();
		}
	}
}
?>