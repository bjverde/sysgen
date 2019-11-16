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

class TCreateDAO extends TCreateFileContent
{
    private $tableName;
    private $aColumns = array();
    private $lines;
    private $keyColumnName;
    private $path;
    private $databaseManagementSystem;
    private $tableSchema;
    private $withSqlPagination;
    private $charParam = '?';
    private $listColumnsProperties;
    private $tableType = null;


    /**
     * Create file DAO form a table info
     * @param string $pathFolder   - folder path to create file
     * @param string $tableName    - table name
     * @param array $listColumnsProperties
     */
    public function __construct($pathFolder ,$tableName ,$listColumnsProperties)
    {
        $tableName = strtolower($tableName);
        $this->setTableName($tableName);
        $this->setFileName(ucfirst($tableName).'DAO.class.php');
        $this->setFilePath($pathFolder);
        $this->setListColumnsProperties($listColumnsProperties);
        $this->configArrayColumns();
    }
    //-----------------------------------------------------------------------------------
    public function setTableName($strTableName)
    {
        $strTableName = strtolower($strTableName);
        $this->tableName=$strTableName;
    }
    public function getTableName()
    {
        return $this->tableName;
    }
    //------------------------------------------------------------------------------------
    public function getKeyColumnName()
    {
        return $this->keyColumnName;
    }
    //------------------------------------------------------------------------------------
    public function setDatabaseManagementSystem($databaseManagementSystem)
    {
        return $this->databaseManagementSystem = strtoupper($databaseManagementSystem);
    }
    public function getDatabaseManagementSystem()
    {
        return $this->databaseManagementSystem;
    }
    //------------------------------------------------------------------------------------
    public function setTableSchema($tableSchema)
    {
        return $this->tableSchema = $tableSchema;
    }
    public function getTableSchema()
    {
        return $this->tableSchema;
    }
    public function hasSchema()
    {
        $result = '';
        if (!empty($this->getTableSchema())) {
            $result = $this->getTableSchema().'.';
        }
        return $result;
    }
    //------------------------------------------------------------------------------------
    public function setTableType($tableType)
    {
        $this->tableType = $tableType;
    }
    public function getTableType()
    {
        return $this->tableType;
    }
    //------------------------------------------------------------------------------------
    public function setWithSqlPagination($withSqlPagination)
    {
        return $this->withSqlPagination = $withSqlPagination;
    }
    public function getWithSqlPagination()
    {
        return $this->withSqlPagination;
    }
    //------------------------------------------------------------------------------------
    public function getCharParam()
    {
        return $this->charParam;
    }
    //------------------------------------------------------------------------------------
    public function addColumn($strColumnName)
    {
        if (!in_array($strColumnName, $this->aColumns)) {
            $this->aColumns[] = strtolower($strColumnName);
        }
    }
    //--------------------------------------------------------------------------------------
    public function getColumns()
    {
        return $this->aColumns;
    }
    //--------------------------------------------------------------------------------------
    public function setListColumnsProperties($listColumnsProperties)
    {
        TGeneratorHelper::validateListColumnsProperties($listColumnsProperties);
        $this->listColumnsProperties = $listColumnsProperties;
    }
    public function getListColumnsProperties()
    {
        return $this->listColumnsProperties;
    }
    //--------------------------------------------------------------------------------------
    protected function configArrayColumns()
    {
        $listColumnsProperties = $this->getListColumnsProperties();
        $listColumns = $listColumnsProperties['COLUMN_NAME'];
        $this->keyColumnName = strtolower($listColumns[0]);
        foreach ($listColumns as $v) {
            $this->addColumn($v);
        }
    }
    //--------------------------------------------------------------------------------------
    public function getColumnPKeyPropertieFormDinType()
    {
        $PKeyName = $this->getKeyColumnName();
        $listColuns = $this->getColumns();
        $key  = ArrayHelper::array_keys2($listColuns,$PKeyName,true);
        $formDinType = null;
        if( is_array($key) && !empty($key) ){
            $formDinType = $this->getColumnsPropertieFormDinType($key[0]);
        }
        return $formDinType;
    }
    
