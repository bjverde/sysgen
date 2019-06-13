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
    /**
     * Add a new row in the table that represents the list of database objects 
     * (table, view, Storage Procedure, or Function) of a database and its
     * information. Refers to FormDin TDAO-> loadTablesFromDatabase
     * 
     * 
     * Adicionar um nova linha na tabela que representa a lista de objetos do 
     * banco de dados (tabela, view,  Storage Procedure ou Function) de um banco
     * de dados e suas informações. Faz referencia a FormDin TDAO->loadTablesFromDatabase
     * 
     * @param string $tableSelected  - 1: Old Lines
     * @param string $tableSchema    - 2: Name of Schema of Database
     * @param string $tableName      - 3: Name of Database Objetic Table, View, Storage Procedure ou Function
     * @param string $column_qtd     - 4: Qtd of columns in Database Objetic
     * @param string $tableType      - 5: Type of Database Objetic : TABLE OR VIEW OR PROCEDURE ou FUNCTION
     * @return array
     */       
    protected function includeTable($tableSelected, $tableSchema, $tableName, $column_qtd, $tableType)
    {
        $tableSelected['TABLE_SCHEMA'][] = $tableSchema;
        $tableSelected['TABLE_NAME'][]   = $tableName;
        $tableSelected['COLUMN_QTD'][]   = $column_qtd;
        $tableSelected['TABLE_TYPE'][]   = $tableType;
        return $tableSelected;
    }
    
    public function generateTablesSelected3t5v()
    {
        $tableSelected = array();
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'menu' ,null, TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'acess',null, TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'vitem',null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'list' ,null, TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v2'   ,null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v3'   ,null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v4'   ,null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v5'   ,null, TGeneratorHelper::TABLE_TYPE_VIEW);
        return $tableSelected;
    }
    
    public function generateTablesSelected1t7v()
    {
        $tableSelected = array();
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'menu' ,null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'acess',null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'vitem',null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'list' ,null, TGeneratorHelper::TABLE_TYPE_TABLE);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v2'   ,null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v3'   ,null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v4'   ,null, TGeneratorHelper::TABLE_TYPE_VIEW);
        $tableSelected = $this->includeTable($tableSelected, 'dbo', 'v5'   ,null, TGeneratorHelper::TABLE_TYPE_VIEW);
        return $tableSelected;
    }
    
    /***
     * Add a new row in the table that represents the list of fields and their 
     * properties for a database object (table, view, Storage Procedure, or 
     * Function). Refers to FormDin TDAO-> loadFieldsOneTableFromDatabase
     * 
     * Adicionar um nova linha na tabela que representa a lista de campos e suas
     * propriedades de um objeto de banco de dados (tabela, view,  Storage
     * Procedure ou Function). Faz referencia a FormDin TDAO->loadFieldsOneTableFromDatabase
     * 
     * @param string $tableFields    - 1: Old Lines
     * @param string $column_name    - 2: Name of fields
     * @param string $requred        - 3: TRUE or FALSE
     * @param string $data_type      - 4: 
     * @return unknown
     */
    protected function includeFieldsFromTable($tableFields, $column_name, $requred, $data_type)
    {
        $tableField['COLUMN_NAME'][] = $column_name;
        $tableField['REQUIRED'][]    = $requred;
        $tableField['DATA_TYPE'][]   = $data_type;
        return $tableField;
    }
    
    public function generateFieldsOneTable()
    {
        $tableField = array();
        $tableField = $this->includeFieldsFromTable($tableField, 'idTest'  , 'TRUE' ,'INT');
        $tableField = $this->includeFieldsFromTable($tableField, 'nm_test' , 'TRUE' ,'VARCHAR');
        $tableField = $this->includeFieldsFromTable($tableField, 'tip_test', 'FALSE','INT');
        return $tableField;
    }
}