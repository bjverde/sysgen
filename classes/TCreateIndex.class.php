<?php
/**
 * SysGen - System Generator with Formdin Framework
 * https://github.com/bjverde/sysgen
 */

if(!defined('EOL')){ define('EOL',"\n"); }
if(!defined('TAB')){ define('TAB',chr(9)); }
if(!defined('DS')){ define('DS',DIRECTORY_SEPARATOR); }
class TCreateIndex extends  TCreateFileContent{
	public function __construct(){
	    $this->setFileName('index.php');
	    $path = TGeneratorHelper::getPathNewSystem().DS;
	    $this->setFilePath($path);
	}
	//--------------------------------------------------------------------------------------
	public function show($print=false) {
		$this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('require_once(\'includes/constantes.php\');');
        $this->addLine('require_once(\'includes/config_conexao.php\');');
        $this->addBlankLine();
        $this->addLine('//FormDin version: '.FORMDIN_VERSION);
        $this->addLine('require_once(\'../base/classes/webform/TApplication.class.php\');');
        $this->addLine('require_once(\'classes/autoload_'.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'].'.php\');');
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addLine('$app = new TApplication(); // criar uma instancia do objeto aplicacao');
        $this->addLine('$app->setTitle(SYSTEM_NAME);');
        //$this->addLine('$app->setSUbTitle(SYSTEM_NAME_SUB);');
        $this->addLine('$app->setSigla(SYSTEM_ACRONYM);');
        $this->addLine('$app->setVersionSystem(SYSTEM_VERSION);');
        $this->addBlankLine();
        $this->addLine('$app->setMainMenuFile(\'includes/menu.php\');');
        $this->addLine('$app->run();');
        $this->addLine('?>');        
        if( $print){
        	echo $this->getLinesString();
		}else{
			return $this->getLinesString();
		}
	}
}
?>