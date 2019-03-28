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

/**
 * Information about the table or view. With constant names
 * @author bjverde
 *
 */
final class TableInfo
{
    public const KEY_TYPE = 'KEY_TYPE';
    public const KEY_TYPE_PK = 'PK';
    public const KEY_TYPE_FK = 'FOREIGN KEY';
    public const COLUMN_NAME = 'COLUMN_NAME';
    public const DATA_TYPE = 'DATA_TYPE';
    
    public const FK_FIELDS_TABLE_SELECTED = 'FkFieldsTableSelected';
    public const FK_TYPE_SCREEN_REFERENCED = 'FK_TYPE_SCREEN_REFERENCED';    
    
}
