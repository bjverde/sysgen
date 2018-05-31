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

if(!defined('EOL')){ define('EOL',"\n"); }
if(!defined('TAB')){ define('TAB',chr(9)); }
if(!defined('DS')){ define('DS',DIRECTORY_SEPARATOR); }
class TCreateConfigDataBase extends  TCreateFileContent{

	public function __construct(){
	    $this->setFileName('config_conexao.php');
	    $path = TGeneratorHelper::getPathNewSystem().DS.'includes'.DS;
	    $this->setFilePath($path);
	}
	//--------------------------------------------------------------------------------------
	public function show($print=false) {
		$this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('define(\'BANCO\'   , \''.$_SESSION[APLICATIVO]['DBMS']['TYPE'].'\');');
        $this->addLine('define(\'HOST\'    , \''.$_SESSION[APLICATIVO]['DBMS']['HOST'].'\');');
        $this->addLine('define(\'PORT\'    , \''.$_SESSION[APLICATIVO]['DBMS']['PORT'].'\');');
        $this->addLine('define(\'DATABASE\', \''.$_SESSION[APLICATIVO]['DBMS']['DATABASE'].'\');');
        $this->addLine('define(\'SCHEMA\'  , \''.$_SESSION[APLICATIVO]['DBMS']['SCHEMA'].'\');');
        $this->addLine('define(\'USUARIO\' , \''.$_SESSION[APLICATIVO]['DBMS']['USER'].'\');');
        $this->addLine('define(\'SENHA\'   , \''.$_SESSION[APLICATIVO]['DBMS']['PASSWORD'].'\');');
        $this->addLine('define(\'UTF8_DECODE\'   , 0);');
        $this->addLine('?>');        
        if( $print){
        	echo $this->getLinesString();
		}else{
			return $this->getLinesString();
		}
	}
}
?>