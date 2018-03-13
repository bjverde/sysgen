<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */

$menu = new TMenuDhtmlx();
$menu->add('1', null, 'Menu', null, null, 'menu-alt-512.png');
$menu->add('10',1,'Gerador','star_gen.php',null,'setting-gear-512.png');


$menu->getXml();
?>
