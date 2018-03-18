<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
 * Criado por Luís Eugênio Barbosa
 * Essa versão é um Fork https://github.com/bjverde/formDin
 *
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 *
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo é parte do Framework Formdin.
 *
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 *
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

if(!defined('EOL')){ define('EOL',"\n"); }
if(!defined('TAB')){ define('TAB',chr(9)); }
if(!defined('DS')){ define('DS',DIRECTORY_SEPARATOR); }
class TFormCreate {
	private $formTitle;
	private $formPath;
	private $formFileName;
	private $primaryKeyTable;
	private $tableRef;
    private $daoTableRef;
	private $voTableRef;
	private $listColumnsName;
    private $lines;
    private $gridType;

	public function __construct(){
	    $this->setFormTitle(null);
	    $this->setFormPath(null);
	    $this->setFormFileName(null);
	    $this->setPrimaryKeyTable(null);
	    $this->setGridType(null);
	}
	//--------------------------------------------------------------------------------------
	public function setFormTitle($formTitle) {
		$formTitle = ( !empty($formTitle) ) ? $formTitle : "titulo";
		$this->formTitle    = $formTitle;
	}
	//--------------------------------------------------------------------------------------
	public function getFormTitle() {
	    return $this->formTitle;
	}
	//--------------------------------------------------------------------------------------
	public function setFormPath($formPath) {
		$formPath = ( !empty($formPath) ) ?$formPath : "/modulos";
		$this->formPath    = $formPath;
	}
	//--------------------------------------------------------------------------------------
	public function getFormPath() {
	    return $this->formPath;
	}
	//--------------------------------------------------------------------------------------
	public function setFormFileName($formFileName) {
		$formFileName = ( !empty($formFileName) ) ?$formFileName : "form-".date('Ymd-Gis');
		$this->formFileName    = $formFileName.'.php';
	}
	//--------------------------------------------------------------------------------------
	public function getFormFileName() {
	    return $this->formFileName;
	}
	//--------------------------------------------------------------------------------------
	public function setPrimaryKeyTable($primaryKeyTable) {
		$primaryKeyTable = ( !empty($primaryKeyTable) ) ?$primaryKeyTable : "id";
		$this->primaryKeyTable    = strtoupper($primaryKeyTable);
	}
	//--------------------------------------------------------------------------------------
	public function getPrimaryKeyTable() {
		return $this->primaryKeyTable;
	}
	//--------------------------------------------------------------------------------------
	public function setTableRef($tableRef) {
		$this->daoTableRef= ucfirst($tableRef).'DAO';
		$this->voTableRef = ucfirst($tableRef).'VO';
	}
	//--------------------------------------------------------------------------------------
	public function setListColunnsName($listColumnsName) {
		array_shift($listColumnsName);
		$this->listColumnsName = array_map('strtoupper', $listColumnsName);
	}
	//--------------------------------------------------------------------------------------
	public function validateListColumnsName() {
	 return isset($this->listColumnsName) && !empty($this->listColumnsName);
	}
	//--------------------------------------------------------------------------------------
	public function setGridType($gridType) {
		$gridType = ( !empty($gridType) ) ?$gridType : GRID_SIMPLE;
	    $this->gridType = $gridType;
	}
	//--------------------------------------------------------------------------------------
	public function getGridType() {
		return $this->gridType;
	}
	//------------------------------------------------------------------------------------
	public function getLinesArray(){
		return $this->lines;
	}
	//------------------------------------------------------------------------------------
	public function getLinesString(){
		$string = implode($this->lines);
		return trim($string);
	}
	//--------------------------------------------------------------------------------------	
	private function addLine($strNewValue=null,$boolNewLine=true){
		$strNewValue = is_null( $strNewValue ) ? TAB.'//' . str_repeat( '-', 80 ) : $strNewValue;
		$this->lines[] = $strNewValue.( $boolNewLine ? EOL : '');
	}
	//--------------------------------------------------------------------------------------	
	private function addBlankLine(){
		$this->addLine('');
	}	
	//--------------------------------------------------------------------------------------
	private function addBasicaFields() {
		$this->addLine('$frm->addHiddenField( $primaryKey );   // coluna chave da tabela');
		if( $this->validateListColumnsName() ){
			foreach($this->listColumnsName as $key=>$value){
				$this->addLine('$frm->addTextField(\''.$value.'\', \''.$value.'\',50,true);');
			}
		}		
	}
	//--------------------------------------------------------------------------------------
	private function addBasicaViewController_salvar() {
	    $this->addLine(TAB.'case \'Salvar\':');
	    $this->addLine(TAB.TAB.'if ( $frm->validate() ) {');
	    $this->addLine(TAB.TAB.TAB.'$vo = new '.$this->voTableRef.'();');
	    $this->addLine(TAB.TAB.TAB.'$frm->setVo( $vo );');
	    $this->addLine(TAB.TAB.TAB.'$resultado = '.$this->daoTableRef.'::insert( $vo );');
	    $this->addLine(TAB.TAB.TAB.'if($resultado==1) {');
	    $this->addLine(TAB.TAB.TAB.TAB.'$frm->setMessage(\'Registro gravado com sucesso!!!\');');
	    $this->addLine(TAB.TAB.TAB.TAB.'$frm->clearFields();');
	    $this->addLine(TAB.TAB.TAB.'}else{');
	    $this->addLine(TAB.TAB.TAB.TAB.'$frm->setMessage($resultado);');
	    $this->addLine(TAB.TAB.TAB.'}');
	    $this->addLine(TAB.TAB.'}');
	    $this->addLine(TAB.'break;');
	}
	//--------------------------------------------------------------------------------------
	private function addBasicaViewController_buscar() {
		$this->addLine();
		$this->addLine(TAB.'case \'Buscar\':');
		$this->addGetWhereGridParametersArray( TAB.TAB );
		$this->addLine(TAB.TAB.'$whereGrid = $retorno;');
		$this->addLine(TAB.'break;');
	}
	//--------------------------------------------------------------------------------------
	private function addBasicaViewController_limpar() {
	    $this->addLine();
	    $this->addLine(TAB.'case \'Limpar\':');
	    $this->addLine(TAB.TAB.'$frm->clearFields();');
	    $this->addLine(TAB.'break;');
	}
	//--------------------------------------------------------------------------------------
	private function addBasicaViewController_gdExcluir() {
	    $this->addLine();
	    $this->addLine(TAB.'case \'gd_excluir\':');
	    $this->addLine(TAB.TAB.'$id = $frm->get( $primaryKey ) ;');
	    $this->addLine(TAB.TAB.'$resultado = '.$this->daoTableRef.'::delete( $id );;');
	    $this->addLine(TAB.TAB.'if($resultado==1) {');
	    $this->addLine(TAB.TAB.TAB.'$frm->setMessage(\'Registro excluido com sucesso!!!\');');
	    $this->addLine(TAB.TAB.TAB.'$frm->clearFields();');
	    $this->addLine(TAB.TAB.'}else{');
	    $this->addLine(TAB.TAB.TAB.'$frm->clearFields();');
	    $this->addLine(TAB.TAB.TAB.'$frm->setMessage($resultado);');
	    $this->addLine(TAB.TAB.'}');
	    $this->addLine(TAB.'break;');
	}
	//--------------------------------------------------------------------------------------
	private function addBasicaViewController() {
		$this->addBlankLine();
		$this->addLine('$acao = isset($acao) ? $acao : null;');
		$this->addLine('switch( $acao ) {');
		$this->addBasicaViewController_salvar();
		if($this->gridType == GRID_SIMPLE){
			$this->addBasicaViewController_buscar();
		}
		$this->addBasicaViewController_limpar();
		$this->addBasicaViewController_gdExcluir();
		$this->addLine('}');
	}
	//--------------------------------------------------------------------------------------
	public function getMixUpdateFields() {
		if( $this->validateListColumnsName() ){
			$mixUpdateFields = '$primaryKey.\'|\'.$primaryKey.\'';
			foreach($this->listColumnsName as $key=>$value){
				$mixUpdateFields = $mixUpdateFields.','.$value.'|'.$value;
			}
			$mixUpdateFields = $mixUpdateFields.'\';';
			$mixUpdateFields = '$mixUpdateFields = '.$mixUpdateFields;
		}
		return $mixUpdateFields;
	}
	//--------------------------------------------------------------------------------------
	public function addColumnsGrid($qtdTab) {
		$this->addLine($qtdTab.'$gride->addColumn($primaryKey,\'id\',50,\'center\');');
		if( $this->validateListColumnsName() ){
			foreach($this->listColumnsName as $key=>$value){
				$this->addLine($qtdTab.'$gride->addColumn(\''.$value.'\',\''.$value.'\',50,\'center\');');
			}
		}
	}
	//--------------------------------------------------------------------------------------
	public function addGetWhereGridParameters_fied($primeira, $campo, $qtdTabs) {
		if( $primeira == TRUE ){
			$this->addLine($qtdTabs.'\''.$campo.'\'=>$frm->get(\''.$campo.'\')');
		} else {
			$this->addLine($qtdTabs.',\''.$campo.'\'=>$frm->get(\''.$campo.'\')');
		}
	}
	//--------------------------------------------------------------------------------------
	public function addGetWhereGridParametersFields( $qtdTabs ) {
		foreach($this->listColumnsName as $key=>$value){
			$this->addGetWhereGridParameters_fied(false, $value, $qtdTabs);
		}
	}
	//--------------------------------------------------------------------------------------
	public function addGetWhereGridParametersArray( $qtdTabs ) {
		$this->addLine($qtdTabs.'$retorno = array(');
		$this->addGetWhereGridParameters_fied(true, $this->getPrimaryKeyTable(), $qtdTabs.TAB.TAB);
		$this->addgetWhereGridParametersFields($qtdTabs.TAB.TAB);
		$this->addLine($qtdTabs.');');
	}
	//--------------------------------------------------------------------------------------
	public function addGetWhereGridParameters() {
		if( $this->validateListColumnsName() ){
			$this->addBlankLine();
			$this->addLine('function getWhereGridParameters(&$frm){');
			$this->addLine(TAB.'$retorno = null;');
			$this->addLine(TAB.'if($frm->get(\'BUSCAR\') == 1 ){');
			$this->addGetWhereGridParametersArray( TAB.TAB );
			$this->addLine(TAB.'}');
			$this->addLine(TAB.'return $retorno;');
			$this->addLine('}');
		}
	}
	//--------------------------------------------------------------------------------------
	private function addBasicaGrid() {
		$this->addBlankLine();
		$this->addLine('$dados = '.$this->daoTableRef.'::selectAll($primaryKey,$whereGrid);');
		$this->addLine($this->getMixUpdateFields());
		$this->addLine('$gride = new TGrid( \'gd\'        // id do gride');
		$this->addLine('				   ,\'Gride\'     // titulo do gride');
		$this->addLine('				   ,$dados 	      // array de dados');
		$this->addLine('				   ,null		  // altura do gride');
		$this->addLine('				   ,null		  // largura do gride');
		$this->addLine('				   ,$primaryKey   // chave primaria');
		$this->addLine('				   ,$mixUpdateFields');
		$this->addLine('				   );');
		$this->addColumnsGrid(null);
		$this->addLine('$frm->addHtmlField(\'gride\',$gride);');
	}
	//--------------------------------------------------------------------------------------
	public function addGridPagination_jsScript_init_parameter($frist, $parameter) {
		$result = null;
		if( $frist == TRUE ){
			$result = '"'.$parameter.'":""';
		} else {
			$result = ',"'.$parameter.'":""';
		}
		return $result;
	}	
	//--------------------------------------------------------------------------------------
	public function addGridPagination_jsScript_init_allparameters($qtdTab) {
		if( $this->validateListColumnsName() ){
			$line = null;
			$line = $line.$this->addGridPagination_jsScript_init_parameter(true,'BUSCAR');
			$line = $line.$this->addGridPagination_jsScript_init_parameter(false,$this->getPrimaryKeyTable());
			foreach($this->listColumnsName as $key=>$value){
				$line = $line.$this->addGridPagination_jsScript_init_parameter(false,$value);
			}
			$line = $qtdTab.'var Parameters = {'.$line.'};';
			$this->addLine($line);
		}
	}
	//--------------------------------------------------------------------------------------
	public function addGridPagination_jsScript_init() {
	    $this->addLine('function init() {');
	    $this->addGridPagination_jsScript_init_allparameters(TAB);
	    $this->addLine(TAB.'fwGetGrid(\''.$this->formFileName.'\',\'gride\',Parameters,true);');
	    $this->addLine('}');
	}
	//--------------------------------------------------------------------------------------
	public function addGridPagination_jsScript_buscar() {
	    $this->addLine('function buscar() {');
	    $this->addLine(TAB.'jQuery("#BUSCAR").val(1);');
	    $this->addLine(TAB.'init();');
	    $this->addLine('}');
	}
	//--------------------------------------------------------------------------------------
	public function addGridPagination_jsScript() {
	    $this->addLine('<script>');
	    $this->addGridPagination_jsScript_init();
	    $this->addGridPagination_jsScript_buscar();
	    $this->addLine('</script>');
	}
	//--------------------------------------------------------------------------------------
	public function addGrid() {
	    
	    if($this->gridType == GRID_SIMPLE){
	        $this->addBasicaGrid();
	        $this->addBlankLine();
	        $this->addLine('$frm->show();');
	        $this->addLine("?>");
	    }else{
	    	$this->addGetWhereGridParameters();
	    	$this->addBlankLine();
	    	$this->addLine('if( isset( $_REQUEST[\'ajax\'] )  && $_REQUEST[\'ajax\'] ) {');
	    	$this->addLine(TAB.'$maxRows = ROWS_PER_PAGE;');
	    	$this->addLine(TAB.'$whereGrid = getWhereGridParameters($frm);');
	    	if($this->gridType == GRID_SQL_PAGINATION){	    	    
	    		$this->addLine(TAB.'$page = PostHelper::get(\'page\');');
	    		$this->addLine(TAB.'$dados = '.$this->daoTableRef.'::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);');
	    		$this->addLine(TAB.'$realTotalRowsSqlPaginator = '.$this->daoTableRef.'::selectCount( $whereGrid );');
	    	}else if($this->gridType == GRID_SCREEN_PAGINATION){
	    		$this->addLine(TAB.'$dados = '.$this->daoTableRef.'::selectAll( $primaryKey, $whereGrid );');
	    	}
	    	$this->addLine(TAB.$this->getMixUpdateFields());
	    	$this->addLine(TAB.'$gride = new TGrid( \'gd\'                        // id do gride');
	    	$this->addLine(TAB.'				   ,\'Gride with SQL Pagination\' // titulo do gride');
	    	$this->addLine(TAB.'				   );');
	    	$this->addLine(TAB.'$gride->addKeyField( $primaryKey ); // chave primaria');
	    	$this->addLine(TAB.'$gride->setData( $dados ); // array de dados');
	    	if($this->gridType == GRID_SQL_PAGINATION){
	    		$this->addLine(TAB.'$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );');
	    	}
	    	$this->addLine(TAB.'$gride->setMaxRows( $maxRows );');
	    	$this->addLine(TAB.'$gride->setUpdateFields($mixUpdateFields);');
	    	$this->addLine(TAB.'$gride->setUrl( \''.$this->getFormFileName().'\' );');
	    	$this->addBlankLine();
	    	$this->addColumnsGrid(TAB);
	    	$this->addBlankLine();
	    	$this->addLine(TAB.'$gride->show();');
	    	$this->addLine(TAB.'die();');
	    	$this->addLine('}');
	    	$this->addBlankLine();
	    	$this->addLine('$frm->addHtmlField(\'gride\');');
	    	$this->addLine('$frm->addJavascript(\'init()\');');
	    	$this->addLine('$frm->show();');
	    	$this->addBlankLine();
	    	$this->addLine("?>");
	    	$this->addGridPagination_jsScript();
	    }
	}
	//--------------------------------------------------------------------------------------
	public function addButtons() {
		if($this->gridType == GRID_SIMPLE){
			$this->addLine('$frm->addButton(\'Buscar\', null, \'Buscar\', null, null, true, false);');
		}else{
			$this->addLine('$frm->addButton(\'Buscar\', null, \'btnBuscar\', \'buscar()\', null, true, false);');
		}
		$this->addLine('$frm->addButton(\'Salvar\', null, \'Salvar\', null, null, false, false);');
		$this->addLine('$frm->addButton(\'Limpar\', null, \'Limpar\', null, null, false, false);');
	}
	//--------------------------------------------------------------------------------------
	public function showForm($print=false) {
		$this->lines=null;
        $this->addLine('<?php');
        $this->addLine('defined(\'APLICATIVO\') or die();');
        $this->addBlankLine();
        if($this->gridType == GRID_SIMPLE){
        	$this->addLine('$whereGrid = \' 1=1 \';');
        }
        $this->addLine('$primaryKey = \''.$this->getPrimaryKeyTable().'\';');
        $this->addLine('$frm = new TForm(\''.$this->formTitle.'\',600);');
		$this->addLine('$frm->setFlat(true);');
		$this->addLine('$frm->setMaximize(true);');
		$this->addBlankLine();
		$this->addBlankLine();
		if($this->gridType != GRID_SIMPLE){
		    $this->addLine('$frm->addHiddenField( \'BUSCAR\' ); //Campo oculto para buscas');
		}
		$this->addBasicaFields();
		$this->addBlankLine();
		$this->addButtons();
		$this->addBlankLine();
		$this->addBasicaViewController();
		$this->addBlankLine();
		$this->addGrid();
        
        if( $print){
        	echo $this->getLinesString();
		}else{
			return $this->getLinesString();
		}
	}    
	//---------------------------------------------------------------------------------------
	/**
	 * @codeCoverageIgnore
	 */
	public function saveForm(){
		$fileName = $this->formPath.DS.$this->formFileName;
		if($fileName){
			if( file_exists($fileName)){
				unlink($fileName);
            }
            $payload = $this->showForm(false);
			file_put_contents($fileName,$payload);
		}
	}
}
?>