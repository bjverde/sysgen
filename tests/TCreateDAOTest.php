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

/**
 * TCreateDAO test case.
 */
class TCreateDAOTest extends TestCase
{	

	private $create;
	
	private $mockDatabase;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->mockDatabase = new mockDatabase();
		$listColumnsProperties = $this->mockDatabase->generateFieldsOneTable();
		$this->create = new TCreateDAO('xx/dao','test',$listColumnsProperties);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		parent::tearDown ();
		$this->create = null;
	}
	
	public function testGetKeyColumnName() {
	    $expected = 'idtest';
		$result = $this->create->getKeyColumnName();		
		$this->assertSame($expected, $result);
	}

	public function testGetColumnPKeyPropertieFormDinType() {
	    $expected = TCreateForm::FORMDIN_TYPE_NUMBER;
		$result = $this->create->getColumnPKeyPropertieFormDinType();		
		$this->assertSame($expected, $result);
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
	
	public function testAddGetVoById(){
	    $expected = array();
	    $expected[] = ESP.'public function getVoById( $id )'.EOL;
	    $expected[] = ESP.'{'.EOL;
	    $expected[] = ESP.ESP.'if( empty($id) || !is_numeric($id) ){'.EOL;
	    $expected[] = ESP.ESP.ESP.'throw new InvalidArgumentException(Message::TYPE_NOT_INT.\'class:\'.__METHOD__);'.EOL;
	    $expected[] = ESP.ESP.'}'.EOL;
	    $expected[] = ESP.ESP.'$result = $this->selectById( $id );'.EOL;
	    $expected[] = ESP.ESP.'$vo = new TestVO();'.EOL;
	    $expected[] = ESP.ESP.'$vo = \FormDinHelper::setPropertyVo($result,$vo);'.EOL;
	    $expected[] = ESP.ESP.'return $vo;'.EOL;
	    $expected[] = ESP.'}'.EOL;
	    
	    $this->create->addGetVoById();
	    $result = $this->create->getLinesArray();
	    $this->assertSame($expected[0], $result[0]);
	    $this->assertSame($expected[1], $result[1]);
	    $this->assertSame($expected[2], $result[2]);
	    $this->assertSame($expected[3], $result[3]);
	    $this->assertSame($expected[4], $result[4]);
	    $this->assertSame($expected[5], $result[5]);
	    $this->assertSame($expected[6], $result[6]);
	    $this->assertSame($expected[7], $result[7]);
	    $this->assertSame($expected[8], $result[8]);
	    $this->assertSame($expected[9], $result[9]);
	}
	
	public function testAddSqlSelectAll(){
	    $expected = array();
	    $expected[] = ESP.'public function selectAll( $orderBy=null, $where=null )'.EOL;
	    $expected[] = ESP.'{'.EOL;
	    $expected[] = ESP.ESP.'$where = $this->processWhereGridParameters($where);'.EOL;
	    $expected[] = ESP.ESP.'$sql = self::$sqlBasicSelect'.EOL;
	    $expected[] = ESP.ESP.'.( ($where)? \' where \'.$where:\'\')'.EOL;
	    $expected[] = ESP.ESP.'.( ($orderBy) ? \' order by \'.$orderBy:\'\');'.EOL;
	    
	    $this->create->addSqlSelectAll();
	    $result = $this->create->getLinesArray();
	    $this->assertSame($expected[0], $result[0]);
	    $this->assertSame($expected[1], $result[1]);
	    $this->assertSame($expected[2], $result[2]);
	    $this->assertSame($expected[3], $result[3]);
	    $this->assertSame($expected[4], $result[4]);
	    $this->assertSame($expected[5], $result[5]);
	}
	
	public function testAddSqlInsert_numLines(){
	    $expectedQtd = 13;
	    
	    $this->create->addSqlInsert();
	    $resultArray = $this->create->getLinesArray();
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testAddSqlInsert(){
	    $expected = array();
	    $expected[] = ESP.'public function insert( TestVO $objVo )'.EOL;
	    $expected[] = ESP.'{'.EOL;
	    $expected[] = ESP.ESP.'$values = array(';
	    $expected[] = '  $objVo->getNm_test() '.EOL;
	    $expected[] = ESP.ESP.'                , $objVo->getTip_test() '.EOL;
	    $expected[] = ESP.ESP.'                );'.EOL;
	    $expected[] = ESP.ESP.'$sql = \'insert into test('.EOL;
	    
	    $this->create->addSqlInsert();
	    $result = $this->create->getLinesArray();
	    $this->assertSame($expected[0], $result[0]);
	    $this->assertSame($expected[1], $result[1]);
	    $this->assertSame($expected[2], $result[2]);
	    $this->assertSame($expected[3], $result[3]);
	    $this->assertSame($expected[4], $result[4]);
	    $this->assertSame($expected[5], $result[5]);
	}
	
	public function testAddSqlDelete_numLines(){
	    $expectedQtd = 10;
	    
	    $this->create->addSqlDelete();
	    $resultArray = $this->create->getLinesArray();
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testAddSqlDelete() {
	    $expected = array();
	    $expected[] = ESP.'public function delete( $id )'.EOL;
	    $expected[] = ESP.'{'.EOL;
	    $expected[] = ESP.ESP.'if( empty($id) || !is_numeric($id) ){'.EOL;
	    $expected[] = ESP.ESP.ESP.'throw new InvalidArgumentException(Message::TYPE_NOT_INT.\'class:\'.__METHOD__);'.EOL;
	    $expected[] = ESP.ESP.'}'.EOL;
	    $expected[] = ESP.ESP.'$values = array($id);'.EOL;
	    $expected[] = ESP.ESP.'$sql = \'delete from test where idtest = ?\';'.EOL;
	    $expected[] = ESP.ESP.'$result = $this->tpdo->executeSql($sql, $values);'.EOL;
	    $expected[] = ESP.ESP.'return $result;'.EOL;
	    $expected[] = ESP.'}'.EOL;
	    
	    $this->create->addSqlDelete();
	    $result = $this->create->getLinesArray();
	    $this->assertSame($expected[0], $result[0]);
	    $this->assertSame($expected[1], $result[1]);
	    $this->assertSame($expected[2], $result[2]);
	    $this->assertSame($expected[3], $result[3]);
	    $this->assertSame($expected[4], $result[4]);
	    $this->assertSame($expected[5], $result[5]);
	    $this->assertSame($expected[6], $result[6]);
	    $this->assertSame($expected[7], $result[7]);
	    $this->assertSame($expected[8], $result[8]);
	    $this->assertSame($expected[9], $result[9]);
	}

	public function testAddConstruct_numLines(){
	    $expectedQtd = 14;
		
		$this->create->addConstruct();
	    $resultArray = $this->create->getLinesArray();
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}

	public function testAddConstruct(){
	    $expected = array();
	    $expected[] = ESP.'private $tpdo = null;'.EOL;
		$expected[] = EOL;
		$expected[] = ESP.'public function __construct() {'.EOL;
		$expected[] = ESP.ESP.'$tpdo = New TPDOConnectionObj();'.EOL;
		$expected[] = ESP.ESP.'$this->setTPDOConnection($tpdo);'.EOL;
		$expected[] = ESP.'}'.EOL;
		$expected[] = ESP.'public function getTPDOConnection()'.EOL;
		
		$this->create->addConstruct();
	    $resultArray = $this->create->getLinesArray();
	    $this->assertSame($expected[0], $resultArray[0]);
	    $this->assertSame($expected[1], $resultArray[1]);
	    $this->assertSame($expected[2], $resultArray[2]);
	    $this->assertSame($expected[3], $resultArray[3]);
	    $this->assertSame($expected[4], $resultArray[4]);
	    $this->assertSame($expected[5], $resultArray[5]);
	    $this->assertSame($expected[6], $resultArray[6]);
	}
	
	public function testShow_VIEW_numLines(){
	    $expectedQtd = 90;
	    
	    $this->create->setTableType(TableInfo::TB_TYPE_VIEW);
	    $resultArray = $this->create->show('array');
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testShow_VIEW_GRID_SQL_numLines(){
	    $expectedQtd = 103;
	    
	    $this->create->setWithSqlPagination(GRID_SQL_PAGINATION);
	    $this->create->setTableType(TableInfo::TB_TYPE_VIEW);
	    $resultArray = $this->create->show('array');
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testShow_TABLE_numLines(){
	    $expectedQtd = 129;	    
	    
	    $resultArray = $this->create->show('array');
	    $size = CountHelper::count($resultArray);
	    $this->assertEquals( $expectedQtd, $size);
	}
	
	public function testShow_TABLE_GRID_SQL_numLines(){
	    $expectedQtd = 142;
	    
	    $this->create->setWithSqlPagination(GRID_SQL_PAGINATION);
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