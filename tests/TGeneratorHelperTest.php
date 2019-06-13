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
