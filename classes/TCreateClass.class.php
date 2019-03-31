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

class TCreateClass extends TCreateFileContent
{
    private $tableRef;
    private $tableRefDAO;
    private $tableRefVO;
    private $withSqlPagination;
    private $listColumnsName;
    private $listColumnsProperties;
    private $tableType = null;
    
    public function __construct($tableRef)
    {
        $tableRef = ucfirst(strtolower($tableRef));
        $this->tableRef   = $tableRef;
        $this->tableRefDAO= $tableRef.'DAO';
        $this->tableRefVO = $tableRef.'VO';
        $this->setFileName($tableRef.'.class.php');
        $path = TGeneratorHelper::getPathNewSystem().DS.'classes'.DS;
        $this->setFilePath($path);
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
    //--------------------------------------------------------------------------------------
    public function setListColunnsName($listColumnsName)
    {
        if (!is_array($listColumnsName)) {
            throw new InvalidArgumentException('List of Columns Properties not is a array');
        }
        $this->listColumnsName = array_map('strtoupper', $listColumnsName);
    }
    public function getListColunnsName()
    {
        return $this->listColumnsName;
    }
    //--------------------------------------------------------------------------------------
    public function setListColumnsProperties($listColumnsProperties)
    {
        if (!is_array($listColumnsProperties)) {
            throw new InvalidArgumentException('List of Columns Properties not is a array');
        }
        $this->listColumnsProperties = $listColumnsProperties;
    }
    public function getListColumnsProperties()
    {
        return $this->listColumnsProperties;
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
    //--------------------------------------------------------------------------------------
    private function addConstruct()
    {
        $this->addLine(ESP.'public function __construct()');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSelectById()
    {
        $this->addLine(ESP.'public static function selectById( $id )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = '.$this->tableRefDAO.'::selectById( $id );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSelectCount()
    {
        $this->addLine(ESP.'public static function selectCount( $where=null )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = '.$this->tableRefDAO.'::selectCount( $where );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSelectAllPagination()
    {
        $this->addLine(ESP.'public static function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = '.$this->tableRefDAO.'::selectAllPagination( $orderBy, $where, $page,  $rowsPerPage );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSelectAll()
    {
        $this->addLine(ESP.'public static function selectAll( $orderBy=null, $where=null )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = '.$this->tableRefDAO.'::selectAll( $orderBy, $where );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSave()
    {
        $columunPK = ucfirst(strtolower($this->listColumnsName[0]));
        $this->addLine(ESP.'public function save( '.$this->tableRefVO.' $objVo )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = null;');
        $this->addLine(ESP.ESP.'if( $objVo->get'.$columunPK.'() ) {');
        $this->addLine(ESP.ESP.ESP.'$result = '.$this->tableRefDAO.'::update( $objVo );');
        $this->addLine(ESP.ESP.'} else {');
        $this->addLine(ESP.ESP.ESP.'$result = '.$this->tableRefDAO.'::insert( $objVo );');
        $this->addLine(ESP.ESP.'}');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addDelete()
    {
        $this->addLine(ESP.'public function delete( $id )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = '.$this->tableRefDAO.'::delete( $id );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('class '.$this->tableRef);
        $this->addLine('{');
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addConstruct();
        
        $this->addLine();
        $this->addSelectById();

        $this->addLine();
        $this->addSelectCount();
        
        if ($this->getWithSqlPagination() == GRID_SQL_PAGINATION) {
            $this->addLine();
            $this->addSelectAllPagination();
        }
        
        $this->addLine();
        $this->addSelectAll();
        
        if ($this->getTableType() == TGeneratorHelper::TABLE_TYPE_TABLE) {
            $this->addLine();
            $this->addSave();
            
            $this->addLine();
            $this->addDelete();
        }
        
        $this->addBlankLine();
        $this->addLine('}');
        $this->addLine('?>');
        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