    private function getColumnsPropertieFormDinType($key)
    {
        $result = null;
        if (ArrayHelper::has(TCreateForm::FORMDIN_TYPE_COLUMN_NAME, $this->listColumnsProperties)) {
            $result = strtoupper($this->listColumnsProperties[TCreateForm::FORMDIN_TYPE_COLUMN_NAME][$key]);
        }
        return $result;
    }
    
    //--------------------------------------------------------------------------------------
    /**
     * add Execuute SQL 
     * @param string $qtEsp
     */
    public function addExecuteSql($withValues = false)
    {
        if($withValues){
            $this->addLine(ESP.ESP.'$result = $this->tpdo->executeSql($sql, $values);');
            $this->addLine(ESP.ESP.'return $result;');
        } else {
            $this->addLine(ESP.ESP.'$result = $this->tpdo->executeSql($sql);');
            $this->addLine(ESP.ESP.'return $result;');
        }
    }    
    //--------------------------------------------------------------------------------------
    /***
     * Create variable with string sql basica
     **/
    public function addSqlVariable()
    {
        $indent = ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.' ';
        $this->addLine(ESP.'private static $sqlBasicSelect = \'select');
        foreach ($this->getColumns() as $k => $v) {
            $this->addLine($indent.( $k==0 ? ' ' : ',').$v);
        }
        $this->addLine($indent.'from '.$this->hasSchema().$this->getTableName().' \';');
    }
    //--------------------------------------------------------------------------------------
    /***
     * Create variable with string sql basica
     **/
    public function addValidateTypeInt($qtdESP)
    {
        $formDinType = $this->getColumnPKeyPropertieFormDinType();
        if ($formDinType == TCreateForm::FORMDIN_TYPE_NUMBER) {
            $this->addLine($qtdESP.'FormDinHelper::validateIdIsNumeric($id,__METHOD__,__LINE__);');
        }
    }    
    //--------------------------------------------------------------------------------------
    /***
     * Create function for sql select by id
     **/
    public function addGetVoById()
    {
        $this->addLine();
        $this->addLine(ESP.'public function getVoById( $id )');
        $this->addLine(ESP.'{');
        $this->addValidateTypeInt(ESP.ESP);
        $this->addLine(ESP.ESP.'$result = $this->selectById( $id );');
        $this->addLine(ESP.ESP.'$result = \ArrayHelper::convertArrayFormDin2Pdo($result,false);');
        $this->addLine(ESP.ESP.'$result = $result[0];');
        $this->addLine(ESP.ESP.'$vo = new '.ucfirst($this->tableName).'VO();');
        $this->addLine(ESP.ESP.'$vo = \FormDinHelper::setPropertyVo($result,$vo);');
        $this->addLine(ESP.ESP.'return $vo;');
        $this->addLine(ESP.'}');
    }
    
