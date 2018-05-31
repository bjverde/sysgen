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

class TCreateDAO {
	private $tableName;
	private $aColumns;
	private $lines;
	private $keyColumnName;
	private $path;
	private $databaseManagementSystem;
	private $tableSchema;
	private $withSqlPagination;
	private $charParam = '?';
	private $listColumnsProperties;
	private $tableType = null;

	public function __construct($strTableName=null,$strkeyColumnName=null,$strPath=null,$databaseManagementSystem=null) {
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
	public function getDatabaseManagementSystem() {
	    return $this->databaseManagementSystem;
	}
	//------------------------------------------------------------------------------------
	public function setTableSchema($tableSchema){
		return $this->tableSchema = $tableSchema;
	}
	public function getTableSchema(){
	    return $this->tableSchema;
	}
	public function hasSchema(){
	    $result = '';
	    if( !empty( $this->getTableSchema() ) ){
	    	$result = $this->getTableSchema().'.';
	    }	    
	    return $result;
	}
	//------------------------------------------------------------------------------------
	public function setTableType($tableType) {
		$this->tableType = $tableType;
	}
	public function getTableType() {
		return $this->tableType;
	}
	//------------------------------------------------------------------------------------
	public function setWithSqlPagination($withSqlPagination) {
	    return $this->withSqlPagination = $withSqlPagination;
	}
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
	public function addLine($strNewValue=null,$boolNewLine=true){
		$strNewValue = is_null( $strNewValue ) ? TAB.'//' . str_repeat( '-', 80 ) : $strNewValue;
		$this->lines[] = $strNewValue.( $boolNewLine ? EOL : '');
	}
	//--------------------------------------------------------------------------------------
	private function addBlankLine(){
		$this->addLine('');
	}
	//--------------------------------------------------------------------------------------
	public function showVO($print=false){
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
			if (preg_match ( '/cpf|cnpj/i', $v ) > 0) {
				$this->addLine(TAB.TAB.'$this->'.$v.' = preg_replace(\'/[^0-9]/\',\'\',$strNewValue);' );
			} else {
				$this->addLine(TAB.TAB.'$this->'.$v.' = $strNewValue;' );
			}
			$this->addLine(TAB."}");
			$this->addLine(TAB.'function get'.ucfirst($v).'()');
			$this->addLine(TAB."{");
			if(preg_match('/^data?_/i',$v) == 1 ){
				$this->addLine(TAB.TAB."return is_null( \$this->{$v} ) ? date( 'Y-m-d h:i:s' ) : \$this->{$v};");
			}else{
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
	
	//--------------------------------------------------------------------------------------
	public function saveVO($fileName=null) {
		$fileName = $this->path.( is_null($fileName) ? ucfirst($this->getTableName()).'VO.class.php' : $tableName);
		
		if($fileName) {
			if( file_exists($fileName)) {
				unlink($fileName);
			}
			file_put_contents($fileName,$this->showVO(false));
		}
	}
	//--------------------------------------------------------------------------------------
	/***
	 * Create variable with string sql basica
	 **/
	public function addSqlVariable() {
		$indent = TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.' ';
		$this->addLine( TAB.'private static $sqlBasicSelect = \'select');
		foreach($this->getColumns() as $k=>$v) {
			$this->addLine($indent.( $k==0 ? ' ' : ',').$v);
		}
		$this->addLine($indent.'from '.$this->hasSchema().$this->getTableName().' \';' );
	}
	//--------------------------------------------------------------------------------------
	/***
	 * Create function for sql select by id
	 **/
	public function addSqlSelectById() {
	    $this->addLine( TAB.'public static function selectById( $id ) {');
	    $this->addLine( TAB.TAB.'$values = array($id);');
	    $this->addLine( TAB.TAB.'$sql = self::$sqlBasicSelect.\' where '.$this->getKeyColumnName().' = '.$this->charParam.'\';');
		$this->addLine( TAB.TAB.'$result = self::executeSql($sql, $values );');
		$this->addLine( TAB.TAB.'return $result;');
	    $this->addLine( TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	private function getColumnsPropertieFormDinType($key) {
		$result = null;
		if(ArrayHelper::has(TCreateForm::FORMDIN_TYPE_COLUMN_NAME,$this->listColumnsProperties)){
			$result = strtoupper($this->listColumnsProperties[TCreateForm::FORMDIN_TYPE_COLUMN_NAME][$key]);
		}
		return $result;
	}
	//--------------------------------------------------------------------------------------
	public function addProcessWhereGridParameters() {
		$this->addLine( TAB.'private static function processWhereGridParameters( $whereGrid ) {');
		$this->addLine( TAB.TAB.'$result = $whereGrid;');
		$this->addLine( TAB.TAB.'if ( is_array($whereGrid) ){');
		$this->addLine( TAB.TAB.TAB.'$where = \' 1=1 \';');
		foreach($this->getColumns() as $key=>$v) {
			$formDinType = self::getColumnsPropertieFormDinType($key);
			if( $formDinType == TCreateForm::FORMDIN_TYPE_NUMBER ){
				$this->addLine( TAB.TAB.TAB.'$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,\''.strtoupper($v).'\',\' AND '.strtoupper($v).' = \'.$whereGrid[\''.strtoupper($v).'\'].\'  \',null) );' );
			} else {
				$this->addLine( TAB.TAB.TAB.'$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,\''.strtoupper($v).'\',\' AND '.strtoupper($v).' like \\\'%\'.$whereGrid[\''.strtoupper($v).'\'].\'%\\\' \',null) );' );
			}
		}
		$this->addLine( TAB.TAB.TAB.'$result = $where;');
		$this->addLine( TAB.TAB.'}');
		$this->addLine( TAB.TAB.'return $result;');
		$this->addLine( TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	/***
	 * Create function for sql count rows of table
	 **/
	public function addSqlSelectCount() {
		$this->addLine( TAB.'public static function selectCount( $where=null ){');
		$this->addLine( TAB.TAB.'$where = self::processWhereGridParameters($where);');
		$this->addLine( TAB.TAB.'$sql = \'select count('.$this->getKeyColumnName().') as qtd from '.$this->hasSchema().$this->getTableName().'\';' );
		$this->addLine( TAB.TAB.'$sql = $sql.( ($where)? \' where \'.$where:\'\');');
		$this->addLine( TAB.TAB.'$result = self::executeSql($sql);');
		$this->addLine( TAB.TAB.'return $result[\'QTD\'][0];');
		$this->addLine( TAB.'}');
	}	
	//--------------------------------------------------------------------------------------
	/***
	 * Create function for sql select all with Pagination
	 **/
	public function addSqlSelectAllPagination() {
		$this->addLine( TAB.'public static function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null ) {');
		$this->addLine( TAB.TAB.'$rowStart = PaginationSQLHelper::getRowStart($page,$rowsPerPage);');
		$this->addLine( TAB.TAB.'$where = self::processWhereGridParameters($where);');
		$this->addBlankLine();
		$this->addLine( TAB.TAB.'$sql = self::$sqlBasicSelect');
		$this->addLine( TAB.TAB.'.( ($where)? \' where \'.$where:\'\')');
		$this->addLine( TAB.TAB.'.( ($orderBy) ? \' order by \'.$orderBy:\'\')');		
		if($this->getDatabaseManagementSystem() == DBMS_MYSQL){
		    $this->addLine( TAB.TAB.'.( \' LIMIT \'.$rowStart.\',\'.$rowsPerPage);');
		}
		if($this->getDatabaseManagementSystem() == DBMS_SQLSERVER){
		    $this->addLine( TAB.TAB.'.( \' OFFSET \'.$rowStart.\' ROWS FETCH NEXT \'.$rowsPerPage.\' ROWS ONLY \');');
		}		
		$this->addBlankLine();
		$this->addLine( TAB.TAB.'$result = self::executeSql($sql);');
		$this->addLine( TAB.TAB.'return $result;');
		$this->addLine( TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	/***
	 * Create function for sql select all
	 **/
	public function addSqlSelectAll() {
		$this->addLine( TAB.'public static function selectAll( $orderBy=null, $where=null ) {');
		$this->addLine( TAB.TAB.'$where = self::processWhereGridParameters($where);');
		$this->addLine( TAB.TAB.'$sql = self::$sqlBasicSelect');
		$this->addLine( TAB.TAB.'.( ($where)? \' where \'.$where:\'\')');
		$this->addLine( TAB.TAB.'.( ($orderBy) ? \' order by \'.$orderBy:\'\');');
		$this->addBlankLine();
		$this->addLine( TAB.TAB.'$result = self::executeSql($sql);');
		$this->addLine( TAB.TAB.'return $result;');
		$this->addLine( TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	/***
	 * Create function for sql insert
	 **/
	public function addSqlInsert() {
	    $this->addLine(TAB.'public static function insert( '.ucfirst($this->tableName).'VO $objVo ) {');
	    $this->addLine(TAB.TAB.'$values = array(',false);
	    $cnt=0;
	    foreach($this->getColumns() as $k=>$v) {
	        if( $v != strtolower($this->keyColumnName) ) {
	            $this->addLine(( $cnt++==0 ? ' ' : TAB.TAB.TAB.TAB.TAB.TAB.',').' $objVo->get'.ucfirst($v).'() ');
	        }
	    }
	    $this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.');');
	    $this->addLine(TAB.TAB.'return self::executeSql(\'insert into '.$this->hasSchema().$this->getTableName().'(');
	    $cnt=0;
	    foreach($this->getColumns() as $k=>$v) {
	        if( $v != strtolower($this->keyColumnName) ) {
	            $this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.( $cnt++==0 ? ' ' : ',').$v);
	        }
	    }
	    //$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.') values (?'.str_repeat(',?',count($this->getColumns())-1 ).')\', $values );');
	    $this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.') values ('.$this->getParams().')\', $values );');
	    $this->addLine(TAB.'}');
	}	
	//--------------------------------------------------------------------------------------
	/***
	 * Create function for sql update
	 **/
	public function addSqlUpdate() {
	    $this->addLine(TAB.'public static function update ( '.ucfirst($this->tableName).'VO $objVo ) {');
	    $this->addLine(TAB.TAB.'$values = array(',false);
	    $count=0;
	    foreach($this->getColumns() as $k=>$v) {
	        if( strtolower($v) != strtolower($this->keyColumnName)) {
	            $this->addLine(( $count==0 ? ' ' : TAB.TAB.TAB.TAB.TAB.TAB.',').'$objVo->get'.ucfirst($v).'()');
	            $count++;
	        }
	    }
	    $this->addline(TAB.TAB.TAB.TAB.TAB.TAB.',$objVo->get'.ucfirst($this->keyColumnName).'() );');
	    $this->addLine(TAB.TAB.'return self::executeSql(\'update '.$this->hasSchema().$this->getTableName().' set ');
	    $count=0;
	    foreach($this->getColumns() as $k=>$v) {
	        if( strtolower($v) != strtolower($this->keyColumnName)) {
	            $param = $this->databaseManagementSystem == DBMS_POSTGRES ? '$'.($count+1) : '?';
	            $this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.( $count==0 ? ' ' : ',').$v.' = '.$param);
	            $count++;
	        }
	    }
	    $param = $this->databaseManagementSystem == DBMS_POSTGRES ? '$'.($count+1) : '?';
	    $this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.'where '.$this->keyColumnName.' = '.$param.'\',$values);');
	    $this->addLine(TAB.'}');
	}	
	//--------------------------------------------------------------------------------------
	/***
	 * Create function for sql delete
	 **/
	public function addSqlDelete() {
		$this->addLine( TAB.'public static function delete( $id ){');
		$this->addLine( TAB.TAB.'$values = array($id);');
		$this->addLine( TAB.TAB.'return self::executeSql(\'delete from '.$this->hasSchema().$this->getTableName().' where '.$this->keyColumnName.' = '.$this->charParam.'\',$values);');
		$this->addLine( TAB.'}');
	}
	//--------------------------------------------------------------------------------------
	/**
	 * No PHP 7.1 classes com construtores ficou deprecated
	 */
	public function addConstruct() {
	    if (version_compare(phpversion(), '5.6.0', '<')) {
	        $this->addLine(TAB.'public function '.$this->getTableName().'DAO() {');
	        $this->addLine(TAB.'}');
	    }
	}	
	//--------------------------------------------------------------------------------------
	public function showDAO($print=false) {
		$this->lines=null;
		$this->addLine('<?php');
		$this->addLine('class '.ucfirst($this->getTableName()).'DAO extends TPDOConnection {');
		$this->addBlankLine();
		$this->addSqlVariable();
		$this->addBlankLine();
		
		// construct
		$this->addConstruct();

		$this->addProcessWhereGridParameters();
		
		// select by Id
		$this->addLine();
		$this->addSqlSelectById();
		// fim select
		
		// Select Count
		$this->addLine();
		$this->addSqlSelectCount();
		// fim Select Count	

		if( $this->getWithSqlPagination() == GRID_SQL_PAGINATION ){
		    $this->addLine();
		    $this->addSqlSelectAllPagination();
		}
		
		// select where		
		$this->addLine();
		$this->addSqlSelectAll();
		// fim select
		
		if( $this->getTableType() != TABLE_TYPE_VIEW ){		
			// insert
			$this->addLine();
			$this->addSqlInsert();
			// update
			$this->addLine();
			$this->addSqlUpdate();
			// EXCLUIR
			$this->addLine();
			$this->addSqlDelete();
	    }
		
		//-------- FIM
		$this->addLine("}");
		$this->addLine("?>");
		if ($print) {
			echo $this->getLinesString();
		} else {
			return $this->getLinesString();
		}
	}

	//---------------------------------------------------------------------------------------
	public function saveDAO($fileName=null) {
	    
		$fileName = $this->path.(is_null($fileName) ? ucfirst($this->getTableName()).'DAO.class.php' : $tableName);
		if($fileName) {
			if( file_exists($fileName) ) {
				unlink($fileName);
			}
			file_put_contents($fileName,$this->showDAO(false));
		}
		
	}
	//--------------------------------------------------------------------------------------
	/**
	 * Returns the number of parameters
	 * @return string
	 */
	public  function getParams() {
	    $cols = $this->getColumns();
	    $qtd = count($cols);
	    $result = '';
	    for($i = 1; $i <= $qtd ; $i++) {
	        if( $cols[$i-1] != strtolower($this->keyColumnName) ){
	            $result .= ($result=='') ? '' : ',';
	            if( $this->databaseManagementSystem == DBMS_POSTGRES ){
	                $result .= '$'.$i;
	            } else {
	                $result.='?';
	            }
	        }
	    }
	    return $result;
	}
	//--------------------------------------------------------------------------------------
	public  function removeUnderline($txt) {
		$len = strlen($txt);
		for ($i = $len-1; $i >= 0; $i--) {
			if ($txt{$i} === '_') {
				$len--;
				$txt = substr_replace($txt, '', $i, 1);
				if ($i != $len)
					$txt{$i} = strtoupper($txt{$i});
			}
		}
		return $txt;
	}
}
?>