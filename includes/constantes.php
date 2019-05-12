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

define('SYSTEM_NAME', 'Gerador de Sistemas em FormDin');
define('SYSTEM_NAME_SUB', 'write less, do more. But "Talk is Cheap. Show me the Code"! ');
define('SYSTEM_ACRONYM', 'sysGen');
define('SYSTEM_VERSION', '1.6.0-alpha');
define('APLICATIVO', SYSTEM_ACRONYM);
define('ROOT_PATH', '../');
define('CHAR_MAX_TEXT_FIELD', 101);

define('FORMDIN_VERSION_MIN_VERSION', '4.5.2');


if(!defined('DS')) { 
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('EOL')) {
    define('EOL', "\n");
}
if (!defined('ESP')) {
    define('ESP', '    ');
}
if (!defined('TAB')) {
    define('TAB', chr(9));
}