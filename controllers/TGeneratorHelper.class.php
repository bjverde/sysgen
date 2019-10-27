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
class TGeneratorHelper
{    
    const TP_SYSTEM_FORM = 'TP_SYSTEM_FORM';
    const TP_SYSTEM_REST = 'TP_SYSTEM_REST';
    const TP_SYSTEM_FORM_REST = 'TP_SYSTEM_FORM_REST';
    
    public static function validadeFormDinMinimumVersion($html)
    {
        $texto = '<b>Versão do FormDin</b>: ';
        $formVersion = explode("-", FORMDIN_VERSION);
        $formVersion = $formVersion[0];
        if (version_compare($formVersion,FORMDIN_VERSION_MIN_VERSION,'>=')) {
            $texto =  $texto.'<span class="success">'.FORMDIN_VERSION.'</span>';
            $html->add($texto);            
            $result = true;
        } else {
            $texto =  $texto.'<span class="failure">'.FORMDIN_VERSION.'</span>, atualize para a versão: '.FORMDIN_VERSION_MIN_VERSION;
            $html->add($texto);
            $result = false;
        }
        return $result;
    }    
    
    public static function validadePhpMinimumVersion($html)
    {
        $texto = '<b>Versão do PHP</b>: ';
        if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
            $texto =  $texto.'<span class="success">'.phpversion().'</span><br>';
            $html->add($texto);
            $result = true;
        } elseif (version_compare(PHP_VERSION, '5.4.0') >= 0) {
            $texto =  $texto.'<span class="failure">'.phpversion().' </span><br>';
            $texto =  $texto.'<span class="alert">Para um melhor desempenho atualize seu servidor para PHP 7.0.0 ou seperior </span><br>';
            $html->add($texto);
            $result = true;
        } else {
            $texto =  $texto.'<span class="failure">'.phpversion().' atualize seu sistema para o PHP 5.4.0 ou seperior </span><br>';
            $texto =  $texto.'<br><br><span class="alert">O FormDin precisa de uma versão mais atual do PHP</span><br>';
            $html->add($texto);
            $result = false;
        }
        return $result;
    }
    
    public static function testar($extensao = null, $html)
    {
        if (extension_loaded($extensao)) {
            $html->add('<b>'.$extensao.'</b>: <span class="success">Instalada.</span><br>');
            $result = true;
        } else {
            $html->add('<b>'.$extensao.'</b>: <span class="failure">Não instalada</span><br>');
            $result = false;
        }
        return $result;
    }
    
    public static function validatePDO($DBMS, $html)
    {
        $result = false;
        if (self::testar('PDO', $html)) {
            $result = true;
        }
        
        if ($result == false) {
            $texto ='<span class="alert">Instale a extensão PDO. DEPOIS tente novamente</span><br>';
            $texto = $texto.'(PHP Data Objects) é uma extensão que fornece uma interface padronizada para trabalhar com diversos bancos<br>';
            $html->add($texto);
        }
        return $result;
    }
    
    public static function validateDBMS($DBMS, $html)
    {
        // https://secure.php.net/manual/pt_BR/pdo.drivers.php
        $result = false;
        if ($DBMS == DBMS_MYSQL) {
            if (self::testar('PDO_MYSQL', $html)) {
                $result = true;
            }
        } elseif ($DBMS == DBMS_SQLITE) {
            if (self::testar('PDO_SQLITE', $html)) {
                $result = true;
            }
        } elseif ($DBMS == DBMS_SQLSERVER) {
            if (self::testar('PDO_SQLSRV', $html)) {
                $result = true;
            }
        } elseif ($DBMS == DBMS_ACCESS) {
            if (self::testar('PDO_ODBC', $html)) {
                $result = true;
            }
        } elseif ($DBMS == DBMS_FIREBIRD) {
            if (self::testar('PDO_FIREBIRD', $html)) {
                $result = true;
            }
        } elseif ($DBMS == DBMS_ORACLE) {
            if (self::testar('PDO_OCI', $html)) {
                $result = true;
            }
        } elseif ($DBMS == DBMS_POSTGRES) {
            if (self::testar('PDO_PGSQL', $html)) {
                $result = true;
            }
        }
        
        if ($result == false) {
            $texto ='<br><span class="alert">Instale a extensão PDO para banco de dados: '.$DBMS.'.<br> DEPOIS tente novamente</span><br>';
            $html->add($texto);
        }
        
        return $result;
    }
    
    public static function validatePDOAndDBMS($DBMS, $html)
    {
        if (self::validatePDO($DBMS, $html) && self::validateDBMS($DBMS, $html)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    
    public static function showAbaDBMS($DBMS, $DBMSAba)
    {
        if ($DBMS == $DBMSAba) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    
    public static function showMsg($type, $msg)
    {
        if ($type == 1) {
            $msg = '<span class="success">'.$msg.'</span><br>';
        } elseif ($type == 0) {
            $msg = '<span class="failure">'.$msg.'</span><br>';
        } elseif ($type == -1) {
            $msg = '<span class="alert">'.$msg.'</span><br>';
        } else {
            $msg = $msg.'<br>';
        }
        return $msg;
    }
    
    public static function validateFolderName($nome)
    {
        $is_string = is_string($nome);
        $strlen    = strlen($nome) > 50;
        $preg      = preg_match('/^(([a-z]|[0-9]|_)+|)$/', $nome, $matches);
        if (!$is_string || $strlen || !$preg) {
            throw new DomainException(Message::SYSTEM_ACRONYM_INVALID);
        }
    }
    
    public static function mkDir($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0744, true);
        }
    }
    public static function getPathNewSystem()
    {
        return ROOT_PATH.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
    }
    
    public static function copySystemSkeletonToNewSystemByTpSystem($pathSkeleton)
    {
        $pathNewSystem = self::getPathNewSystem();
        
        $list = new RecursiveDirectoryIterator($pathSkeleton);
        $it   = new RecursiveIteratorIterator($list);
        
        foreach ($it as $file) {
            if ($it->isFile()) {
                //echo ' SubPathName: ' . $it->getSubPathName();
                //echo ' SubPath:     ' . $it->getSubPath()."<br>";
                self::mkDir($pathNewSystem.DS.$it->getSubPath());
                copy($pathSkeleton.DS.$it->getSubPathName(), $pathNewSystem.DS.$it->getSubPathName());
            }
        }
    }
    
    public static function copySystemSkeletonToNewSystem()
    {
        $tpSystem = $_SESSION[APLICATIVO][TableInfo::TP_SYSTEM];
        switch ($tpSystem) {
            case self::TP_SYSTEM_FORM:
                $pathSkeleton  = 'system_skeleton'.DS.'common';
                self::copySystemSkeletonToNewSystemByTpSystem($pathSkeleton);
                $pathSkeleton  = 'system_skeleton'.DS.'form';
                self::copySystemSkeletonToNewSystemByTpSystem($pathSkeleton);
            break;
            //--------------------------------------------------------------------------------
            case self::TP_SYSTEM_REST:
                $pathSkeleton  = 'system_skeleton'.DS.'common';
                self::copySystemSkeletonToNewSystemByTpSystem($pathSkeleton);
                $pathSkeleton  = 'system_skeleton'.DS.'rest';
                self::copySystemSkeletonToNewSystemByTpSystem($pathSkeleton);
            break;
            //--------------------------------------------------------------------------------
            case self::TP_SYSTEM_FORM_REST:
                $pathSkeleton  = 'system_skeleton'.DS.'common';
                self::copySystemSkeletonToNewSystemByTpSystem($pathSkeleton);
                $pathSkeleton  = 'system_skeleton'.DS.'rest';
                self::copySystemSkeletonToNewSystemByTpSystem($pathSkeleton);
                $pathSkeleton  = 'system_skeleton'.DS.'form';
                self::copySystemSkeletonToNewSystemByTpSystem($pathSkeleton);
            break;
        }
    }
    
    public static function createFileConstants()
    {
        $file = new TCreateConstants();
        $file->saveFile();
    }
    
    public static function createFileConfigDataBase()
    {
        $file = new TCreateConfigDataBase();
        $file->saveFile();
    }
    
    public static function createFileAutoload()
    {
        $file = new TCreateAutoload();
        $file->saveFile();

        $file = new CreateAutoloadDAO();
        $file->saveFile();

        if( $_SESSION[APLICATIVO][TableInfo::TP_SYSTEM] != self::TP_SYSTEM_FORM ){
            $file = new CreateAutoloadAPI();
            $file->saveFile();
        }
    }

    public static function createApiIndexAndRouter($listTable)
    {
        $file = new CreateApiIndex();
        $file->saveFile();
        
        $file = new CreateApiRoutesCall($listTable);
        $file->saveFile();
    }
    
    public static function createFileMenu($listTable)
    {
        $file = new TCreateMenu();
        $file->setListTableNames($listTable);
        $file->saveFile();
    }
    
    public static function createFileIndex()
    {
        $file = new TCreateIndex();
        $file->saveFile();
    }
    
    public static function getTDAOConect($tableName, $schema)
    {
        $dbType   = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
        $user     = $_SESSION[APLICATIVO]['DBMS']['USER'];
        $password = $_SESSION[APLICATIVO]['DBMS']['PASSWORD'];
        $dataBase = $_SESSION[APLICATIVO]['DBMS']['DATABASE'];
        $host     = $_SESSION[APLICATIVO]['DBMS']['HOST'];
        $port     = $_SESSION[APLICATIVO]['DBMS']['PORT'];
        $schema   = is_null($schema)?$_SESSION[APLICATIVO]['DBMS']['SCHEMA']:$schema;
        
        $dao = new TDAO($tableName, $dbType, $user, $password, $dataBase, $host, $port, $schema);
        return $dao;
    }
    
    public static function loadTablesFromDatabase()
    {
        $listAllTables = array();
        if(ArrayHelper::has(TableInfo::LIST_TABLES_DB, $_SESSION[APLICATIVO])){
            $listAllTables = $_SESSION[APLICATIVO][TableInfo::LIST_TABLES_DB];
        }else{
            $dao = self::getTDAOConect(null, null);
            $listAllTables = $dao->loadTablesFromDatabase();
            if (!is_array($listAllTables)) {
                throw new InvalidArgumentException(Message::ERRO_LIST_TABLE_NOT_ARRAY);
            }
            foreach ($listAllTables['TABLE_NAME'] as $key => $value) {
                $listAllTables['idSelected'][] = $listAllTables['TABLE_SCHEMA'][$key].$value.$listAllTables['COLUMN_QTD'][$key].$listAllTables['TABLE_TYPE'][$key];
            }
            $_SESSION[APLICATIVO][TableInfo::LIST_TABLES_DB] = $listAllTables;
        }
        return $listAllTables;
    }
    
    public static function getConfigGridSqlServer($DBMS)
    {
        $dbversion = $_SESSION[APLICATIVO]['DBMS']['VERSION'];
        $TPGRID = GRID_SQL_PAGINATION;
        $withVersion = TableInfo::getDbmsWithVersion($DBMS);
        if( ($dbversion == TableInfo::DBMS_VERSION_SQLSERVER_2012_LT) && $withVersion ){
            $TPGRID = GRID_SCREEN_PAGINATION;
        }
        return $TPGRID;
    }
    
    public static function getConfigGridMySql($DBMS)
    {
        $dbversion = $_SESSION[APLICATIVO]['DBMS']['VERSION'];
        $TPGRID = GRID_SQL_PAGINATION;
        $withVersion = TableInfo::getDbmsWithVersion($DBMS);
        if( ($dbversion == TableInfo::DBMS_VERSION_MYSQL_8_LT) && $withVersion ){
            $TPGRID = GRID_SCREEN_PAGINATION;
        }
        return $TPGRID;
    }
    
    private static function getConfigByDBMS($DBMS)
    {
        switch ($DBMS) {
            case DBMS_MYSQL:
                $SCHEMA = false;
                $TPGRID = self::getConfigGridMySql($DBMS);
            break;
            case DBMS_SQLSERVER:
                $SCHEMA = true;
                $TPGRID = self::getConfigGridSqlServer($DBMS);
            break;
            default:
                $SCHEMA = false;
                $TPGRID = GRID_SCREEN_PAGINATION;
        }
        $config = array();
        $config['SCHEMA'] = $SCHEMA;
        $config['TPGRID'] = $TPGRID;
        return $config;
    }
    
    public static function createFilesControllers($tableName, $listColumnsProperties, $tableSchema, $tableType)
    {
        $DBMS       = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
        $configDBMS = self::getConfigByDBMS($DBMS);
        $generator  = new CreateControllers($tableName);
        $generator->setTableType($tableType);
        $generator->setListColumnsProperties($listColumnsProperties);
        $generator->setListColunnsName($listColumnsProperties['COLUMN_NAME']);
        $generator->setWithSqlPagination($configDBMS['TPGRID']);
        $generator->saveFile();
    }
    
    public static function createFilesTests($tableName, $listColumnsProperties, $tableSchema, $tableType)
    {
        $generator  = new CreateTestsFiles($tableName, $listColumnsProperties, $tableType);
        $generator->saveFile();
    }
    
    public static function createFilesDaoVoFromTable($tableName, $listColumnsProperties, $tableSchema, $tableType)
    {
        $DBMS        = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
        $configDBMS  = self::getConfigByDBMS($DBMS);
        $folder      = self::getPathNewSystem().DS.'dao'.DS;

        $generatorVo = new TCreateVO($folder,$tableName, $listColumnsProperties,$DBMS);
        $generatorVo->saveFile();
               
        $generatorDao = new TCreateDAO($folder,$tableName, $listColumnsProperties);
        $generatorDao->setTableType($tableType);
        $generatorDao->setDatabaseManagementSystem($DBMS);
        $generatorDao->setWithSqlPagination($configDBMS['TPGRID']);
        $generatorDao->setTableSchema($tableSchema);
        $generatorDao->saveFile();
    }
    
    public static function createFilesForms($tableName, $listColumnsProperties, $tableSchema, $tableType)
    {
        $DBMS       = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
        $configDBMS = self::getConfigByDBMS($DBMS);
        $pathFolder = self::getPathNewSystem().DS.'modulos'.DS;
        $geradorForm= new TCreateForm($pathFolder ,$tableName ,$listColumnsProperties);
        $geradorForm->setTableType($tableType);
        $geradorForm->setGridType($configDBMS['TPGRID']);
        $geradorForm->saveFile();
    }

    public static function createFilesControllesAndRoutesAPI($tableName, $listColumnsProperties, $tableSchema, $tableType)
    {
        $pathFolder= self::getPathNewSystem().DS.'api'.DS.'api_controllers';
        $generator = new CreateApiControllesFiles($pathFolder,$tableName, $listColumnsProperties, $tableType);
        $generator->saveFile();

        //$pathFolder= self::getPathNewSystem().DS.'api'.DS.'routes';
        //$generator = new CreateApiRoutesFiles($pathFolder,$tableName, $listColumnsProperties, $tableType);
        //$generator->saveFile();
    }
    
    public static function createFilesFormClassDaoVoFromTable($tableName, $listColumnsProperties, $tableSchema, $tableType)
    {
        self::createFilesDaoVoFromTable($tableName, $listColumnsProperties,$tableSchema,$tableType);
        self::createFilesControllers($tableName, $listColumnsProperties, $tableSchema, $tableType);
        self::createFilesTests($tableName, $listColumnsProperties, $tableSchema, $tableType);

        if( $_SESSION[APLICATIVO][TableInfo::TP_SYSTEM] != TGeneratorHelper::TP_SYSTEM_REST ){
            self::createFilesForms($tableName, $listColumnsProperties, $tableSchema, $tableType);
        }

        if( $_SESSION[APLICATIVO][TableInfo::TP_SYSTEM] != TGeneratorHelper::TP_SYSTEM_FORM ){
            self::createFilesControllesAndRoutesAPI($tableName, $listColumnsProperties, $tableSchema, $tableType);
        }
    }
    
    public static function getUrlNewSystem()
    {
        $url = ServerHelper::getCurrentUrl(true);
        $dir = explode(DS, __DIR__);
        $dirSysGen = array_pop($dir);
        $dirSysGen = array_pop($dir);
        $url    = explode($dirSysGen, $url);
        $result = $url[0].$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
        return $result;
    }
    
    public static function loadTablesSelected()
    {
        $listTablesAll   = TGeneratorHelper::loadTablesFromDatabase();
        $idTableSelected = $_SESSION[APLICATIVO]['idTableSelected'];
        $listTablesSelected = array();
        foreach ($idTableSelected as $id) {
            $keyTable = array_search($id, $listTablesAll['idSelected']);
            $listTablesSelected['TABLE_SCHEMA'][] = $listTablesAll['TABLE_SCHEMA'][$keyTable];
            $listTablesSelected['TABLE_NAME'][]   = $listTablesAll['TABLE_NAME'][$keyTable];
            $listTablesSelected['TABLE_TYPE'][]   = $listTablesAll['TABLE_TYPE'][$keyTable];
        }
        return $listTablesSelected;
    }
    
    public static function removeFieldsDuplicateOnSelectedTables($listFieldsTable)
    {
        ArrayHelper::validateIsArray($listFieldsTable, __METHOD__, __LINE__);
        $listColumnName = $listFieldsTable['COLUMN_NAME'];
        foreach ($listColumnName as $name) {
            $listKey = ArrayHelper::array_keys2($listColumnName,$name);
            $sizeKeyQtd = CountHelper::count($listKey);
            if($sizeKeyQtd>1){
                echo 'mais de um registro';
            }
            
        }
        return $listFieldsTable;
    }

    public static function loadFieldsTablesSelected()
    {
        $_SESSION[APLICATIVO]['FieldsTableSelected'] = null;
        $FieldsTableSelected = null;
        $listTables = TGeneratorHelper::loadTablesSelected();
        foreach ($listTables['TABLE_NAME'] as $key => $table) {
            $tableSchema = $listTables['TABLE_SCHEMA'][$key];
            $tableType   = $listTables['TABLE_TYPE'][$key];
            $dao = TGeneratorHelper::getTDAOConect($table, $tableSchema);
            if($tableType == TableInfo::TB_TYPE_PROCEDURE){
                $listFieldsTable = $dao->loadFieldsOneStoredProcedureFromDatabase();
            }else{
                $listFieldsTable = $dao->loadFieldsOneTableFromDatabase();
            }
            $_SESSION[APLICATIVO]['FieldsTableSelected'][] = $listFieldsTable;
        }
        $FieldsTableSelected = $_SESSION[APLICATIVO]['FieldsTableSelected'];
        return $FieldsTableSelected;
    }
    
    public static function loadFieldsTablesSelectedWithFormDin($table, $tableType, $tableSchema)
    {
        $dao = self::getTDAOConect($table, $tableSchema);
        if($tableType == TableInfo::TB_TYPE_PROCEDURE){
            $listFieldsTable = $dao->loadFieldsOneStoredProcedureFromDatabase();
        }else{
            $listFieldsTable = $dao->loadFieldsOneTableFromDatabase();
        }        
        foreach ($listFieldsTable['DATA_TYPE'] as $key => $dataType) {
            $formDinType = TCreateForm::convertDataType2FormDinType($dataType);
            $listFieldsTable[TCreateForm::FORMDIN_TYPE_COLUMN_NAME][$key] = $formDinType;
            
            if( $_SESSION[APLICATIVO][TableInfo::TP_SYSTEM] != self::TP_SYSTEM_REST ){
                $fkTypeScreenReferenced = self::getFKTypeScreenReferencedSelected($table, $tableSchema, $listFieldsTable, $key);
                $listFieldsTable[TableInfo::FK_TYPE_SCREEN_REFERENCED][$key] = $fkTypeScreenReferenced;
            }
        }
        return $listFieldsTable;
    }
    
    public static function getFKTypeScreenReferencedSelected($table, $tableSchema, $listFieldsTable, $key)
    {
        $fkTypeScreenReferenced = null;                
        if(ArrayHelper::has(TableInfo::KEY_TYPE,$listFieldsTable) && $listFieldsTable[TableInfo::KEY_TYPE][$key] == TableInfo::KEY_TYPE_FK){
            $columnNameTarget = $listFieldsTable[TableInfo::COLUMN_NAME][$key];
            $idColumnTarger = $tableSchema.$table.$columnNameTarget;
            $listIdColumns = $_SESSION[APLICATIVO][TableInfo::FK_FIELDS_TABLE_SELECTED][TableInfo::ID_COLUMN_FK_SRSELECTED];
            $keyFkTypeScreenReferencedSelected = array_search($idColumnTarger, $listIdColumns);
            $fkTypeScreenReferenced = $_SESSION[APLICATIVO][TableInfo::FK_FIELDS_TABLE_SELECTED][TableInfo::FK_TYPE_SCREEN_REFERENCED][$keyFkTypeScreenReferencedSelected];
        }
        return $fkTypeScreenReferenced;
    }
    
    public static function getListFKTypeScreenReferenced()
    {
        $array = array();
        $array[TCreateForm::FORM_FKTYPE_SELECT] = 'Select Field';
        $array[TCreateForm::FORM_FKTYPE_AUTOCOMPLETE] = 'Autocomplet';
        //$array[] = 'Search On-line';
        //$array[] = 'Select Field + Crud';
        return $array;
    }

    public static function getListTypeSystem()
    {
        $array = array();
        $array[self::TP_SYSTEM_FORM] = 'Somente tela FormDin';
        $array[self::TP_SYSTEM_REST] = 'Somente API REST';
        $array[self::TP_SYSTEM_FORM_REST] = 'FormDin + REST';
        return $array;
    }

    public static function listFKFieldsTablesSelected()
    {
        $FkFieldsTableSelected = null;
        $FieldsTableSelected   = self::loadFieldsTablesSelected();
        $ID_LINE = 1;
        foreach ($FieldsTableSelected as $key => $table) {
            $KEY_TYPE = ArrayHelper::get($FieldsTableSelected[$key], 'KEY_TYPE');
            $KEY_FK = ArrayHelper::array_keys2($KEY_TYPE, 'FOREIGN KEY');
            foreach ($KEY_FK as $keyFieldFkTable) {
                $refTable  = $FieldsTableSelected[$key]['REFERENCED_TABLE_NAME'][$keyFieldFkTable];
                $refColumn = $FieldsTableSelected[$key]['REFERENCED_COLUMN_NAME'][$keyFieldFkTable];
                
                $FkFieldsTableSelected['ID_LINE'][]= $ID_LINE;
                $ID_LINE = $ID_LINE + 1;
                $FkFieldsTableSelected['TABLE_SCHEMA'][]= $FieldsTableSelected[$key]['TABLE_SCHEMA'][$keyFieldFkTable];
                $FkFieldsTableSelected['TABLE_NAME'][]  = $FieldsTableSelected[$key]['TABLE_NAME'][$keyFieldFkTable];
                $FkFieldsTableSelected[TableInfo::COLUMN_NAME][] = $FieldsTableSelected[$key][TableInfo::COLUMN_NAME][$keyFieldFkTable];
                $FkFieldsTableSelected['DATA_TYPE'][]   = $FieldsTableSelected[$key]['DATA_TYPE'][$keyFieldFkTable];
                $FkFieldsTableSelected['REFERENCED_TABLE_NAME'][]  = $refTable;
                $FkFieldsTableSelected['REFERENCED_COLUMN_NAME'][] = $refColumn;
                //$FkFieldsTableSelected['FK_TYPE_SCREEN_REFERENCED'][] = self::getFKTypeScreenReferenced($refTable,$refColumn);
                $FkFieldsTableSelected[TableInfo::ID_COLUMN_FK_SRSELECTED][] = $FieldsTableSelected[$key]['TABLE_SCHEMA'][$keyFieldFkTable]
                                                                              .$FieldsTableSelected[$key]['TABLE_NAME'][$keyFieldFkTable]
                                                                              .$FieldsTableSelected[$key][TableInfo::COLUMN_NAME][$keyFieldFkTable];
                $FkFieldsTableSelected[TableInfo::FK_TYPE_SCREEN_REFERENCED][] = null;
            }
        }
        $_SESSION[APLICATIVO][TableInfo::FK_FIELDS_TABLE_SELECTED] = $FkFieldsTableSelected;
        return $FkFieldsTableSelected;
    }    
    //--------------------------------------------------------------------------------------
    public static function validateListTableNames($listTableNames)
    {   
        if (empty($listTableNames)) {
            throw new InvalidArgumentException(Message::ERRO_LIST_TABLE_EMPTY);
        }
        if (!is_array($listTableNames)) {
            throw new InvalidArgumentException(Message::ERRO_LIST_TABLE_NOT_ARRAY);
        }
    }
    //--------------------------------------------------------------------------------------
    public static function validateListColumnsProperties($listColumnsProperties)
    {   
        if (empty($listColumnsProperties)) {
            throw new InvalidArgumentException(Message::ERRO_LIST_COLUMNS_EMPTY);
        }
        if (!is_array($listColumnsProperties)) {
            throw new InvalidArgumentException(Message::ERRO_LIST_COLUMNS_NOT_ARRAY);
        }
    }
}
