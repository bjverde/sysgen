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


class TCreateVO extends TCreateFileContent
{
    private $tableName;
    private $aColumns = array();
    private $charParam = '?';
    private $listColumnsProperties;

    public function __construct($pathFolder ,$tableName ,$listColumnsProperties ,$databaseManagementSystem)
    {
        $tableName = strtolower($tableName);
        $this->setTableName($tableName);
        $this->setFileName(ucfirst($tableName).'VO.class.php');
        $this->setFilePath($pathFolder);
        $this->setListColumnsProperties($listColumnsProperties);
        $this->configArrayColumns();
        
        if ($databaseManagementSystem == DBMS_POSTGRES) {
            $this->charParam = '$1';
        }
    }
    //-----------------------------------------------------------------------------------
    public function setTableName($strTableName)
    {
        $strTableName = strtolower($strTableName);
        $this->tableName=$strTableName;
    }
    //------------------------------------------------------------------------------------
    public function getTableName()
    {
        return $this->tableName;
    }
    //------------------------------------------------------------------------------------
    public function getCharParam()
    {
        return $this->charParam;
    }
    //------------------------------------------------------------------------------------
    public function addColumn($strColumnName)
    {
        if (!in_array($strColumnName, $this->aColumns)) {
            $this->aColumns[] = strtolower($strColumnName);
        }
    }
    //--------------------------------------------------------------------------------------
    public function getColumns()
    {
        return $this->aColumns;
    }
    //--------------------------------------------------------------------------------------
    public function setListColumnsProperties($listColumnsProperties)
    {
        if (!is_array($listColumnsProperties)) {
            throw new InvalidArgumentException('List of Columns Properties not is a array');
        }
        $this->listColumnsProperties = $listColumnsProperties;
    }
    public function getListColumnsProperties()
    {
        return $this->listColumnsProperties;
    }
    //--------------------------------------------------------------------------------------
    protected function configArrayColumns()
    {
        $listColumnsProperties = $this->getListColumnsProperties();
        $listColumns = $listColumnsProperties['COLUMN_NAME'];
        foreach ($listColumns as $v) {
            $this->addColumn($v);
        }
    }
    //--------------------------------------------------------------------------------------
    protected function addGettersAndSetters()
    {
        foreach ($this->getColumns() as $v) {
            $this->addLine(ESP.'public function set'.ucfirst($v).'( $strNewValue = null )');
            $this->addLine(ESP."{");
            if (preg_match('/cpf|cnpj/i', $v) > 0) {
                $this->addLine(ESP.ESP.'$this->'.$v.' = preg_replace(\'/[^0-9]/\',\'\',$strNewValue);');
            } else {
                $this->addLine(ESP.ESP.'$this->'.$v.' = $strNewValue;');
            }
            $this->addLine(ESP."}");
            $this->addLine(ESP.'public function get'.ucfirst($v).'()');
            $this->addLine(ESP."{");
            if (preg_match('/^data?_/i', $v) == 1) {
                $this->addLine(ESP.ESP."return is_null( \$this->{$v} ) ? date( 'Y-m-d h:i:s' ) : \$this->{$v};");
            } else {
                $this->addLine(ESP.ESP.'return $this->'.$v.';');
            }
            $this->addLine(ESP."}");
            $this->addLine();
        }
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addLine('class '.ucfirst($this->getTableName()).'VO');
        $this->addLine('{');
        $cols='';
        $sets='';
        foreach ($this->getColumns() as $k => $v) {
            $this->addLine(ESP.'private $'.$v.' = null;');
            $cols .= $cols == '' ? '' : ', ';
            $cols .='$'.$v.'=null';
            $sets .= ($k == 0 ? '' : EOL ).ESP.ESP.'$this->set'.ucFirst($v).'( $'.$v.' );';
        }
        $this->addLine(ESP.'public function __construct( '.$cols.' ) {');
        $this->addLine($sets);
        $this->addLine(ESP.'}');
        $this->addLine();
        $this->addGettersAndSetters();
        $this->addLine("}");
        $this->addLine('?>');
        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
