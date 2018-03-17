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
		$pathSkeleton = 'system_skeleton';
		$list = new RecursiveDirectoryIterator($pathSkeleton);
		$recursivo = new RecursiveIteratorIterator($list);
		$count =1;
		foreach ($recursivo as $obj){
			$count =$count+1;
			echo '<hr><br>';
			echo $count.'<br>';
			echo $obj->getSubPath().'<br>';
			if($obj->isFile() ){
				echo $obj->getSubPathName().'<br>';
			}
		}
		ini_set('xdebug.var_display_max_data', -1);
		//echo('<pre>');
		//d($list);
		//d($recursivo);
		//echo('</pre>');
	}
}
?>