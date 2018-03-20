<?php
/**
 * SysGen - System Generator with Formdin Framework
 * https://github.com/bjverde/sysgen
 */

if(!defined('EOL')){ define('EOL',"\n"); }
if(!defined('TAB')){ define('TAB',chr(9)); }
if(!defined('DS')){ define('DS',DIRECTORY_SEPARATOR); }
class TCreateClass extends  TCreateFileContent{
    private $tableRef;
    private $tableRefDAO;
    private $tableRefVO;
    private $withSqlPagination;
    private $listColumnsName;
    private $listColumnsProperties;
    
    public function __construct($tableRef){
    	$tableRef = ucfirst(strtolower($tableRef));
    	$this->tableRef   = $tableRef;
    	$this->tableRefDAO= $tableRef.'DAO';
    	$this->tableRefVO = $tableRef.'VO';
    	$this->setFileName($tableRef);
		$path = TGeneratorHelper::getPathNewSystem().DS.'classes'.DS;
		$this->setFilePath($path);
	}
	//------------------------------------------------------------------------------------
	public function setWithSqlPagination($withSqlPagination) {
		return $this->withSqlPagination = $withSqlPagination;
	}
	public function getWithSqlPagination() {
		return $this->withSqlPagination;
	}
	//--------------------------------------------------------------------------------------
	public function setListColunnsName($listColumnsName) {
		if(!is_array($listColumnsName)){
			throw new InvalidArgumentException('List of Columns Properties not is a array');
		}
		$this->listColumnsName = array_map('strtoupper', $listColumnsName);
	}
	public function getListColunnsName() {
		return $this->listColumnsName;
	}
	//--------------------------------------------------------------------------------------
	public function setListColumnsProperties($listColumnsProperties) {
		if(!is_array($listColumnsProperties)){
			throw new InvalidArgumentException('List of Columns Properties not is a array');
		}
		$this->listColumnsProperties = $listColumnsProperties;
	}
	public function getListColumnsProperties() {
		return $this->listColumnsProperties;
	}
	//--------------------------------------------------------------------------------------
	private function addConstruct() {
		$this->addLine(TAB.'public function __construct(){');
		$this->addLine(TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	private function addSelectById() {
		$this->addLine(TAB.'public static function selectById( $id ){');
		$this->addLine(TAB.TAB.'$result = '.$this->tableRefDAO.'::selectById( $id );');
		$this->addLine(TAB.TAB.'return $result;');
		$this->addLine(TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	private function addSelectCount() {
		$this->addLine(TAB.'public static function selectCount( $where=null ){');
		$this->addLine(TAB.TAB.'$result = '.$this->tableRefDAO.'::selectCount( $where );');
		$this->addLine(TAB.TAB.'return $result;');
		$this->addLine(TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	private function addSelectAll() {
		$this->addLine(TAB.'public static function selectAll( $orderBy=null, $where=null ){');
		$this->addLine(TAB.TAB.'$result = '.$this->tableRefDAO.'::selectAll( $orderBy=null, $where=null );');
		$this->addLine(TAB.TAB.'return $result;');
		$this->addLine(TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	private function addSave() {
		$columunPK = ucfirst(strtolower($this->listColumnsName[0]));
		$this->addLine(TAB.'public static function save( '.$this->tableRefVO.' $objVo ){');
		$this->addLine(TAB.TAB.'$result = null;');
		$this->addLine(TAB.TAB.'if( $objVo->get'.$columunPK.'() ) {');
		$this->addLine(TAB.TAB.TAB.'$result = '.$this->tableRefDAO.'::update( $objVo );');
		$this->addLine(TAB.TAB.'}');
		$this->addLine(TAB.TAB.'$result = '.$this->tableRefDAO.'::insert( $objVo );');
		$this->addLine(TAB.TAB.'return $result;');
		$this->addLine(TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	private function addDelete() {
		$this->addLine(TAB.'public static function delete( $id ){');
		$this->addLine(TAB.TAB.'$result = '.$this->tableRefDAO.'::delete( $id );');
		$this->addLine(TAB.TAB.'return $result;');
		$this->addLine(TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	public function show($print=false) {		
	    $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('class '.$this->tableRef.' {');
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addConstruct();
        
        $this->addLine();
        $this->addSelectById();

        $this->addLine();
        $this->addSelectCount();
        
        if( $this->getWithSqlPagination() == GRID_SQL_PAGINATION ){
        	$this->addLine();
        	$this->addSqlSelectAllPagination();
        }
        
        $this->addLine();
        $this->addSelectAll();
        
        $this->addLine();
        $this->addSave();
        
        $this->addLine();
        $this->addDelete();
        
        $this->addBlankLine();
        $this->addLine('}');
        $this->addLine('?>');
        if( $print){
        	echo $this->getLinesString();
		}else{
			return $this->getLinesString();
		}
	}
}
?>