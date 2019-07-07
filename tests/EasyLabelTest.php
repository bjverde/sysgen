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
require_once $path.'controllers/autoload_sysgen.php';

use PHPUnit\Framework\TestCase;

class EasyLabelTest extends TestCase
{	

	private $create;	
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		parent::tearDown ();
	}

	public function testConvert_dt_ok()
	{
	    $expected ='Data Inclusao';
	    $typeField = TCreateForm::FORMDIN_TYPE_DATE;
	    $stringLabel = 'DTINCLUSAO';
	    $result = EasyLabel::convert_dt($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvert_dt_NotMach()
	{
	    $expected ='xyz';
	    $typeField = TCreateForm::FORMDIN_TYPE_DATE;
	    $stringLabel = 'xyz';
	    $result = EasyLabel::convert_dt($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvert_dt_TypeWrong()
	{
	    $expected ='xyz';
	    $typeField = TCreateForm::FORMDIN_TYPE_TEXT;
	    $stringLabel = 'xyz';
	    $result = EasyLabel::convert_dt($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}

	public function testConvert_nm_ok()
	{
	    $expected ='DTINCLUSAO';
	    $typeField = TCreateForm::FORMDIN_TYPE_TEXT;
	    $stringLabel = 'DTINCLUSAO';
	    $result = EasyLabel::convert_nm($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvert_nm_NotMach()
	{
	    $expected ='Nome Pessoa';
	    $typeField = TCreateForm::FORMDIN_TYPE_TEXT;
	    $stringLabel = 'NMPESSOA';
	    $result = EasyLabel::convert_nm($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvert_nm_TypeWrong()
	{
	    $expected ='xyz';
	    $typeField = TCreateForm::FORMDIN_TYPE_DATE;
	    $stringLabel = 'xyz';
	    $result = EasyLabel::convert_nm($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_NotUse()
	{
	    $expected ='DSTIPO';
	    $typeField = TCreateForm::FORMDIN_TYPE_TEXT;
	    $stringLabel = 'DSTIPO';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'N';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_TypeDate_inclusao()
	{
	    $expected ='Data Inclusão';
	    $typeField = TCreateForm::FORMDIN_TYPE_DATE;
	    $stringLabel = 'DTINCLUSAO';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_TypeDate_altercao()
	{
	    $expected ='Data Alteração';
	    $typeField = TCreateForm::FORMDIN_TYPE_DATE;
	    $stringLabel = 'DTALTERACAO';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_TypeName_inclusao()
	{
	    $expected ='Nome Pessoa';
	    $typeField = TCreateForm::FORMDIN_TYPE_TEXT;
	    $stringLabel = 'NMPESSOA';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_TypeName_altercao()
	{
	    $expected ='Nome Tipo';
	    $typeField = TCreateForm::FORMDIN_TYPE_TEXT;
	    $stringLabel = 'NMTIPO';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_TypeText_Descricao()
	{
	    $expected ='Descrição Tipo';
	    $typeField = TCreateForm::FORMDIN_TYPE_TEXT;
	    $stringLabel = 'DSTIPO';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_EndSao()
	{
	    $expected ='Data Inclusão';
	    $typeField = TCreateForm::FORMDIN_TYPE_DATE;
	    $stringLabel = 'DTINCLUSAO';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_EndCao()
	{
	    $expected ='Data Alteração';
	    $typeField = TCreateForm::FORMDIN_TYPE_DATE;
	    $stringLabel = 'DTALTERACAO';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_idPessoa()
	{
	    $expected ='id Pessoa';
	    $typeField = TCreateForm::FORMDIN_TYPE_NUMBER;
	    $stringLabel = 'IDPESSOA';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_idAcao()
	{
	    $expected ='id Ação';
	    $typeField = TCreateForm::FORMDIN_TYPE_NUMBER;
	    $stringLabel = 'IDACAO';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_idUnidade()
	{
	    $expected ='id Unidade';
	    $typeField = TCreateForm::FORMDIN_TYPE_NUMBER;
	    $stringLabel = 'IDUNIDADE';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_st()
	{
	    $expected ='Status Ação';
	    $typeField = TCreateForm::FORMDIN_TYPE_TEXT;
	    $stringLabel = 'STACAO';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}
	
	public function testConvertLabel_nr()
	{
	    $expected ='Número Otrs';
	    $typeField = TCreateForm::FORMDIN_TYPE_NUMBER;
	    $stringLabel = 'NROTRS';
	    $_SESSION[APLICATIVO]['EASYLABEL'] = 'Y';
	    $result = EasyLabel::convertLabel($stringLabel, $typeField);
	    $this->assertEquals($expected, $result);
	}

}