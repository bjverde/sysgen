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

class TCreateClassTest extends TestCase
{	

	private $create;	
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$listColumnsProperties  = array();
		$listColumnsProperties['COLUMN_NAME'][] = 'idTest';
		$listColumnsProperties['COLUMN_NAME'][] = 'nm_test';
		$listColumnsProperties['COLUMN_NAME'][] = 'tip_test';
		$this->create = new TCreateClass('test');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		parent::tearDown ();
		$this->create = null;
	}

	public function testAddConstruct(){
	    $expected = array();
	    $expected[] = ESP.'private $dao = null;'.EOL;
		$expected[] = EOL;
		$expected[] = ESP.'public function __construct()'.EOL;
		$expected[] = ESP.'{'.EOL;
		$expected[] = ESP.ESP.'$this->dao = new TestDAO();'.EOL;
		$expected[] = ESP.'}'.EOL;
		
		$this->create->addConstruct();
	    $resultArray = $this->create->getLinesArray();
	    $this->assertSame($expected[0], $resultArray[0]);
	    $this->assertSame($expected[1], $resultArray[1]);
	    $this->assertSame($expected[2], $resultArray[2]);
	    $this->assertSame($expected[3], $resultArray[3]);
	    $this->assertSame($expected[4], $resultArray[4]);
	    $this->assertSame($expected[5], $resultArray[5]);
	}
	
	public function testShow_VIEW_numLines(){
	    $expectedQtd = 50;
	    
	    $this->create->setTableType(TGeneratorHelper::TABLE_TYPE_VIEW);
	    $resultArray = $this->create->show('array');
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testShow_VIEW_GridSqlPagination_numLines(){
	    $expectedQtd = 56;
	    
	    $this->create->setWithSqlPagination(GRID_SQL_PAGINATION);
	    $this->create->setTableType(TGeneratorHelper::TABLE_TYPE_VIEW);
	    $resultArray = $this->create->show('array');
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testShow_TABLE_numLines(){
	    $expectedQtd = 50;	    
	    
	    $resultArray = $this->create->show('array');
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testShow_TABLE_GridSqlPagination_numLines(){
	    $expectedQtd = 56;
	    
	    $this->create->setWithSqlPagination(GRID_SQL_PAGINATION);
	    $resultArray = $this->create->show('array');
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testShow(){
	    $expected = array();
	    $expected[11] = 'class Test'.EOL;
	    $expected[12] = '{'.EOL;
	    
	    $resultArray = $this->create->show('array');
	    $this->assertSame($expected[11], $resultArray[11]);
	    $this->assertSame($expected[12], $resultArray[12]);
	}
}