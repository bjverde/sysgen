<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */
class FolderHelper {
	
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
	
	public static function copySystemSkeletonToNewSystem(){
		$pathNewSystem = ROOT_PATH.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'];
		$pathSkeleton = 'system_skeleton';
	
		$list = new RecursiveDirectoryIterator($pathSkeleton);
		$it = new RecursiveIteratorIterator($list);
		
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
	
	public static function createFileMenu($listTable){
		$listTableNames = $listTable['TABLE_NAME'];
		$file = new TCreateMenu($listTableNames);
		$file->saveFile();
	}
}
?>