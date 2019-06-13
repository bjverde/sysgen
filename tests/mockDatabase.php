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

class mockDatabase
{
           
    protected function includeTable($tableSelected, $tableSchema, $tableName, $tableType)
    {
        $tableSelected['TABLE_SCHEMA'][] = $tableSchema;
        $tableSelected['TABLE_NAME'][]   = $tableName;
        $tableSelected['TABLE_TYPE'][]   = $tableType;
        return $tableSelected;
    }
    
    public function generateTablesSelected3t5v()
    {
        $tableSelected = array();
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'menu' , TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'acess', TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'vitem', TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'list' , TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v2'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v3'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v4'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v5'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        return $tableSelected;
    }
    
    public function generateTablesSelected1t7v()
    {
        $tableSelected = array();
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'menu' , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'acess', TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'vitem', TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'list' , TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v2'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v3'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v4'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v5'   , TGeneratorHelper::TABLE_TYPE_VIEW);
        return $tableSelected;
    }
    
}
