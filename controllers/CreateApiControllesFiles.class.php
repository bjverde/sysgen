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


class CreateApiControllesFiles extends TCreateFileContent
{
    private $tableName;
    private $tableType;
    private $listColumnsProperties;
    private $columnPrimaryKey;

    public function __construct($pathFolder ,$tableName ,$listColumnsProperties, $tableType)
    {
        $tableName = ucfirst( strtolower($tableName) );
        $this->setTableName($tableName);
        $this->setTableType( strtoupper($tableType) );
        $this->setFileName($tableName.'API.class.php');
        $this->setFilePath($pathFolder);
        $this->setListColumnsProperties($listColumnsProperties);
        $this->configArrayColumns();
    }
    //-----------------------------------------------------------------------------------
    public function setTableName($strTableName)
    {
        $this->tableName=$strTableName;
    }
    public function getTableName()
    {
        return $this->tableName;
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
        $columnPrimaryKey = $listColumns[0];
        $this->setColumnPrimaryKey($columnPrimaryKey);
    }
    //--------------------------------------------------------------------------------------
    public function setColumnPrimaryKey($columnPrimaryKey)
    {
        $columnPrimaryKey = ( !empty($columnPrimaryKey) ) ?$columnPrimaryKey : "id";
        $this->columnPrimaryKey    = strtoupper($columnPrimaryKey);
    }
    public function getColumnPrimaryKey()
    {
        return $this->columnPrimaryKey;
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
    public function addConstruct()
    {
        $this->addBlankLine();
        $this->addLine(ESP.'public function __construct()');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function addBodyJsonResponse($qtdEspacos,$status)
    {
        $this->addLine($qtdEspacos.'$response = TGenericAPI::getBodyJson($msg,$response,'.$status.');');
        $this->addLine($qtdEspacos.'return $response;');
    }
    //--------------------------------------------------------------------------------------
    public function addCatchBodyJsonResponse($qtdEspacos,$status)
    {    
        $this->addLine($qtdEspacos.'} catch ( \Exception $e) {');
        $this->addLine($qtdEspacos.ESP.'$msg = $e->getMessage();');
        $this->addBodyJsonResponse($qtdEspacos.ESP,$status);
        $this->addLine($qtdEspacos.'}');
    }
    //--------------------------------------------------------------------------------------
    public function addSelectAll()
    {
        $this->addBlankLine();
        $this->addLine();
        $this->addLine(ESP.'public static function selectAll(Request $request, Response $response, array $args)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'try{');
        $this->addLine(ESP.ESP.ESP.'$param = $request->getQueryParams();');
        $this->addLine(ESP.ESP.ESP.'$page = TGenericAPI::getSelectNumPage($param);');
        $this->addLine(ESP.ESP.ESP.'$rowsPerPage = TGenericAPI::getSelectNumRowsPerPage($param);');
        $this->addLine(ESP.ESP.ESP.'$orderBy = null;');
        $this->addLine(ESP.ESP.ESP.'$where = array();');
        $this->addLine(ESP.ESP.ESP.'$controller = new \\'.ucfirst( $this->getTableName() ).'();');
        $this->addLine(ESP.ESP.ESP.'//$result = $controller->selectAll();');
        $this->addLine(ESP.ESP.ESP.'$qtd_total = $controller->selectCount( $where );');
        $this->addLine(ESP.ESP.ESP.'$result = $controller->selectAllPagination( $orderBy, $where, $page,  $rowsPerPage);');
        $this->addLine(ESP.ESP.ESP.'$result = \ArrayHelper::convertArrayFormDin2Pdo($result);');
        $this->addLine(ESP.ESP.ESP.'$msg = array( \'qtd_total\'=> $qtd_total');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.', \'qtd_result\'=> \CountHelper::count($result)');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.', \'page\'=>$page');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.', \'pages\'=>$page');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.', \'result\'=>round($qtd_total/$rowsPerPage)');
        $this->addLine(ESP.ESP.ESP.');');
        $this->addBodyJsonResponse(ESP.ESP.ESP,200);
        $this->addCatchBodyJsonResponse(ESP.ESP,500);
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function addSelectByIdInside()
    {
        $this->addBlankLine();
        $this->addLine();
        $this->addLine(ESP.'private static function selectByIdInside(array $args)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$id = $args[\'id\'];');
        $this->addLine(ESP.ESP.'$controller = new \\'.ucfirst( $this->getTableName() ).'();');
        $this->addLine(ESP.ESP.'$result = $controller->selectById($id);');
        $this->addLine(ESP.ESP.'$result = \ArrayHelper::convertArrayFormDin2Pdo($result);');
        $this->addLine(ESP.ESP.'return $result;');
        $this->addLine(ESP.'}');
    }    
    //--------------------------------------------------------------------------------------
    public function addSelectById()
    {
        $this->addBlankLine();
        $this->addLine();
        $this->addLine(ESP.'public static function selectById(Request $request, Response $response, array $args)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'try{');
        $this->addLine(ESP.ESP.ESP.'$result = self::selectByIdInside($args);');
        $this->addLine(ESP.ESP.ESP.'$msg = array( \'qtd\'=> \CountHelper::count($result)');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.', \'result\'=>$result');
        $this->addLine(ESP.ESP.ESP.');');
        $this->addBodyJsonResponse(ESP.ESP.ESP,200);
        $this->addCatchBodyJsonResponse(ESP.ESP,500);
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function addSetVo()
    {
        $this->addBlankLine();
        $this->addLine();
        $this->addLine(ESP.'public static function setVo($args,$request)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$bodyRequest = json_decode($request->getBody(),true);');
        $this->addLine(ESP.ESP.'$vo = new \\'.ucfirst( $this->getTableName() ).'VO;');
        $this->addLine(ESP.ESP.'$vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);');
        $this->addLine(ESP.ESP.'if($request->isPut()){');
        $this->addLine(ESP.ESP.ESP.'$vo->set'.ucfirst( $this->getColumnPrimaryKey() ).'($args[\'id\']);');
        $this->addLine(ESP.ESP.'}');
        $this->addLine(ESP.ESP.'return $vo;');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function addSave()
    {
        $this->addBlankLine();
        $this->addLine();
        $this->addLine(ESP.'public static function save(Request $request, Response $response, array $args)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'try{');            
        $this->addLine(ESP.ESP.ESP.'$vo = new \\'.ucfirst( $this->getTableName() ).'VO;');
        $this->addLine(ESP.ESP.ESP.'$msg = \Message::GENERIC_INSERT;');
        $this->addLine(ESP.ESP.ESP.'if($request->getMethod() == \'PUT\'){');
        $this->addLine(ESP.ESP.ESP.ESP.'$msg = \Message::GENERIC_UPDATE;');
        $this->addLine(ESP.ESP.ESP.ESP.'$result = self::selectByIdInside($args);');
        $this->addLine(ESP.ESP.ESP.ESP.'$bodyRequest = \ArrayHelper::get($result,0);');
        $this->addLine(ESP.ESP.ESP.ESP.'if( empty($bodyRequest) ){');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.'throw new \DomainException(\Message::GENERIC_ID_NOT_EXIST);');
        $this->addLine(ESP.ESP.ESP.ESP.'}');
        $this->addLine(ESP.ESP.ESP.ESP.'$vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);');
        $this->addLine(ESP.ESP.ESP.'}');
        $this->addLine(ESP.ESP.ESP.'$bodyRequest = json_decode($request->getBody(),true);');
        $this->addLine(ESP.ESP.ESP.'if( empty($bodyRequest) ){');
        $this->addLine(ESP.ESP.ESP.ESP.'$bodyRequest = $request->getParsedBody();');
        $this->addLine(ESP.ESP.ESP.'}');
        $this->addLine(ESP.ESP.ESP.'$vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);');
        $this->addLine(ESP.ESP.ESP.'$controller = new \\'.ucfirst( $this->getTableName() ).';');
        $this->addLine(ESP.ESP.ESP.'$controller->save($vo);');
        $this->addBlankLine();
        $this->addBodyJsonResponse(ESP.ESP.ESP,200);
        $this->addCatchBodyJsonResponse(ESP.ESP,500);
        $this->addLine(ESP.'}');
    }    
    //--------------------------------------------------------------------------------------
    public function addDelete()
    {
        $this->addBlankLine();
        $this->addLine();
        $this->addLine(ESP.'public static function delete(Request $request, Response $response, array $args)');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'try{');
        $this->addLine(ESP.ESP.ESP.'$id = $args[\'id\'];');
        $this->addLine(ESP.ESP.ESP.'$controller = new \\'.ucfirst( $this->getTableName() ).';');
        $this->addLine(ESP.ESP.ESP.'$msg = $controller->delete($id);');
        $this->addLine(ESP.ESP.ESP.'if($msg==true){');
        $this->addLine(ESP.ESP.ESP.ESP.'$msg = \Message::GENERIC_DELETE;');
        $this->addLine(ESP.ESP.ESP.ESP.'$msg = $msg.\' id=\'.$id;');
        $this->addLine(ESP.ESP.ESP.'}');
        $this->addBodyJsonResponse(ESP.ESP.ESP,200);
        $this->addCatchBodyJsonResponse(ESP.ESP,500);
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('namespace api_controllers;');
        $this->addBlankLine();
        $this->addLine('use Psr\Http\Message\ServerRequestInterface as Request;');
        $this->addLine('use Psr\Http\Message\ResponseInterface as Response;');
        $this->addBlankLine();
        $this->addLine('class '.ucfirst( $this->getTableName() ).'API');
        $this->addLine('{');
        $this->addConstruct();
        $this->addSelectAll();
        $this->addSelectByIdInside();
        $this->addSelectById();
        if( $this->getTableType() == TableInfo::TB_TYPE_TABLE ){
            $this->addSave();
            $this->addDelete();
        }
        $this->addLine('}');
        return $this->showContent($print);
    }
}
