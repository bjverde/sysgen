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

    public function __construct($pathFolder ,$tableName ,$listColumnsProperties, $tableType)
    {
        $tableName = strtolower($tableName);
        $this->setTableName(ucfirst($tableName));
        $this->setTableType($tableType);
        $this->setFileName($tableName.'API.class.php');
        $this->setFilePath($pathFolder);
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
    public function setTableType($tableType)
    {
        $this->tableType = $tableType;
    }
    public function getTableType()
    {
        return $this->tableType;
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addLine('namespace Controllers;');
        $this->addBlankLine();
        $this->addLine('use Psr\Http\Message\ServerRequestInterface as Request;');
        $this->addLine('use Psr\Http\Message\ResponseInterface as Response;');
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addLine('class '.ucfirst( $this->getTableName() ).'API');
        $this->addLine('{');
        $this->addBlankLine();
        $this->addLine(ESP.'public function __construct()');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.'}');
        $this->addLine();
        $this->addLine(ESP.'public static function selectAll(Request $request, Response $response, array $args): Response');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'$result = \\'.ucfirst( $this->getTableName() ).'::selectAll();');
        $this->addLine(ESP.ESP.'$result = \ArrayHelper::convertArrayFormDin2Pdo($result);');
        $this->addLine(ESP.ESP.'$msg = array( \'qtd\'=> \CountHelper::count($result)');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.', \'result\'=>$result');
        $this->addLine(ESP.ESP.');');
        $this->addLine(ESP.ESP.'$response = $response->withJson($msg);');
        $this->addLine(ESP.ESP.'return $response;');
        $this->addLine(ESP.'}');
        $this->addLine('}');


        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
