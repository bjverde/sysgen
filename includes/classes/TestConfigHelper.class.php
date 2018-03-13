<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */
class TestConfigHelper {
	
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
			$html->add($texto);
			$result = false;
		}
		return $result;
	}
}
?>