<?php
/**
 * SysGen - Gerador de sistemas com Formdin Framework
 * https://github.com/bjverde/sysgen
 */

$menu = new TMenuDhtmlx();
$menu->add('1', null, 'Menu', null, null, 'menu-alt-512.png');
//$menu->add('11', '1', 'Pessoa', 'view/pessoa.php', null, 'user916.gif');
//$menu->add('12', '1', 'Tipos de Tipos', 'view/tipo_tipos.php', null);

$menu->getXml();
?>
