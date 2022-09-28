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

class CreateControllers extends TCreateFileContent
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
        $path = TGeneratorHelper::getPathNewSystem().DS.'controllers'.DS;
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
        TGeneratorHelper::validateListColumnsProperties($listColumnsProperties);
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
    public  function addConstruct()
    {
        $this->addLine(ESP.'private $dao = null;');
        $this->addBlankLine();
        $this->addLine(ESP.'public function __construct($tpdo = null)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$this->dao = new '.$this->tableRefDAO.'($tpdo);');
        $this->addLine(ESP.'}');
        $this->addLine(ESP.'public function getDao()');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'return $this->dao;');
        $this->addLine(ESP.'}');
        $this->addLine(ESP.'public function setDao($dao)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$this->dao = $dao;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSelectById()
    {
        $this->addLine(ESP.'public function selectById( $id )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = $this->dao->selectById( $id );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function addGetVoById()
    {
        $this->addLine(ESP.'public function getVoById( $id )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = $this->dao->getVoById( $id );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSelectCount()
    {
        $this->addLine(ESP.'public function selectCount( $where=null )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = $this->dao->selectCount( $where );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSelectAllPagination()
    {
        $this->addLine(ESP.'public function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = $this->dao->selectAllPagination( $orderBy, $where, $page,  $rowsPerPage );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSelectAll()
    {
        $this->addLine(ESP.'public function selectAll( $orderBy=null, $where=null )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = $this->dao->selectAll( $orderBy, $where );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addValidatePkNotExist()
    {
        $columunPK = strtoupper($this->listColumnsName[0]);
        $this->addLine();
        $this->addLine(ESP.'private function validatePkNotExist( $id )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$where=array(\''.$columunPK.'\'=>$id);');
        $this->addLine(ESP.ESP.'$qtd = $this->selectCount($where);');
        $this->addLine(ESP.ESP.'if($qtd >= 1){');
        $this->addLine(ESP.ESP.ESP.'throw new DomainException(Message::GENERIC_ID_NOT_EXIST);');
        $this->addLine(ESP.ESP.'}');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addSave()
    {
        $columunPK = ucfirst(strtolower($this->listColumnsName[0]));
        $this->addLine();
        $this->addLine(ESP.'public function save( '.$this->tableRefVO.' $objVo )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = null;');
        $this->addLine(ESP.ESP.'if( $objVo->get'.$columunPK.'() ) {');
        $this->addLine(ESP.ESP.'$this->validatePkNotExist( $id );');
        $this->addLine(ESP.ESP.ESP.'$result = $this->dao->update( $objVo );');
        $this->addLine(ESP.ESP.'} else {');
        $this->addLine(ESP.ESP.ESP.'$result = $this->dao->insert( $objVo );');
        $this->addLine(ESP.ESP.'}');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addDelete()
    {
        $this->addLine();
        $this->addLine(ESP.'public function delete( $id )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$this->validatePkNotExist( $id );');
        $this->addLine(ESP.ESP.'$result = $this->dao->delete( $id );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function addExecProcedure()
    {
        $this->addLine();
        $this->addLine(ESP.'public function execProcedure( '.$this->tableRefVO.' $objVo )');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = $this->dao->execProcedure( $objVo );');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addLine('class '.$this->tableRef);
        $this->addLine('{');
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addConstruct();
        
        if( $this->getTableType()== TableInfo::TB_TYPE_PROCEDURE){
            $this->addExecProcedure();
        }else{
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

            if( $this->getTableType()==TableInfo::TB_TYPE_TABLE){
                $this->addValidatePkNotExist();
                $this->addSave();
                $this->addDelete();
            }
            $this->addLine();
            $this->addGetVoById();
        }
        $this->addBlankLine();        
        $this->addLine('}');
        $this->addLine('?>');
        return $this->showContent($print);
    }
}
