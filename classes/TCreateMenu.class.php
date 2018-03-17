<?php
/**
 * SysGen - System Generator with Formdin Framework
 * https://github.com/bjverde/sysgen
 */

if(!defined('EOL')){ define('EOL',"\n"); }
if(!defined('TAB')){ define('TAB',chr(9)); }
if(!defined('DS')){ define('DS',DIRECTORY_SEPARATOR); }
class TCreateMenu extends  TCreateFileContent{
	private $listTableNames;

	public function __construct($listTableNames){
	    $this->setFileName('menu.php');
	    $path = ROOT_PATH.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'].DS.'includes'.DS;
	    $this->setFilePath($path);
	    $this->setListTableNames($listTableNames);
	}
	//--------------------------------------------------------------------------------------
	public function setListTableNames($listTableNames) {
		$this->validateListTableNames($listTableNames);
		$this->listTableNames = $listTableNames;
	}
	public function getListTableNames() {
		return $this->listTableNames;
	}
	//--------------------------------------------------------------------------------------
	private function validateListTableNames($listTableNames) {
		$listTableNames = empty($listTableNames)?$this->listTableNames:$listTableNames;
		if(empty($listTableNames)){
			throw new InvalidArgumentException('List of Tables Names is empty');
		}
		if(!is_array($listTableNames)){
			throw new InvalidArgumentException('List of Tables Names not is array');
		}
	}
	//--------------------------------------------------------------------------------------
	private function addBasicMenuItems() {
		$this->validateListTableNames(null);
		foreach($this->listTableNames as $key=>$value){
			$this->addLine('$menu->add(\'1.'.$key.'\',1,\''.$value.'\',\''.$value.'.php\');');
		}
	}
	//--------------------------------------------------------------------------------------
	public function showForm($print=false) {
		$this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('$menu = new TMenuDhtmlx();');
        $this->addLine('$menu->add(\'1\', null, \'Menu\', null, null, \'menu-alt-512.png\');');
        $this->addBasicMenuItems();
        $this->addLine('$menu->getXml();');
        $this->addLine('?>');        
        if( $print){
        	echo $this->getLinesString();
		}else{
			return $this->getLinesString();
		}
	}
}
?>