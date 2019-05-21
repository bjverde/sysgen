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

class CreateApiControllesFilesTest extends TestCase
{	

	private $create;	
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM']='test';
		$listColumnsProperties  = array();
		$listColumnsProperties['COLUMN_NAME'][] = 'idTest';
		$listColumnsProperties['COLUMN_NAME'][] = 'nm_test';
		$listColumnsProperties['COLUMN_NAME'][] = 'tip_test';
		$this->create = new CreateApiControllesFiles('api','test',$listColumnsProperties,TGeneratorHelper::TABLE_TYPE_TABLE);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		parent::tearDown ();
		$this->create = null;
	}
		
	public function testShow(){
	    $expected = array();
	    $expected[12] = 'namespace api_controllers;'.EOL;
	    $expected[13] = EOL;
	    $expected[14] = 'use Psr\Http\Message\ServerRequestInterface as Request;'.EOL;
	    $expected[15] = 'use Psr\Http\Message\ResponseInterface as Response;'.EOL;
	    $expected[16] = EOL;
	    $expected[17] = 'class TestAPI'.EOL;
	    $expected[18] = '{'.EOL;
	    
	    $resultArray = $this->create->show('array');
	    $this->assertSame($expected[12], $resultArray[12]);
	    $this->assertSame($expected[13], $resultArray[13]);
	    $this->assertSame($expected[14], $resultArray[14]);
	    $this->assertSame($expected[15], $resultArray[15]);
	    $this->assertSame($expected[16], $resultArray[16]);
	    $this->assertSame($expected[17], $resultArray[17]);
	    $this->assertSame($expected[18], $resultArray[18]);
	}
}