    /***
     * Create function for sql select by id
     **/
    public function addSqlSelectById()
    {
        $this->addLine(ESP.'public function selectById( $id )');
        $this->addLine(ESP.'{');
        $this->addValidateTypeInt(ESP.ESP);
        $this->addLine(ESP.ESP.'$values = array($id);');
        $this->addLine(ESP.ESP.'$sql = self::$sqlBasicSelect.\' where '.$this->getKeyColumnName().' = '.$this->charParam.'\';');
        $this->addExecuteSql(true);
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function addProcessWhereGridParameters()
    {
        $this->addLine(ESP.'private function processWhereGridParameters( $whereGrid )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = $whereGrid;');
        $this->addLine(ESP.ESP.'if ( is_array($whereGrid) ){');
        $this->addLine(ESP.ESP.ESP.'$where = \' 1=1 \';');
        foreach ($this->getColumns() as $key => $v) {
            $formDinType = self::getColumnsPropertieFormDinType($key);
            if ($formDinType == TCreateForm::FORMDIN_TYPE_NUMBER) {
                $this->addLine(ESP.ESP.ESP.'$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, \''.strtoupper($v).'\', SqlHelper::SQL_TYPE_NUMERIC);');
            } else {
                $this->addLine(ESP.ESP.ESP.'$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, \''.strtoupper($v).'\', SqlHelper::SQL_TYPE_TEXT_LIKE);');
            }
        }
        $this->addLine(ESP.ESP.ESP.'$result = $where;');
        $this->addLine(ESP.ESP.'}');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    /***
     * Create function for sql count rows of table
     **/
    public function addSqlSelectCount()
    {
        $this->addLine(ESP.'public function selectCount( $where=null )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$where = $this->processWhereGridParameters($where);');
        $this->addLine(ESP.ESP.'$sql = \'select count('.$this->getKeyColumnName().') as qtd from '.$this->hasSchema().$this->getTableName().'\';');
        $this->addLine(ESP.ESP.'$sql = $sql.( ($where)? \' where \'.$where:\'\');');
        $this->addLine(ESP.ESP.'$result = $this->tpdo->executeSql($sql);');
        $this->addLine(ESP.ESP.'return $result[\'QTD\'][0];');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    /***
     * Create function for sql select all with Pagination
     **/
    public function addSqlSelectAllPagination()
    {
        $this->addLine(ESP.'public function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$rowStart = SqlHelper::getRowStart($page,$rowsPerPage);');
        $this->addLine(ESP.ESP.'$where = $this->processWhereGridParameters($where);');
        $this->addBlankLine();
        $this->addLine(ESP.ESP.'$sql = self::$sqlBasicSelect');
        $this->addLine(ESP.ESP.'.( ($where)? \' where \'.$where:\'\')');
        $this->addLine(ESP.ESP.'.( ($orderBy) ? \' order by \'.$orderBy:\'\')');
        if ($this->getDatabaseManagementSystem() == DBMS_MYSQL) {
            $this->addLine(ESP.ESP.'.( \' LIMIT \'.$rowStart.\',\'.$rowsPerPage);');
        }
        if ($this->getDatabaseManagementSystem() == DBMS_SQLSERVER) {
            $this->addLine(ESP.ESP.'.( \' OFFSET \'.$rowStart.\' ROWS FETCH NEXT \'.$rowsPerPage.\' ROWS ONLY \');');
        }
        if($this->getDatabaseManagementSystem() == DBMS_POSTGRES){
            $this->addLine(ESP.ESP.'.\' LIMIT \'.$rowsPerPage.\' OFFSET \'.$rowStart ;');
        }
        $this->addBlankLine();
        $this->addExecuteSql();
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    /***
     * Create function for sql select all
     **/
    public function addSqlSelectAll()
    {
        $this->addLine(ESP.'public function selectAll( $orderBy=null, $where=null )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$where = $this->processWhereGridParameters($where);');
        $this->addLine(ESP.ESP.'$sql = self::$sqlBasicSelect');
        $this->addLine(ESP.ESP.'.( ($where)? \' where \'.$where:\'\')');
        $this->addLine(ESP.ESP.'.( ($orderBy) ? \' order by \'.$orderBy:\'\');');
        $this->addBlankLine();
        $this->addExecuteSql();
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    /***
     * Create function for sql insert
     **/
    public function addSqlInsert()
    {
        $this->addLine(ESP.'public function insert( '.ucfirst($this->tableName).'VO $objVo )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$values = array(', false);
        $cnt=0;
        foreach ($this->getColumns() as $v) {
            if ($v != strtolower($this->keyColumnName)) {
                $this->addLine(( $cnt++==0 ? ' ' : ESP.ESP.ESP.ESP.ESP.ESP.',').' $objVo->get'.ucfirst($v).'() ');
            }
        }
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.');');
        $this->addLine(ESP.ESP.'$sql = \'insert into '.$this->hasSchema().$this->getTableName().'(');
        $cnt=0;
        foreach ($this->getColumns() as $v) {
            if ($v != strtolower($this->keyColumnName)) {
                $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.( $cnt++==0 ? ' ' : ',').$v);
            }
        }
        //$this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.') values (?'.str_repeat(',?',count($this->getColumns())-1 ).')\', $values );');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.') values ('.$this->getParams().')\';');
        //$this->addExecuteSql(true);
        $this->addLine(ESP.ESP.'$result = $this->tpdo->executeSql($sql, $values);');
        $this->addLine(ESP.ESP.'$result = $this->tpdo->getLastInsertId();');
        $this->addLine(ESP.ESP.'return intval($result);');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    /***
     * Create function for sql update
     **/
    public function addSqlUpdate()
    {
        $this->addLine(ESP.'public function update ( '.ucfirst($this->tableName).'VO $objVo )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$values = array(', false);
        $count=0;
        foreach ($this->getColumns() as $v) {
            if (strtolower($v) != strtolower($this->keyColumnName)) {
                $this->addLine(( $count==0 ? ' ' : ESP.ESP.ESP.ESP.ESP.ESP.',').'$objVo->get'.ucfirst($v).'()');
                $count++;
            }
        }
        $this->addline(ESP.ESP.ESP.ESP.ESP.ESP.',$objVo->get'.ucfirst($this->keyColumnName).'() );');
        $this->addLine(ESP.ESP.'$sql = \'update '.$this->hasSchema().$this->getTableName().' set ');
        $count=0;
        foreach ($this->getColumns() as $v) {
            if (strtolower($v) != strtolower($this->keyColumnName)) {
            	$param = $this->charParam;
                $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.( $count==0 ? ' ' : ',').$v.' = '.$param);
                $count++;
            }
        }
        $param = $this->charParam;
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.'where '.$this->keyColumnName.' = '.$param.'\';');
        //$this->addExecuteSql(true);
        $this->addLine(ESP.ESP.'$result = $this->tpdo->executeSql($sql, $values);');
        $this->addLine(ESP.ESP.'return intval($result);');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    /***
     * Create function for sql delete
     **/
    public function addSqlDelete()
    {
        $this->addLine(ESP.'public function delete( $id )');
        $this->addLine(ESP.'{');
        $this->addValidateTypeInt(ESP.ESP);
        $this->addLine(ESP.ESP.'$values = array($id);');
        $this->addLine(ESP.ESP.'$sql = \'delete from '.$this->hasSchema().$this->getTableName().' where '.$this->keyColumnName.' = '.$this->charParam.'\';');
        $this->addExecuteSql(true);
        $this->addLine(ESP.'}');
    }
    public function addExecProcedure()
    {
        $this->addLine(ESP.'public function execProcedure( '.ucfirst($this->tableName).'VO $objVo )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$parameters = null;');
        if ($this->getDatabaseManagementSystem() == DBMS_MYSQL) {
            foreach ($this->getColumns() as $v) {
                if (strtolower($v) != strtolower($this->keyColumnName)) {
                    $vPHP = '$'.$v;
                    $this->addBlankLine();
                    $this->addLine(ESP.ESP.$vPHP.' = $objVo->get'.ucfirst($v).'();');
                    $this->addLine(ESP.ESP.$vPHP.' = SqlHelper::attributeIsset('.$vPHP.',\' , '.$v.' =\'.'.$vPHP.',\'\');');
                    $this->addLine(ESP.ESP.'$parameters = $parameters.'.$vPHP.';');
                }else{
                    $vPHP = '$'.$v;
                    $this->addBlankLine();
                    $this->addLine(ESP.ESP.$vPHP.' = $objVo->get'.ucfirst($v).'();');
                    $this->addLine(ESP.ESP.$vPHP.' = SqlHelper::attributeIsset('.$vPHP.',\' '.$v.' =\'.'.$vPHP.',\'\');');
                    $this->addLine(ESP.ESP.'$parameters = $parameters.'.$vPHP.';');
                }
            }            
            $this->addLine(ESP.ESP.'$sql = \'CALL '.$this->hasSchema().$this->getTableName().'(\'.$parameters.\')\';');
        }
        if ($this->getDatabaseManagementSystem() == DBMS_SQLSERVER) {
            foreach ($this->getColumns() as $v) {
                if (strtolower($v) != strtolower($this->keyColumnName)) {
                    $vPHP = '$'.$v;
                    $this->addBlankLine();
                    $this->addLine(ESP.ESP.$vPHP.' = $objVo->get'.ucfirst($v).'();');
                    $this->addLine(ESP.ESP.$vPHP.' = SqlHelper::attributeIsset('.$vPHP.',\' , @'.$v.' =\'.'.$vPHP.',\'\');');
                    $this->addLine(ESP.ESP.'$parameters = $parameters.'.$vPHP.';');
                }else{
                    $vPHP = '$'.$v;
                    $this->addBlankLine();
                    $this->addLine(ESP.ESP.$vPHP.' = $objVo->get'.ucfirst($v).'();');
                    $this->addLine(ESP.ESP.$vPHP.' = SqlHelper::attributeIsset('.$vPHP.',\' @'.$v.' =\'.'.$vPHP.',\'\');');
                    $this->addLine(ESP.ESP.'$parameters = $parameters.'.$vPHP.';');
                }
            }
            $this->addBlankLine();
            $this->addLine(ESP.ESP.'$sql = \'EXEC '.$this->hasSchema().$this->getTableName().'(\'.$parameters.\')\';');
        }
        $this->addExecuteSql(false);
        $this->addLine(ESP.'}');
    }    
    //--------------------------------------------------------------------------------------
    public function addConstruct()
    {
        $this->addLine(ESP.'private $tpdo = null;');
        $this->addBlankLine();
        $this->addLine(ESP.'public function __construct($tpdo=null)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'FormDinHelper::validateObjTypeTPDOConnectionObj($tpdo,__METHOD__,__LINE__);');
        $this->addLine(ESP.ESP.'if( empty($tpdo) ){');
        $this->addLine(ESP.ESP.ESP.'$tpdo = New TPDOConnectionObj();');
        $this->addLine(ESP.ESP.'}');
        $this->addLine(ESP.ESP.'$this->setTPDOConnection($tpdo);');
        $this->addLine(ESP.'}');
        $this->addLine(ESP.'public function getTPDOConnection()');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'return $this->tpdo;');
        $this->addLine(ESP.'}');
        $this->addLine(ESP.'public function setTPDOConnection($tpdo)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'FormDinHelper::validateObjTypeTPDOConnectionObj($tpdo,__METHOD__,__LINE__);');
        $this->addLine(ESP.ESP.'$this->tpdo = $tpdo;');
        $this->addLine(ESP.'}');        
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addLine('class '.ucfirst($this->getTableName()).'DAO ');
        $this->addLine('{');
        if($this->getTableType() != TableInfo::TB_TYPE_PROCEDURE){
            $this->addBlankLine();
            $this->addSqlVariable();
        }
        $this->addBlankLine();
        
        // construct
        $this->addConstruct();
        if($this->getTableType() == TableInfo::TB_TYPE_PROCEDURE){
            $this->addExecProcedure();
        }else{
            $this->addProcessWhereGridParameters();
            
            // select by Id
            $this->addLine();
            $this->addSqlSelectById();
            // fim select
            
            // Select Count
            $this->addLine();
            $this->addSqlSelectCount();
            // fim Select Count
            
            if ($this->getWithSqlPagination() == GRID_SQL_PAGINATION) {
                $this->addLine();
                $this->addSqlSelectAllPagination();
            }
            
            // select where
            $this->addLine();
            $this->addSqlSelectAll();
            // fim select

            if($this->getTableType() == TableInfo::TB_TYPE_TABLE){        
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
            $this->addGetVoById();
        }
        
        //-------- FIM
        $this->addLine("}");
        $this->addLine("?>");
        return $this->showContent($print);
    }
    //--------------------------------------------------------------------------------------
    /**
     * Returns the number of parameters
     *
     * @return string
     */
    public function getParams()
    {
        $cols = $this->getColumns();
        $qtd = count($cols);
        $result = '';
        for ($i = 1; $i <= $qtd; $i++) {
            if ($cols[$i-1] != strtolower($this->keyColumnName)) {
                $result .= ($result=='') ? '' : ',';
                $result.='?';
            }
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public function removeUnderline($txt)
    {
        $len = strlen($txt);
        for ($i = $len-1; $i >= 0; $i--) {
            if ($txt{$i} === '_') {
                $len--;
                $txt = substr_replace($txt, '', $i, 1);
                if ($i != $len) {
                    $txt{$i} = strtoupper($txt{$i});
                }
            }
        }
        return $txt;
    }
}