<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 *
 * @author  Bjverde <bjverde@yahoo.com.br>
 * @license https://github.com/bjverde/sysgen/blob/master/LICENSE GPL-3.0
 * @link    https://github.com/bjverde/sysgen
 *
 * PHP Version 5.6
 */

$menu = new TMenuDhtmlx();
//$menu->add('1', null, 'Menu', null, null, 'menu-alt-512.png');
$menu->add('10', null, 'Gerador', 'gen00.php', null, 'settings_tool_preferences-512');


$menu->getXml();
