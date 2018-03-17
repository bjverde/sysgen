<?php
/**
 * SysGen - System Generator with Formdin Framework
 * https://github.com/bjverde/sysgen
 */
if ( !function_exists( 'sysgen_autoload') ) {
	function sysgen_autoload( $class_name )	{
		require_once $class_name . '.class.php';
	}
	spl_autoload_register('sysgen_autoload');
}