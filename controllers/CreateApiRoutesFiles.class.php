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


class CreateApiRoutesFiles extends TCreateFileContent
{
    private $tableName;
    private $tableType;
    private $listColumnsProperties;

    public function __construct($pathFolder ,$tableName ,$listColumnsProperties, $tableType)
    {
        $tableName = ucfirst(strtolower($tableName));
        $this->setTableName($tableName);
        $this->setTableType($tableType);
        $this->setFileName($tableName.'.route.php');
        $this->setFilePath($pathFolder);
        $this->setListColumnsProperties($listColumnsProperties);
    }
    //-----------------------------------------------------------------------------------
    public function setTableName($strTableName)
    {
        $strTableName = strtolower($strTableName);
        $this->tableName=$strTableName;
    }
    public function getTableName()
    {
        return $this->tableName;
    }
    //------------------------------------------------------------------------------------
    public function setTableType($tableType)
    {
        $this->tableType = $tableType;
    }
    public function getTableType()
    {
        return $this->tableType;
    }    
    //--------------------------------------------------------------------------------------
    public function setListColumnsProperties($listColumnsProperties)
    {
        TGeneratorHelper::validateListColumnsProperties($listColumnsProperties);
        $this->listColumnsProperties = $listColumnsProperties;
    }
    public function getListColumnsProperties()
    {
        return $this->listColumnsProperties;
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addLine('$app->group(\'/'.$this->getTableName().'\', function() use ($app) {');
        $this->addLine(ESP.'$app->get(\'\', '.$this->getTableName().'API::class . \':selectAll\');');
        $this->addBlankLine();
        $this->addLine(ESP.'$app->get(\'/{id:[0-9]+}\', '.$this->getTableName().'API::class . \':selectAll\');');
        $this->addLine('});');

        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
