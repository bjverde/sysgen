<?php
/**
 * SysGen - System Generator with Formdin Framework
 * https://github.com/bjverde/sysgen
 */

if(!defined('EOL')){ define('EOL',"\n"); }
if(!defined('TAB')){ define('TAB',chr(9)); }

/**
 *  AINDA NÃO ESTÄ PRONTA
 * @todo terminar TCreateVO e remover VO da TCreateDAO 
 * @author bjverte
 *
 */
class TCreateVO extends  TCreateFileContent{
	private $tableName;
	private $aColumns;
	private $lines;
	private $keyColumnName;
	private $path;
	private $databaseManagementSystem;
	private $showSchema;
	private $withSqlPagination;
	private $charParam = '?';
	private $listColumnsProperties;

	public function __construct($strTableName=null,$strkeyColumnName=null,$strPath=null,$databaseManagementSystem=null) {
		$tableRef = strtolower($tableRef);
		$this->setTableName($strTableName);
		$this->setFileName(ucfirst($tableRef).'VO.class.php');
		$path = TGeneratorHelper::getPathNewSystem().DS.'dao'.DS;
		$this->setFilePath($path);
		
		$this->aColumns=array();
		$this->setTableName($strTableName);
		$this->keyColumnName = $strkeyColumnName;
		$this->path = $strPath;
		$this->databaseManagementSystem = strtoupper($databaseManagementSystem);
		if( $databaseManagementSystem == DBMS_POSTGRES ) {
			$this->charParam = '$1';
		}
	}
	//-----------------------------------------------------------------------------------
	public function setTableName($strTableName) {
		$strTableName = strtolower($strTableName);
		$this->tableName=$strTableName;
	}
	//------------------------------------------------------------------------------------
	public function getTableName() {
		return $this->tableName;
	}
	//------------------------------------------------------------------------------------
	public function getKeyColumnName() {
		return $this->keyColumnName;
	}
	//------------------------------------------------------------------------------------
	public function setDatabaseManagementSystem($databaseManagementSystem) {
	    return $this->databaseManagementSystem = strtoupper($databaseManagementSystem);
	}
	//------------------------------------------------------------------------------------
	public function getDatabaseManagementSystem() {
	    return $this->databaseManagementSystem;
	}
	//------------------------------------------------------------------------------------
	public function setShowSchema($showSchema){
	    return $this->showSchema = $showSchema;
	}
	//------------------------------------------------------------------------------------
	public function getShowSchema(){
	    return $this->showSchema;
	}
	//------------------------------------------------------------------------------------
	public function hasSchema(){
	    $result = '';
	    if($this->getShowSchema() == true){
	        $result = '\'.SCHEMA.\'';
	    }	    
	    return $result;
	}
	//------------------------------------------------------------------------------------
	public function setWithSqlPagination($withSqlPagination) {
	    return $this->withSqlPagination = $withSqlPagination;
	}
	//------------------------------------------------------------------------------------
	public function getWithSqlPagination() {
	    return $this->withSqlPagination;
	}
	//------------------------------------------------------------------------------------
	public function getCharParam() {
	    return $this->charParam;
	}
	//------------------------------------------------------------------------------------
	public function getLinesArray(){
		return $this->lines;
	}
	//------------------------------------------------------------------------------------
	public function getLinesString(){
		$string = implode($this->lines);
		return trim($string);
	}
	//------------------------------------------------------------------------------------
	public function addColumn($strColumnName)
	{
		if ( !in_array($strColumnName,$this->aColumns))
		{
			$this->aColumns[] = strtolower($strColumnName);
		}
	}
	//--------------------------------------------------------------------------------------
	public function getColumns()
	{
		return $this->aColumns;
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
	public function show($print=false){
	    $this->addLine('<?php');
	    $this->addLine("class ".ucfirst($this->getTableName())."VO {");
	    $cols='';
	    $sets='';
	    foreach($this->getColumns() as $k => $v ){
	        $this->addLine(TAB.'private $'.$v.' = null;');
	        $cols .= $cols == '' ? '' : ', ';
	        $cols .='$'.$v.'=null';
	        $sets .= ($k == 0 ? '' : EOL ).TAB.TAB.'$this->set'.ucFirst($v).'( $'.$v.' );';
	    }
	    $this->addLine(TAB.'public function __construct( '.$cols.' ) {');
	    $this->addLine($sets);
	    $this->addLine(TAB.'}');
	    $this->addLine();
	    foreach($this->getColumns() as $k=>$v) {
			$this->addLine(TAB.'function set'.ucfirst($v).'( $strNewValue = null )');
			$this->addLine(TAB."{");
			if( preg_match('/cpf|cnpj/i',$v) > 0 )
			{
				$this->addLine(TAB.TAB.'$this->'.$v.' = preg_replace(\'/[^0-9]/\',\'\',$strNewValue);');
			}
			else
			{
				$this->addLine(TAB.TAB.'$this->'.$v.' = $strNewValue;');
			}
			$this->addLine(TAB."}");
			$this->addLine(TAB.'function get'.ucfirst($v).'()');
			$this->addLine(TAB."{");
			if(preg_match('/^data?_/i',$v) == 1 )
			{
				$this->addLine(TAB.TAB."return is_null( \$this->{$v} ) ? date( 'Y-m-d h:i:s' ) : \$this->{$v};");
			}
			else
			{
				$this->addLine(TAB.TAB.'return $this->'.$v.';');
			}
			$this->addLine(TAB."}");
			$this->addLine();
		}
		$this->addLine("}");
		$this->addLine('?>');
		if( $print) {
			echo trim(implode($this->lines));
		}else {
			return trim(implode($this->lines));
		}
	}
}
?>