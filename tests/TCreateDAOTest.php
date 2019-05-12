<?php

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
		$this->create = new TCreateDAO('xx/dao','testes',$listColumnsProperties);
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
	
	public function testAddSqlDelete_true() {
	    $esperado = array();
	    $esperado[] = ESP.'public static function delete( $id )'.EOL;
	    $esperado[] = ESP.'{'.EOL;
	    $esperado[] = ESP.ESP.'$values = array($id);'.EOL;
	    $esperado[] = ESP.ESP.'$sql = \'delete from testes where idTest = ?\';'.EOL;
	    $esperado[] = ESP.ESP.'$result = $this->tpdo->executeSql($sql, $values);'.EOL;
	    $esperado[] = ESP.ESP.'return $result;'.EOL;
	    $esperado[] = ESP.'}'.EOL;
	    
	    $this->create->addSqlDelete();
	    $retorno = $this->create->getLinesArray();
	    $this->assertSame($esperado[0], $retorno[0]);
	    $this->assertSame($esperado[1], $retorno[1]);
	    $this->assertSame($esperado[2], $retorno[2]);
	    $this->assertSame($esperado[3], $retorno[3]);
	    $this->assertSame($esperado[4], $retorno[4]);
	    $this->assertSame($esperado[5], $retorno[5]);
	    $this->assertSame($esperado[6], $retorno[6]);
	}
}