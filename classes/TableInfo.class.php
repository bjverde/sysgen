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
    const TP_SYSTEM = 'TP_SYSTEM';
    
    const KEY_TYPE = 'KEY_TYPE';
    const KEY_TYPE_PK = 'PK';
    const KEY_TYPE_FK = 'FOREIGN KEY';
    const COLUMN_NAME = 'COLUMN_NAME';
    const DATA_TYPE   = 'DATA_TYPE';
    
    const ID_COLUMN_FK_SRSELECTED   = 'ID_COLUMN_FK_SRSELECTED';
    const FK_FIELDS_TABLE_SELECTED  = 'FkFieldsTableSelected';
    const FK_TYPE_SCREEN_REFERENCED = 'FK_TYPE_SCREEN_REFERENCED';

    const DBMS_VERSION_SQLSERVER_2012_GTE = 'SQL Server 2012 (11.0) ou superior';
    const DBMS_VERSION_SQLSERVER_2012_LT  = 'SQL Server anteior 2012';
    
}
