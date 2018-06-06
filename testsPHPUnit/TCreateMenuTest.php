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

header('Location: ../index.php');


require_once '../classes/autoload_sysgen.php';
//require_once('../classes/TCreateMenu.class.php');

class TCreateMenuTest extends PHPUnit_Framework_TestCase
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
        $tableSelected = isset($tableSelected) ? $tableSelected : null;
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'menu', 'TABLE');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'acess', 'TABLE');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'vitem', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'list', 'TABLE');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v2', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v3', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v4', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v5', 'VIEW');
        return $tableSelected;
    }
    
    protected function generateTablesSelected1t7v()
    {
        $tableSelected = isset($tableSelected) ? $tableSelected : null;
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'menu', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'acess', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'vitem', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'list', 'TABLE');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v2', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v3', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v4', 'VIEW');
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v5', 'VIEW');
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
    
    public function testQtdItensMenuOnlyTableNotViews3t()
    {
        $listTableNames   = $this->generateTablesSelected3t5v();
        $this->createMenu->setListTableNames($listTableNames);
        $this->createMenu->addBasicMenuItems();
        $resultArray = $this->createMenu->getLinesArray();
        $size = count($resultArray);
        $this->assertEquals(3, $size);
    }
    
    public function testQtdItensMenuOnlyTableNotViews()
    {
        $listTableNames   = $this->generateTablesSelected1t7v();
        $this->createMenu->setListTableNames($listTableNames);
        $this->createMenu->addBasicMenuItems();
        $resultArray = $this->createMenu->getLinesArray();
        $size = count($resultArray);
        $this->assertEquals(1, $size);
    }
}
