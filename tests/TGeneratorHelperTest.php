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

$pathBase =  __DIR__.'/../../base/';
require_once $pathBase.'classes/constants.php';
require_once $pathBase.'classes/helpers/autoload_formdin_helper.php';
require_once $pathBase.'classes/webform/autoload_formdin.php';

$path =  __DIR__.'/../';
require_once $path.'includes/constantes.php';
require_once $path.'controllers/autoload_sysgen.php';
require_once 'mockDatabase.php';

use PHPUnit\Framework\TestCase;

class TGeneratorHelperTest extends TestCase
{
    private $mockDatabase;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->mockDatabase = new mockDatabase();
    }
    
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
    
    public function testGetConfigGridSqlServer_ScreenPagination()
    {
        $result = GRID_SCREEN_PAGINATION;
        $_SESSION[APLICATIVO]['DBMS']['VERSION'] = TableInfo::DBMS_VERSION_SQLSERVER_2012_LT;
        $expected = TGeneratorHelper::getConfigGridSqlServer(DBMS_SQLSERVER);
        $this->assertEquals($expected, $result);
    }
    
    public function testGetConfigGridSqlServer_SqlPagination()
    {
        $result = GRID_SQL_PAGINATION;
        $_SESSION[APLICATIVO]['DBMS']['VERSION'] = TableInfo::DBMS_VERSION_SQLSERVER_2012_GTE;
        $expected = TGeneratorHelper::getConfigGridSqlServer(DBMS_SQLSERVER);
        $this->assertEquals($expected, $result);
    }
    
    public function addRowFieldSelectedTable($listFieldSelectedTable
                                            ,$COLUMN_NAME
                                            ,$KEY_TYPE
                                            ,$REFERENCED_TABLE_NAME
                                            ,$REFERENCED_COLUMN_NAME
                                            )
    {
        $listFieldSelectedTable['COLUMN_NAME'][]=$COLUMN_NAME;
        $listFieldSelectedTable['KEY_TYPE'][]=$KEY_TYPE;
        $listFieldSelectedTable['REFERENCED_TABLE_NAME'][]=$REFERENCED_TABLE_NAME;
        $listFieldSelectedTable['REFERENCED_COLUMN_NAME'][]=$REFERENCED_COLUMN_NAME;
        return $listFieldSelectedTable;
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testRemoveFieldsDuplicateOnSelectedTable_FailNull()
    {
        $listFieldsTable = null;        
        $this->assertNull( TGeneratorHelper::removeFieldsDuplicateOnSelectedTables($listFieldsTable) );
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testRemoveFieldsDuplicateOnSelectedTable_FailArrayNull()
    {
        $listFieldsTable = array();
        $this->assertNull( TGeneratorHelper::removeFieldsDuplicateOnSelectedTables($listFieldsTable) );
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testRemoveFieldsDuplicateOnSelectedTable_FailString()
    {
        $listFieldsTable = 'xxx';
        $this->assertNull( TGeneratorHelper::removeFieldsDuplicateOnSelectedTables($listFieldsTable) );
    }
    
    
    public function testRemoveFieldsDuplicateOnSelectedTable_OkNoDuplicate()
    {
        $listFieldsTable = array();
        $listFieldsTable = $this->addRowFieldSelectedTable($listFieldsTable,'idCarro','PK',null,null);
        $listFieldsTable = $this->addRowFieldSelectedTable($listFieldsTable,'idMarca','FK','marca','idMarca');
        $listFieldsTable = $this->addRowFieldSelectedTable($listFieldsTable,'nmCarro',null,null,null);
        $listFieldsTable = $this->addRowFieldSelectedTable($listFieldsTable,'anoCarro',null,null,null);
        
        $expected = $listFieldsTable;
        
        $result = TGeneratorHelper::removeFieldsDuplicateOnSelectedTables($listFieldsTable);
        $sizeResult = CountHelper::count($result['COLUMN_NAME']);
        $this->assertEquals( 4, $sizeResult);
        $this->assertEquals($expected, $result);
    }
    
    /*
    public function testRemoveFieldsDuplicateOnSelectedTable_OkRemoveDuplicate()
    {
        $listFieldsTable = array();
        $listFieldsTable = $this->addRowFieldSelectedTable($listFieldsTable,'idCarro','PK',null,null);
        $listFieldsTable = $this->addRowFieldSelectedTable($listFieldsTable,'idMarca','FK','marca','idMarca');
        $listFieldsTable = $this->addRowFieldSelectedTable($listFieldsTable,'idMarca','UNIQUE','marca','idMarca');
        $listFieldsTable = $this->addRowFieldSelectedTable($listFieldsTable,'nmCarro',null,null,null);
        $listFieldsTable = $this->addRowFieldSelectedTable($listFieldsTable,'anoCarro',null,null,null);
        
        $expected = ArrayHelper::formDinDeleteRowByKeyIndex($listFieldsTable, 2);
        $expected = $expected['formarray'];
        
        $result = TGeneratorHelper::removeFieldsDuplicateOnSelectedTables($listFieldsTable);
        $sizeResult = CountHelper::count($result['COLUMN_NAME']);
        $this->assertEquals( 4, $sizeResult);
        $this->assertEquals($expected, $result);
    }
    */
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testValidateListTableNames_null()
    {
        TGeneratorHelper::validateListTableNames(null);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testValidateListTableNames_string()
    {
        TGeneratorHelper::validateListTableNames('x');
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testValidateListColumnsProperties_null()
    {
        TGeneratorHelper::validateListColumnsProperties(null);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testValidateListColumnsProperties_string()
    {
        TGeneratorHelper::validateListColumnsProperties('x');
    }
}
