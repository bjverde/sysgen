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

$path =  __DIR__.'/../';
require_once $path.'includes/constantes.php';
require_once $path.'classes/autoload_sysgen.php';

use PHPUnit\Framework\TestCase;

class TCreateMenuTest extends TestCase
{
    
    /**
     * @var TCreateMenu
     */
    private $createMenu;
    
    
    protected function includeTable($tableSelected, $tableSchema, $tableName, $tableType)
    {
        $tableSelected['TABLE_SCHEMA'][] = $tableSchema;
        $tableSelected['TABLE_NAME'][]   = $tableName;
        $tableSelected['TABLE_TYPE'][]   = $tableType;
        return $tableSelected;
    }
    
    protected function generateTablesSelected3t5v()
    {
        $tableSelected = array();
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'menu' , TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'acess', TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'vitem', TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'list' , TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v2'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v3'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v4'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v5'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        return $tableSelected;
    }
    
    protected function generateTablesSelected1t7v()
    {
        $tableSelected = array();
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'menu' , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'acess', TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'vitem', TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'list' , TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v2'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v3'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v4'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v5'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        return $tableSelected;
    }
    
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        if (!defined('ROOT_PATH')) {
            define('ROOT_PATH', "pasta");
        }
        if (!defined('APLICATIVO')) {
            define('APLICATIVO', 'PHPUnit');
        }
        $_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM']='test';
        
        //$listTableNames   = $this->generateTablesSelected();
        $this->createMenu = new TCreateMenu(null);
    }
    
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->createMenu = null;
        parent::tearDown();
    }
    
    public function testAddBasicMenuCruds_3tables()
    {
        $expected = 4; //4 Tables + 1 header line
        $listTableNames   = $this->generateTablesSelected3t5v();
        $this->createMenu->setListTableNames($listTableNames);
        $this->createMenu->addBasicMenuCruds();
        $resultArray = $this->createMenu->getLinesArray();
        $size = CountHelper::count($resultArray);
        $this->assertEquals($expected, $size);
    }
    
    public function testAddBasicMenuCruds_1tables()
    {
        $expected = 2; //1 Tables + 1 header line
        $listTableNames   = $this->generateTablesSelected1t7v();
        $this->createMenu->setListTableNames($listTableNames);
        $this->createMenu->addBasicMenuCruds();
        $resultArray = $this->createMenu->getLinesArray();
        $size = CountHelper::count($resultArray);
        $this->assertEquals($expected, $size);
    }
    
    public function testAddBasicMenuViews_5Views()
    {
        $expected = 6; //5 Views + 1 header line
        $listTableNames   = $this->generateTablesSelected3t5v();
        $this->createMenu->setListTableNames($listTableNames);
        $this->createMenu->addBasicMenuViews();
        $resultArray = $this->createMenu->getLinesArray();
        $size = CountHelper::count($resultArray);
        $this->assertEquals($expected, $size);
    }
    
    public function testAddBasicMenuViews_7Views()
    {
        $expected = 8; //7 Views + 1 header line
        $listTableNames   = $this->generateTablesSelected1t7v();
        $this->createMenu->setListTableNames($listTableNames);
        $this->createMenu->addBasicMenuViews();
        $resultArray = $this->createMenu->getLinesArray();
        $size = CountHelper::count($resultArray);
        $this->assertEquals($expected, $size);
    }
}
