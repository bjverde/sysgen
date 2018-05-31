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
if (!function_exists('sysgen_autoload') ) {
    function sysgen_autoload( $class_name )
    {
    	require_once $class_name . '.class.php';
    }
    spl_autoload_register('sysgen_autoload');
}
