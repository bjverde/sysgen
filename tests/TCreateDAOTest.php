<?php

$pathBase =  __DIR__.'/../../base/';
require_once $pathBase.'classes/constants.php';
require_once $pathBase.'classes/helpers/autoload_formdin_helper.php';

$path =  __DIR__.'/../';
require_once $path.'includes/constantes.php';
require_once $path.'classes/autoload_sysgen.php';

use PHPUnit\Framework\TestCase;

/**
 * TCreateDAO test case.
 */
class TCreateDAOTest extends TestCase
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
		$this->create = new TCreateDAO('xx/dao','test',$listColumnsProperties);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		parent::tearDown ();
		$this->create = null;
	}
	
	public function testAddExecuteSql_Empty() {
	    $esperado = array();
	    $esperado[] = ESP.ESP.'$result = $this->tpdo->executeSql($sql);'.EOL;
	    $esperado[] = ESP.ESP.'return $result;'.EOL;
				
		$this->create->addExecuteSql();		
		$retorno = $this->create->getLinesArray();		
		$this->assertSame($esperado[0], $retorno[0]);
		$this->assertSame($esperado[1], $retorno[1]);
	}
	
	public function testAddExecuteSql_true() {
	    $esperado = array();
	    $esperado[] = ESP.ESP.'$result = $this->tpdo->executeSql($sql, $values);'.EOL;
	    $esperado[] = ESP.ESP.'return $result;'.EOL;
	    
	    $this->create->addExecuteSql(true);
	    $retorno = $this->create->getLinesArray();
	    $this->assertSame($esperado[0], $retorno[0]);
	    $this->assertSame($esperado[1], $retorno[1]);
	}
	
	public function testAddSqlDelete() {
	    $esperado = array();
	    $esperado[] = ESP.'public function delete( $id )'.EOL;
	    $esperado[] = ESP.'{'.EOL;
	    $esperado[] = ESP.ESP.'$values = array($id);'.EOL;
	    $esperado[] = ESP.ESP.'$sql = \'delete from test where idTest = ?\';'.EOL;
	    $esperado[] = ESP.ESP.'$result = $this->tpdo->executeSql($sql, $values);'.EOL;
	    $esperado[] = ESP.ESP.'return $result;'.EOL;
	    $esperado[] = ESP.'}'.EOL;
	    
	    $this->create->addSqlDelete();
	    $resultArray = $this->create->getLinesArray();
	    $this->assertSame($esperado[0], $resultArray[0]);
	    $this->assertSame($esperado[1], $resultArray[1]);
	    $this->assertSame($esperado[2], $resultArray[2]);
	    $this->assertSame($esperado[3], $resultArray[3]);
	    $this->assertSame($esperado[4], $resultArray[4]);
	    $this->assertSame($esperado[5], $resultArray[5]);
	    $this->assertSame($esperado[6], $resultArray[6]);
	}
	
	public function testShow_numLines(){
	    $expectedQtd = 106;
	    
	    $resultArray = $this->create->show('array');
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testShow(){
	    $expected = array();
	    $expected[11] = 'class TestDAO '.EOL;
	    $expected[12] = '{'.EOL;
	    
	    $resultArray = $this->create->show('array');
	    $this->assertSame($expected[11], $resultArray[11]);
	    $this->assertSame($expected[12], $resultArray[12]);
	}
}