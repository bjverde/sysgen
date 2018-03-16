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
	
	public static function mkDirRoot($GEN_SYSTEM_ACRONYM){
		$path = ROOT_PATH.DS.$GEN_SYSTEM_ACRONYM;
		
		if(!is_dir($path)) {
			mkdir($path, 0744, true);
		}
	}
	
	
}
?>