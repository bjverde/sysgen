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


class CreateTestsFiles extends TCreateFileContent
{
    private $tableName;
    private $tableType;
    private $listColumnsProperties;
    private $columnPrimaryKey;

    public function __construct($tableName ,$listColumnsProperties, $tableType)
    {
        $tableName = ucfirst( strtolower($tableName) );
        $this->setTableName($tableName);
        $this->setTableType( strtoupper($tableType) );
        $this->setFileName($tableName.'Test.php');
        $pathFolder = TGeneratorHelper::getPathNewSystem().DS.'tests'.DS.'classes';
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
    public function addSetUp()
    {
        $this->addBlankLine();
        $this->addLine();
        $this->addLine(ESP.'protected function setUp()');
        $this->addLine(ESP.'{');
        $this->addLine(ESP.ESP.'parent::setUp();');
        $this->addLine(ESP.ESP.'$this->classTest = new '.ucfirst( $this->getTableName() ).';');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function addTearDowns()
    {
        $this->addBlankLine();
        $this->addLine();
        $this->addLine(ESP.'protected function tearDown()');
        $this->addLine(ESP.'{');        
        $this->addLine(ESP.ESP.'$this->classTest = null;');
        $this->addLine(ESP.ESP.'parent::setUp();');
        $this->addLine(ESP.'}');
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('$path =  __DIR__.\'/../\';');
        $this->addLine('require_once $path.\'includes/constantes.php\';');
        $this->addBlankLine();
        $this->addLine('require_once $path.\'../base/classes/webform/TApplication.class.php\';');
        $this->addLine('require_once $path.\'classes/autoload_'.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'].'.php\';');
        $this->addBlankLine();
        $this->addLine('use PHPUnit\Framework\TestCase;');        
        $this->addBlankLine();
        $this->addLine('class '.ucfirst( $this->getTableName() ).'Test extends TestCase');
        $this->addLine('{');
        $this->addBlankLine();
        $this->addLine('private $classTest;');
        $this->addSetUp();
        $this->addTearDowns();
        $this->addLine('}');
        return $this->showContent($print);
    }
}
