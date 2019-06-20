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

class TCreateForm extends TCreateFileContent
{
    private $formTitle;
    private $primaryKeyTable;
    private $tableRef;
    private $tableRefClass;
    private $tableRefDAO;
    private $tableRefVO;
    private $listColumnsName;
    private $lines;
    private $gridType;
    private $listColumnsProperties;
    private $tableType = null;
    
    const FORMDIN_TYPE_DATE = 'DATE';
    const FORMDIN_TYPE_TEXT = 'TEXT';
    const FORMDIN_TYPE_NUMBER = 'NUMBER';
    const FORMDIN_TYPE_COLUMN_NAME = 'FORMDIN_TYPE';    
    
    const FORM_FKTYPE_SELECT = 'SELECT';
    const FORM_FKTYPE_AUTOCOMPLETE = 'AUTOCOMPLETE';
    const FORM_FKTYPE_ONSEARCH = 'ONSEARCH';
    const FORM_FKTYPE_AUTOSEARCH = 'AUTOSEARCH';
    const FORM_FKTYPE_SELECTCRUD = 'SELECTCRUD';

    /**
     * Create file FROM form a table info
     * @param string $pathFolder   - folder path to create file
     * @param string $tableName    - table name
     * @param array $listColumnsProperties
     */
    public function __construct($pathFolder ,$tableName ,$listColumnsProperties)
    {
        $tableName = strtolower($tableName);
        $this->setFormTitle($tableName);
        $this->setTableRef($tableName);
        $this->setFileName(strtolower($tableName).'.php');
        $this->setFilePath($pathFolder);
        $this->setListColumnsProperties($listColumnsProperties);
        $this->configArrayColumns();
        
    }
    //--------------------------------------------------------------------------------------
    public function setFormTitle($formTitle)
    {
        $formTitle = ( !empty($formTitle) ) ? $formTitle : "titulo";
        $this->formTitle    = $formTitle;
    }
    //--------------------------------------------------------------------------------------
    public function getFormTitle()
    {
        return $this->formTitle;
    }
    //--------------------------------------------------------------------------------------
    public function getFormFileName()
    {
        return $this->getFileName();
    }
    //--------------------------------------------------------------------------------------
    public function setPrimaryKeyTable($primaryKeyTable)
    {
        $primaryKeyTable = ( !empty($primaryKeyTable) ) ?$primaryKeyTable : "id";
        $this->primaryKeyTable    = strtoupper($primaryKeyTable);
    }
    //--------------------------------------------------------------------------------------
    public function getPrimaryKeyTable()
    {
        return $this->primaryKeyTable;
    }
    //--------------------------------------------------------------------------------------
    public function getTableRefCC($tableRef)
    {
        $tableRef = strtolower($tableRef);
        return ucfirst($tableRef);
    }
    //--------------------------------------------------------------------------------------
    public function setTableRef($tableRef)
    {
        $this->tableRef      = strtolower($tableRef);
        $this->tableRefClass = $this->getTableRefCC($tableRef);
        $this->tableRefDAO   = $this->getTableRefCC($tableRef).'DAO';
        $this->tableRefVO    = $this->getTableRefCC($tableRef).'VO';
    }
    //--------------------------------------------------------------------------------------
    public function setListColunnsName($listColumnsName)
    {
        array_shift($listColumnsName);
        $this->listColumnsName = array_map('strtoupper', $listColumnsName);
    }
    //--------------------------------------------------------------------------------------
    public function validateListColumnsName()
    {
        return isset($this->listColumnsName) && !empty($this->listColumnsName);
    }
    //--------------------------------------------------------------------------------------
    public function setGridType($gridType)
    {
        $gridType = ( !empty($gridType) ) ?$gridType : GRID_SIMPLE;
        $this->gridType = $gridType;
    }
    public function getGridType()
    {
        return $this->gridType;
    }
    //--------------------------------------------------------------------------------------
    public function setListColumnsProperties($listColumnsProperties)
    {
        TGeneratorHelper::validateListColumnsProperties($listColumnsProperties);
        $this->listColumnsProperties = $listColumnsProperties;
    }
    public function getListColumnsProperties()
    {
        return $this->listColumnsProperties;
    }
    //--------------------------------------------------------------------------------------
    protected function configArrayColumns()
    {
        $listColumnsProperties = $this->getListColumnsProperties();
        $listColumns = $listColumnsProperties['COLUMN_NAME'];
        $columnPrimaryKey = $listColumns[0];
        $this->setListColunnsName($listColumns);
        $this->setPrimaryKeyTable($columnPrimaryKey);
    }
    //------------------------------------------------------------------------------------
    public function setTableType($tableType)
    {
        $this->tableType = $tableType;
    }
    public function getTableType()
    {
        return $this->tableType;
    }
    //--------------------------------------------------------------------------------------
    /***
     * Create variable with string sql basica
     **/
    public static function convertDataType2FormDinType($dataType)
    {
        $dataType = strtoupper($dataType);
        $result = 'TEXT';
        switch ($dataType) {
            case 'DATETIME':
            case 'DATETIME2':
            case 'DATE':
            case 'TIMESTAMP':
                //case preg_match( '/date|datetime|timestamp/i', $DATA_TYPE ):
                $result = self::FORMDIN_TYPE_DATE;
            break;
            case 'BIGINT':
            case 'DECIMAL':
            case 'DOUBLE':
            case 'FLOAT':
            case 'INT':
            case 'INT64':
            case 'INTEGER':
            case 'NUMERIC':
            case 'NUMBER':
            case 'REAL':
            case 'SMALLINT':
            case 'TINYINT':
                //case preg_match( '/decimal|real|float|numeric|number|int|int64|integer|double|smallint|bigint|tinyint/i', $DATA_TYPE ):
                $result = self::FORMDIN_TYPE_NUMBER;
            break;
            default:
                $result = self::FORMDIN_TYPE_TEXT;
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    private function getColumnsPropertieRequired($key)
    {
        $result = true;
        if (ArrayHelper::has('REQUIRED', $this->listColumnsProperties)) {
            $result = $this->listColumnsProperties['REQUIRED'][$key];
        }
        return strtolower($result);
    }
    //--------------------------------------------------------------------------------------
    private function getColumnsPropertieDataType($key)
    {
        $result = null;
        if (ArrayHelper::has('DATA_TYPE', $this->listColumnsProperties)) {
            //$result = strtolower($this->listColumnsProperties['DATA_TYPE'][$key]);
            $result = strtoupper($this->listColumnsProperties['DATA_TYPE'][$key]);
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    private function getColumnsPropertieFormDinType($key)
    {
        $result = null;
        if (ArrayHelper::has(self::FORMDIN_TYPE_COLUMN_NAME, $this->listColumnsProperties)) {
            $result = strtoupper($this->listColumnsProperties[self::FORMDIN_TYPE_COLUMN_NAME][$key]);
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    private function addFieldTypeToolTip($key, $fieldName)
    {
        $COLUMN_COMMENT = null;
        if (ArrayHelper::has('COLUMN_COMMENT', $this->listColumnsProperties)) {
            $COLUMN_COMMENT = $this->listColumnsProperties['COLUMN_COMMENT'][$key];
            if (!empty($COLUMN_COMMENT)) {
                $COLUMN_COMMENT = str_replace("'","",$COLUMN_COMMENT);
                $this->addLine('$frm->getLabel(\''.$fieldName.'\')->setToolTip(\''.$COLUMN_COMMENT.'\');');
            }
        }
    }
    //--------------------------------------------------------------------------------------
    private function getColumnsPropertieCharMax($key)
    {
        $result = null;
        if (ArrayHelper::has('CHAR_MAX', $this->listColumnsProperties)) {
            $result = $this->listColumnsProperties['CHAR_MAX'][$key];
        }
        $result = empty($result) ? 50 : $result;
        return $result;
    }
    //--------------------------------------------------------------------------------------
    private function getColumnsPropertieNumLength($key)
    {
        $result = null;
        if (ArrayHelper::has('NUM_LENGTH', $this->listColumnsProperties)) {
            $result = $this->listColumnsProperties['NUM_LENGTH'][$key];
        }
        $result = empty($result) ? 4 : $result;
        return $result;
    }
    //--------------------------------------------------------------------------------------
    private function getColumnsPropertieNumScale($key)
    {
        $result = null;
        if (ArrayHelper::has('NUM_SCALE', $this->listColumnsProperties)) {
            $result = $this->listColumnsProperties['NUM_SCALE'][$key];
        }
        $result = empty($result) ? 0 : $result;
        return $result;
    }
    //--------------------------------------------------------------------------------------
    private function getColumnsPropertieKeyType($key)
    {
        $result = null;
        if (ArrayHelper::has('KEY_TYPE', $this->listColumnsProperties)) {
            $result = $this->listColumnsProperties['KEY_TYPE'][$key];
        }
        $result = empty($result) ? false : $result;
        return $result;
    }
    //--------------------------------------------------------------------------------------
    private function getColumnsPropertieReferencedTable($key)
    {
        $result = null;
        if (ArrayHelper::has('REFERENCED_TABLE_NAME', $this->listColumnsProperties)) {
            $result = $this->listColumnsProperties['REFERENCED_TABLE_NAME'][$key];
        }
        $result = empty($result) ? false : $result;
        return $result;
    }
    //--------------------------------------------------------------------------------------
    private function getFkTypeScreenReferenced($key)
    {        
        $result = null;
        if (ArrayHelper::has(TableInfo::FK_TYPE_SCREEN_REFERENCED, $this->listColumnsProperties)) {
            $result = $this->listColumnsProperties[TableInfo::FK_TYPE_SCREEN_REFERENCED][$key];
        }
        $result = empty($result) ? false : $result;
        return $result;
    }
    //--------------------------------------------------------------------------------------
    private function addFieldNumber($key, $fieldName, $REQUIRED)
    {
        $NUM_LENGTH = self::getColumnsPropertieNumLength($key);
        $NUM_SCALE  = self::getColumnsPropertieNumScale($key);
        
        $this->addLine('$frm->addNumberField(\''.$fieldName.'\', \''.$fieldName.'\','.$NUM_LENGTH.','.$REQUIRED.','.$NUM_SCALE.');');
        $this->addFieldTypeToolTip($key, $fieldName);
    }
    //--------------------------------------------------------------------------------------
    private function addFieldForenAutoComplete($key, $fieldName, $REQUIRED)
    {
        $NUM_LENGTH = self::getColumnsPropertieNumLength($key);
        $REFERENCED_TABLE_NAME = self::getColumnsPropertieReferencedTable($key);
        $mixUpDatefields = $fieldName.'|'.$fieldName.','.$fieldName.'TEXT|'.$fieldName.'TEXT';
            
        $this->addLine('$frm->addGroupField(\'gpx1'.$fieldName.'\',\''.$fieldName.'\');');
        $this->addLine(ESP.'$frm->addNumberField(\''.$fieldName.'\',\''.$fieldName.'\','.$NUM_LENGTH.',true,0);');
        $this->addBlankLine();
        $this->addLine(ESP.'//ALTERE O CAMPO '.$fieldName.'TEXT para o nome correto da tabela ou view');
        $this->addLine(ESP.'$frm->addTextField(\''.$fieldName.'TEXT\',\''.$fieldName.'TEXT\',150,true,70,null,false);');
        $this->addLine(ESP.'//setAutoComplete SEMPRE deve ficar depois da definição dos campos de pesquisa e que serão carregados'); 
        $this->addLine(ESP.'$frm->setAutoComplete(\''.$fieldName.'TEXT\'  // 1: nome do campo na tela que será feita a pesquisa');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.',\''.$REFERENCED_TABLE_NAME.'\' // Tabela ou View que é a fonte da pesquisa');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.',\''.$fieldName.'TEXT\'	 		// campo de pesquisa');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.',\''.$mixUpDatefields.'\' // 4: campos que serão atualizados ao selecionar o texto <campo_tabela> | <campo_formulario>');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.',true'); 
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.',null 		        // 6: campo do formulário que será adicionado como filtro');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.',null				// 7: função javascript de callback');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.',3					// 8: Default 3, numero de caracteres minimos para disparar a pesquisa');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.',500				// 9: Default 1000, tempo após a digitação para disparar a consulta');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.',50					//10: máximo de registros que deverá ser retornado');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.', null, null, null, null');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.', true, null, null, true');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.');');
        $this->addLine('$frm->closeGroup();');
    }
    //--------------------------------------------------------------------------------------
    private function addFieldForenKeySelectField($key, $fieldName, $REQUIRED)
    {
        $REFERENCED_TABLE_NAME = self::getColumnsPropertieReferencedTable($key);
        $REFERENCED_TABLE_NAME = $this->getTableRefCC($REFERENCED_TABLE_NAME);
        
        $this->addLine('$controller'.$REFERENCED_TABLE_NAME.' = new '.$REFERENCED_TABLE_NAME.'();');
        $this->addLine('$list'.$REFERENCED_TABLE_NAME.' = $controller'.$REFERENCED_TABLE_NAME.'->selectAll();');
        $this->addLine('$frm->addSelectField(\''.$fieldName.'\', \''.$fieldName.'\','.$REQUIRED.',$list'.$REFERENCED_TABLE_NAME.',null,null,null,null,null,null,\' \',null);');
        $this->addFieldTypeToolTip($key, $fieldName);
    }
    //--------------------------------------------------------------------------------------
    private function addFieldNumberOrForenKey($key, $fieldName, $REQUIRED)
    {
        $KEY_TYPE   = self::getColumnsPropertieKeyType($key);
        if ($KEY_TYPE != TableInfo::KEY_TYPE_FK) {
            $this->addFieldNumber($key, $fieldName, $REQUIRED);
        } else {            
            $fkTypeScreenReferenced = self::getFkTypeScreenReferenced($key);
            switch ($fkTypeScreenReferenced) {
                case self::FORM_FKTYPE_AUTOCOMPLETE:
                    $this->addFieldForenAutoComplete($key, $fieldName, $REQUIRED);
                break;
                default:
                    $this->addFieldForenKeySelectField($key, $fieldName, $REQUIRED);
            }
        }
    }
    //--------------------------------------------------------------------------------------
    private function addFieldType($key, $fieldName)
    {
        /**
         * Esse ajuste do $key acontece em função do setListColunnsName descarta o primeiro
         * registro que assume ser a chave primaria.
         */
        $key = $key+1;
        $CHAR_MAX    = self::getColumnsPropertieCharMax($key);
        $REQUIRED    = self::getColumnsPropertieRequired($key);
        //$DATA_TYPE   = self::getColumnsPropertieDataType($key);
        $formDinType = self::getColumnsPropertieFormDinType($key);

        switch ($formDinType) {
            case self::FORMDIN_TYPE_DATE:
                $this->addLine('$frm->addDateField(\''.$fieldName.'\', \''.$fieldName.'\','.$REQUIRED.');');
                $this->addFieldTypeToolTip($key, $fieldName);
                break;
            case self::FORMDIN_TYPE_NUMBER:
                $this->addFieldNumberOrForenKey($key, $fieldName, $REQUIRED);
                break;
            default:
                if ($CHAR_MAX < CHAR_MAX_TEXT_FIELD) {
                    $this->addLine('$frm->addTextField(\''.$fieldName.'\', \''.$fieldName.'\','.$CHAR_MAX.','.$REQUIRED.','.$CHAR_MAX.');');
                } else {
                    $this->addLine('$frm->addMemoField(\''.$fieldName.'\', \''.$fieldName.'\','.$CHAR_MAX.','.$REQUIRED.',80,3);');
                }
                $this->addFieldTypeToolTip($key, $fieldName);
        }
    }
    
    //--------------------------------------------------------------------------------------
    private function addFields()
    {
        $this->addLine('$frm->addHiddenField( $primaryKey );   // coluna chave da tabela');
        if ($this->validateListColumnsName()) {
            foreach ($this->listColumnsName as $key => $value) {
                $this->addFieldType($key, $value);
            }
        }
    }
    //--------------------------------------------------------------------------------------
    private function addBasicViewController_logCatch($qtdTab)
    {
        $logType = ArrayHelper::getDefaultValeu($_SESSION[APLICATIVO], 'logType', 2);
        if ($logType == 2) {
            $this->addLine($qtdTab.'catch (DomainException $e) {');
            $this->addLine($qtdTab.ESP.'$frm->setMessage( $e->getMessage() );');
            $this->addLine($qtdTab.'}');
        }
        $this->addLine($qtdTab.'catch (Exception $e) {');
        if (($logType == 1) || ($logType == 2)) {
            $this->addLine($qtdTab.ESP.'MessageHelper::logRecord($e);');
        }
        $this->addLine($qtdTab.ESP.'$frm->setMessage( $e->getMessage() );');
        $this->addLine($qtdTab.'}');
    }
    //--------------------------------------------------------------------------------------
    private function addBasicaViewController_salvar()
    {
        $this->addLine(ESP.'case \'Salvar\':');
        $this->addLine(ESP.ESP.'try{');
        $this->addLine(ESP.ESP.ESP.'if ( $frm->validate() ) {');
        $this->addLine(ESP.ESP.ESP.ESP.'$vo = new '.$this->tableRefVO.'();');
        $this->addLine(ESP.ESP.ESP.ESP.'$frm->setVo( $vo );');
        $this->addLine(ESP.ESP.ESP.ESP.'$controller = new '.$this->tableRefClass.'();');
        $this->addLine(ESP.ESP.ESP.ESP.'$resultado = $controller->save( $vo );');
        $this->addLine(ESP.ESP.ESP.ESP.'if($resultado==1) {');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.'$frm->setMessage(\'Registro gravado com sucesso!!!\');');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.'$frm->clearFields();');
        $this->addLine(ESP.ESP.ESP.ESP.'}else{');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.'$frm->setMessage($resultado);');
        $this->addLine(ESP.ESP.ESP.ESP.'}');
        $this->addLine(ESP.ESP.ESP.'}');
        $this->addLine(ESP.ESP.'}');
        $this->addBasicViewController_logCatch(ESP.ESP);
        $this->addLine(ESP.'break;');
    }
    //--------------------------------------------------------------------------------------
    private function addBasicaViewController_buscar()
    {
        $this->addLine();
        $this->addLine(ESP.'case \'Buscar\':');
        $this->addGetWhereGridParametersArray(ESP.ESP);
        $this->addLine(ESP.ESP.'$whereGrid = $retorno;');
        $this->addLine(ESP.'break;');
    }
    //--------------------------------------------------------------------------------------
    private function addBasicaViewController_limpar()
    {
        $this->addLine();
        $this->addLine(ESP.'case \'Limpar\':');
        $this->addLine(ESP.ESP.'$frm->clearFields();');
        $this->addLine(ESP.'break;');
    }
    //--------------------------------------------------------------------------------------
    private function addBasicaViewController_gdExcluir()
    {
        $this->addLine();
        $this->addLine(ESP.'case \'gd_excluir\':');
        $this->addLine(ESP.ESP.'try{');
        $this->addLine(ESP.ESP.ESP.'$id = $frm->get( $primaryKey ) ;');
        $this->addLine(ESP.ESP.ESP.'$controller = new '.$this->tableRefClass.'();');
        $this->addLine(ESP.ESP.ESP.'$resultado = $controller->delete( $id );');
        $this->addLine(ESP.ESP.ESP.'if($resultado==1) {');
        $this->addLine(ESP.ESP.ESP.ESP.'$frm->setMessage(\'Registro excluido com sucesso!!!\');');
        $this->addLine(ESP.ESP.ESP.ESP.'$frm->clearFields();');
        $this->addLine(ESP.ESP.ESP.'}else{');
        $this->addLine(ESP.ESP.ESP.ESP.'$frm->setMessage($resultado);');
        $this->addLine(ESP.ESP.ESP.'}');
        $this->addLine(ESP.ESP.'}');
        $this->addBasicViewController_logCatch(ESP.ESP);
        $this->addLine(ESP.'break;');
    }
    //--------------------------------------------------------------------------------------
    private function addBasicaViewController()
    {
        $this->addBlankLine();
        $this->addLine('$acao = isset($acao) ? $acao : null;');
        $this->addLine('switch( $acao ) {');
        $this->addBasicaViewController_limpar();
        if ($this->gridType == GRID_SIMPLE) {
            $this->addBasicaViewController_buscar();
        }
        if ($this->getTableType() == TGeneratorHelper::TABLE_TYPE_TABLE) {
	        $this->addBasicaViewController_salvar();
        	$this->addBasicaViewController_gdExcluir();
        }
        $this->addLine('}');
    }
    //--------------------------------------------------------------------------------------
    public function getMixUpdateFields($qtdTab)
    {
        if ($this->validateListColumnsName()) {
            $this->addLine($qtdTab.'$mixUpdateFields = $primaryKey.\'|\'.$primaryKey');
            foreach ($this->listColumnsName as $value) {
                $this->addLine($qtdTab.ESP.ESP.ESP.ESP.'.\','.$value.'|'.$value.'\'');
            }
            $this->addLine($qtdTab.ESP.ESP.ESP.ESP.';');
        }
    }
    //--------------------------------------------------------------------------------------
    public function addColumnsGrid($qtdTab)
    {
        //$this->addLine($qtdTab.'$gride->addColumn($primaryKey,\'id\',50,\'center\');');
        $this->addLine($qtdTab.'$gride->addColumn($primaryKey,\'id\');');
        if ($this->validateListColumnsName()) {
            foreach ($this->listColumnsName as $value) {
                //$this->addLine($qtdTab.'$gride->addColumn(\''.$value.'\',\''.$value.'\',50,\'center\');');
                $this->addLine($qtdTab.'$gride->addColumn(\''.$value.'\',\''.$value.'\');');
            }
        }
    }
    //--------------------------------------------------------------------------------------
    public function addGetWhereGridParameters_fied($primeira, $campo, $qtdTabs)
    {
        if ($primeira == true) {
            $this->addLine($qtdTabs.'\''.$campo.'\'=>$frm->get(\''.$campo.'\')');
        } else {
            $this->addLine($qtdTabs.',\''.$campo.'\'=>$frm->get(\''.$campo.'\')');
        }
    }
    //--------------------------------------------------------------------------------------
    public function addGetWhereGridParametersFields($qtdTabs)
    {
        foreach ($this->listColumnsName as $value) {
            $this->addGetWhereGridParameters_fied(false, $value, $qtdTabs);
        }
    }
    //--------------------------------------------------------------------------------------
    public function addGetWhereGridParametersArray($qtdTabs)
    {
        $this->addLine($qtdTabs.'$retorno = array(');
        $this->addGetWhereGridParameters_fied(true, $this->getPrimaryKeyTable(), $qtdTabs.ESP.ESP);
        $this->addgetWhereGridParametersFields($qtdTabs.ESP.ESP);
        $this->addLine($qtdTabs.');');
    }
    //--------------------------------------------------------------------------------------
    public function addGetWhereGridParameters()
    {
        if ($this->validateListColumnsName()) {
            $this->addBlankLine();
            $this->addLine('function getWhereGridParameters(&$frm)');
            $this->addLine('{');
            $this->addLine(ESP.'$retorno = null;');
            $this->addLine(ESP.'if($frm->get(\'BUSCAR\') == 1 ){');
            $this->addGetWhereGridParametersArray(ESP.ESP);
            $this->addLine(ESP.'}');
            $this->addLine(ESP.'return $retorno;');
            $this->addLine('}');
        }
    }
    //--------------------------------------------------------------------------------------
    private function addBasicaGrid()
    {
        $this->addBlankLine();
        $this->addLine('$controller = new '.$this->tableRefClass.'();');
        $this->addLine('$dados = $controller->selectAll($primaryKey,$whereGrid);');
        $this->getMixUpdateFields(null);
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
    public function addGridPagination_jsScript_init_parameter($frist, $parameter,$qtdTab)
    {
        $result = null;
        if ($frist == true) {
            $this->addLine($qtdTab.'"'.$parameter.'":""');
        } else {
            $this->addLine($qtdTab.',"'.$parameter.'":""');
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public function addGridPagination_jsScript_init_allparameters($qtdTab)
    {
        if ($this->validateListColumnsName()) {
            $this->addLine($qtdTab.'var Parameters = {"BUSCAR":""');
            $this->addGridPagination_jsScript_init_parameter(false, $this->getPrimaryKeyTable(),$qtdTab.ESP.ESP.ESP.ESP);
            foreach ($this->listColumnsName as $value) {
                $this->addGridPagination_jsScript_init_parameter(false, $value,$qtdTab.ESP.ESP.ESP.ESP);
            }
            $this->addLine($qtdTab.ESP.ESP.ESP.ESP.'};');
        }
    }
    //--------------------------------------------------------------------------------------
    public function addGridPagination_jsScript_init()
    {
        $this->addLine('function init() {');
        $this->addGridPagination_jsScript_init_allparameters(ESP);
        $this->addLine(ESP.'fwGetGrid(\''.$this->getFormFileName().'\',\'gride\',Parameters,true);');
        $this->addLine('}');
    }
    //--------------------------------------------------------------------------------------
    public function addGridPagination_jsScript_buscar()
    {
        $this->addLine('function buscar() {');
        $this->addLine(ESP.'jQuery("#BUSCAR").val(1);');
        $this->addLine(ESP.'init();');
        $this->addLine('}');
    }
    //--------------------------------------------------------------------------------------
    public function addGridPagination_jsScript()
    {
        $this->addLine('<script>');
        $this->addGridPagination_jsScript_init();
        $this->addGridPagination_jsScript_buscar();
        $this->addLine('</script>');
    }
    //--------------------------------------------------------------------------------------
    public function addGrid()
    {
        
        if ($this->gridType == GRID_SIMPLE) {
            $this->addBasicaGrid();
            $this->addBlankLine();
            $this->addLine('$frm->show();');
            $this->addLine("?>");
        } else {
            $this->addGetWhereGridParameters();
            $this->addBlankLine();
            $this->addLine('if( isset( $_REQUEST[\'ajax\'] )  && $_REQUEST[\'ajax\'] ) {');
            $this->addLine(ESP.'$maxRows = ROWS_PER_PAGE;');
            $this->addLine(ESP.'$whereGrid = getWhereGridParameters($frm);');
            $this->addLine(ESP.'$controller = new '.$this->tableRefClass.'();');
            if ($this->gridType == GRID_SQL_PAGINATION) {
                $this->addLine(ESP.'$page = PostHelper::get(\'page\');');                
                $this->addLine(ESP.'$dados = $controller->selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);');
                $this->addLine(ESP.'$realTotalRowsSqlPaginator = $controller->selectCount( $whereGrid );');
            } elseif ($this->gridType == GRID_SCREEN_PAGINATION) {
                $this->addLine(ESP.'$dados = $controller->selectAll($primaryKey,$whereGrid);');
                $this->addLine(ESP.'$realTotalRowsSqlPaginator = $controller->selectCount( $whereGrid );');
            }
            $this->getMixUpdateFields(ESP);
            $this->addLine(ESP.'$gride = new TGrid( \'gd\'                        // id do gride');
            if ($this->gridType == GRID_SQL_PAGINATION) {
                $this->addLine(ESP.'				   ,\'Gride with SQL Pagination. Qtd: \'.$realTotalRowsSqlPaginator // titulo do gride');
            }else{
                $this->addLine(ESP.'				   ,\'Gride with Screen Pagination. Qtd: \'.$realTotalRowsSqlPaginator // titulo do gride');
            }
            $this->addLine(ESP.'				   );');
            $this->addLine(ESP.'$gride->addKeyField( $primaryKey ); // chave primaria');
            $this->addLine(ESP.'$gride->setData( $dados ); // array de dados');
            if ($this->gridType == GRID_SQL_PAGINATION) {
                $this->addLine(ESP.'$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );');
            }
            $this->addLine(ESP.'$gride->setMaxRows( $maxRows );');
            $this->addLine(ESP.'$gride->setUpdateFields($mixUpdateFields);');
            $this->addLine(ESP.'$gride->setUrl( \''.$this->getFormFileName().'\' );');
            $this->addBlankLine();
            $this->addColumnsGrid(ESP);
            $this->addBlankLine();
            if ($this->getTableType() == TGeneratorHelper::TABLE_TYPE_VIEW) {
                $this->addLine(ESP.'$gride->enableDefaultButtons(false);');
            }
            $this->addBlankLine();
            $this->addLine(ESP.'$gride->show();');
            $this->addLine(ESP.'die();');
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
    public function addButtons()
    {
        if ($this->gridType == GRID_SIMPLE) {
            $this->addLine('$frm->addButton(\'Buscar\', null, \'Buscar\', null, null, true, false);');
        } else {
            $this->addLine('$frm->addButton(\'Buscar\', null, \'btnBuscar\', \'buscar()\', null, true, false);');
        }
        if ($this->getTableType() == TGeneratorHelper::TABLE_TYPE_TABLE) {
            $this->addLine('$frm->addButton(\'Salvar\', null, \'Salvar\', null, null, false, false);');
        }
        $this->addLine('$frm->addButton(\'Limpar\', null, \'Limpar\', null, null, false, false);');
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('defined(\'APLICATIVO\') or die();');
        $this->addBlankLine();
        if ($this->gridType == GRID_SIMPLE) {
            $this->addLine('$whereGrid = \' 1=1 \';');
        }
        $this->addLine('$primaryKey = \''.$this->getPrimaryKeyTable().'\';');
        $this->addLine('$frm = new TForm(\''.$this->formTitle.'\',800,950);');
        $this->addLine('$frm->setShowCloseButton(false);');
        $this->addLine('$frm->setFlat(true);');
        $this->addLine('$frm->setMaximize(true);');
        //$this->addLine('$frm->setAutoSize(true);');  // https://github.com/bjverde/formDin/issues/48 problema com o Chrome
        $this->addLine('$frm->setHelpOnLine(\'Ajuda\',600,980,\'ajuda/ajuda_tela.php\',null);');
        $this->addBlankLine();
        $this->addBlankLine();
        if ($this->gridType != GRID_SIMPLE) {
            $this->addLine('$frm->addHiddenField( \'BUSCAR\' ); //Campo oculto para buscas');
        }
        $this->addFields();
        $this->addBlankLine();
        $this->addButtons();
        $this->addBlankLine();
        $this->addBasicaViewController();
        $this->addBlankLine();
        $this->addGrid();
        return $this->showContent($print);
    }
}
