<?php
/**
 * SysGen - System Generator with Formdin Framework
 * https://github.com/bjverde/sysgen
 */
class TGeneratorHelper {
	
	public static function phpVersionValid($html){
		$texto = '<b>Versão do PHP</b>: ';
		if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
			$texto =  $texto.'<span class="success">'.phpversion().'</span><br>';
			$html->add($texto);
			$result = true;
		}else if(version_compare(PHP_VERSION, '5.4.0') >= 0){
			$texto =  $texto.'<span class="failure">'.phpversion().' </span><br>';
			$texto =  $texto.'<span class="alert">Para um melhor desempenho atualize seu servidor para PHP 7.0.0 ou seperior </span><br>';
			$html->add($texto);
			$result = true;
		}else{
			$texto =  $texto.'<span class="failure">'.phpversion().' atualize seu sistema para o PHP 5.4.0 ou seperior </span><br>';
			$texto =  $texto.'<br><br><span class="alert">O FormDin precisa de uma versão mais atual do PHP</span><br>';
			$html->add($texto);
			$result = false;
		}
		return $result;
	}
	
	public static function testar($extensao=null,$html){
		if( extension_loaded($extensao) )	{
			$html->add('<b>'.$extensao.'</b>: <span class="success">Instalada.</span><br>');
			$result = true;
		}else {
			$html->add('<b>'.$extensao.'</b>: <span class="failure">Não instalada</span><br>');
			$result = false;
		}
		return $result;
	}
	
	public static function validatePDO($DBMS,$html){		
		$result = false;
		if( self::testar('PDO',$html) )	{
			$result = true;
		}
		
		if($result == false){
			$texto ='<span class="alert">Instale a extensão PDO. DEPOIS tente novamente</span><br>';
			$texto = $texto.'(PHP Data Objects) é uma extensão que fornece uma interface padronizada para trabalhar com diversos bancos<br>';
			$html->add($texto);
		}
		return $result;
	}
	
	public static function validateDBMS($DBMS,$html){
		// https://secure.php.net/manual/pt_BR/pdo.drivers.php
		$result = false;
		if( $DBMS == DBMS_MYSQL )	{
			if ( self::testar('PDO_MYSQL',$html)) {
				$result = true;
			}
		}else if( $DBMS == DBMS_SQLITE){
			if ( self::testar('PDO_SQLITE',$html)) {
				$result = true;
			}
		}else if( $DBMS == DBMS_SQLSERVER){
			if ( self::testar('PDO_SQLSRV',$html)) {
				$result = true;
			}
		}else if( $DBMS == DBMS_ACCESS){
			if ( self::testar('PDO_ODBC',$html)) {
				$result = true;
			}
		}else if( $DBMS == DBMS_FIREBIRD){
			if ( self::testar('PDO_FIREBIRD',$html)) {
				$result = true;
			}
		}else if( $DBMS == DBMS_ORACLE){
			if ( self::testar('PDO_OCI',$html)) {
				$result = true;
			}
		}else if( $DBMS == DBMS_POSTGRES){
			if ( self::testar('PDO_PGSQL',$html)) {
				$result = true;
			}
		}
		
		if($result == false){
			$texto ='<br><span class="alert">Instale a extensão PDO para banco de dados: '.$DBMS.'.<br> DEPOIS tente novamente</span><br>';
			$html->add($texto);
		}
		
		return $result;
	}
	
	public static function validatePDOAndDBMS($DBMS,$html){
		if( self::validatePDO($DBMS, $html) && self::validateDBMS($DBMS, $html) )	{
			$result = true;
		}else{
			$result = false;
		}		
		return $result;
	}
	
	public static function showAbaDBMS($DBMS,$DBMSAba){
		if( $DBMS == $DBMSAba )	{
			$result = true;
		}else{
			$result = false;
		}
		return $result;
	}
	
	public static function showMsg($type,$msg){
		if( $type == 1 )	{
			$msg = '<span class="success">'.$msg.'</span><br>';
		}else if ($type == 0){
			$msg = '<span class="failure">'.$msg.'</span><br>';
		}else if($type == -1 ){
			$msg = '<span class="alert">'.$msg.'</span><br>';
		}else {
			$msg = $msg.'<br>';
		}
		return $msg;
	}	
	
	public static function validateFolderName($nome) {
		$is_string = is_string($nome);
		$strlen    = strlen($nome) > 50;
		$preg      = preg_match('/^(([a-z]|[0-9]|_)+|)$/', $nome,$matches);
		if(!$is_string || $strlen || !$preg){
			throw new DomainException(Message::SYSTEM_ACRONYM_INVALID);
		}
	}
	
	public static function mkDir($path){
		if(!is_dir($path)) {
			mkdir($path, 0744, true);
		}
	}
	public static function getPathNewSystem(){
		return ROOT_PATH.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
	}
	
	public static function copySystemSkeletonToNewSystem(){
		$pathNewSystem = self::getPathNewSystem();
		$pathSkeleton  = 'system_skeleton';
		
		$list = new RecursiveDirectoryIterator($pathSkeleton);
		$it   = new RecursiveIteratorIterator($list);
		
		foreach ($it as $file) {
			if($it->isFile()){
				//echo ' SubPathName: ' . $it->getSubPathName();
				//echo ' SubPath:     ' . $it->getSubPath()."<br>";
				self::mkDir($pathNewSystem.DS.$it->getSubPath());
				copy($pathSkeleton.DS.$it->getSubPathName(),$pathNewSystem.DS.$it->getSubPathName());
			}
		}
	}
	
	public static function createFileConstants(){
		$file = new TCreateConstants();
		$file->saveFile();
	}
	
	public static function createFileConfigDataBase(){
		$file = new TCreateConfigDataBase();
		$file->saveFile();
	}
	
	public static function createFileAutoload(){
		$file = new TCreateAutoload();
		$file->saveFile();
	}
	
	public static function createFileMenu($listTable){
		$file = new TCreateMenu($listTable);
		$file->saveFile();
	}
	
	public static function createFileIndex(){
		$file = new TCreateIndex();
		$file->saveFile();
	}
	
	public static function getTDAOConect($tableName,$schema){
		$dbType   = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
		$user     = $_SESSION[APLICATIVO]['DBMS']['USER'];
		$password = $_SESSION[APLICATIVO]['DBMS']['PASSWORD'];
		$dataBase = $_SESSION[APLICATIVO]['DBMS']['DATABASE'];
		$host     = $_SESSION[APLICATIVO]['DBMS']['HOST'];
		$port     = $_SESSION[APLICATIVO]['DBMS']['PORT'];
		$schema   = is_null($schema)?$_SESSION[APLICATIVO]['DBMS']['SCHEMA']:$schema;
		
		$dao = new TDAO($tableName,$dbType,$user,$password,$dataBase,$host,$port,$schema);
		return $dao;
	}
	
	public static function loadTablesFromDatabase(){
		$dao = self::getTDAOConect(null,null);
		$dados = $dao->loadTablesFromDatabase();
		if(!is_array($dados)){
			throw new InvalidArgumentException('List of Tables Names not is array');
		}
		return $dados;
	}
	
	private static function getConfigByDBMS($DBMS){
		switch( $DBMS ) {
			case DBMS_MYSQL:
				$SCHEMA = false;
				$TPGRID = GRID_SQL_PAGINATION;
			break;
			case DBMS_SQLSERVER:
				$SCHEMA = true;
				$TPGRID = GRID_SQL_PAGINATION;
			break;
			default:
				$SCHEMA = false;
				$TPGRID = GRID_SCREEN_PAGINATION;
		}
		$config['SCHEMA'] = $SCHEMA;
		$config['TPGRID'] = $TPGRID;
		return $config;
	}
	
	public static function createFilesClasses($tableName, $listColumnsProperties){
		$DBMS       = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
		$configDBMS = self::getConfigByDBMS( $DBMS );
		$generator  = new TCreateClass( $tableName );
		$generator->setListColumnsProperties( $listColumnsProperties );
		$generator->setListColunnsName( $listColumnsProperties['COLUMN_NAME'] );
		$generator->setWithSqlPagination( $configDBMS['TPGRID'] );
		$generator->saveFile();
	}
	
	public static function createFilesDaoVoFromTable($tableName, $listColumnsProperties){
		$DBMS        = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
		$configDBMS  = self::getConfigByDBMS($DBMS);
		$folder      = self::getPathNewSystem().DS.'dao'.DS;
		$listColumns = $listColumnsProperties['COLUMN_NAME'];
		$columnPrimaryKey = $listColumns[0];
		$generatorDao     = new TCreateDAO($tableName, $columnPrimaryKey, $folder);
		foreach($listColumns as $k=>$v) {
			$generatorDao->addColumn($v);
		}
		$generatorDao->setDatabaseManagementSystem($DBMS);
		$generatorDao->setWithSqlPagination($configDBMS['TPGRID']);
		$generatorDao->setShowSchema($configDBMS['SCHEMA']);
		$generatorDao->setListColumnsProperties($listColumnsProperties);
		$generatorDao->saveVO();
		$generatorDao->saveDAO();
	}
	
	public static function createFilesForms($tableName, $listColumnsProperties){
		$DBMS       = $_SESSION[APLICATIVO]['DBMS']['TYPE'];
		$configDBMS = self::getConfigByDBMS($DBMS);
		$folder     = self::getPathNewSystem().DS.'modulos'.DS;
		$columnPrimaryKey = $listColumnsProperties['COLUMN_NAME'][0];
		$geradorForm      = new TCreateForm();
		$geradorForm->setFormTitle( $tableName );
		$geradorForm->setFormPath( $folder );
		$geradorForm->setFormFileName( $tableName );
		$geradorForm->setPrimaryKeyTable( $columnPrimaryKey );
		$geradorForm->setTableRef( $tableName );
		$geradorForm->setListColunnsName( $listColumnsProperties['COLUMN_NAME'] );
		$geradorForm->setListColumnsProperties($listColumnsProperties);
		$geradorForm->setGridType( $configDBMS['TPGRID'] );
		$geradorForm->saveForm();
	}
	
	public static function getUrlNewSystem(){
		$url = ServerHelper::getCurrentUrl(true);
		$dir = explode(DS, __DIR__);
		$dirSysGen = array_pop($dir);
		$dirSysGen = array_pop($dir);
		$url    = explode($dirSysGen, $url);
		$result = $url[0].$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
		return $result;
	}
	
}
?>