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

class TCreateConstants extends TCreateFileContent
{

    public function __construct()
    {
        $this->setFileName('constantes.php');
        $path = TGeneratorHelper::getPathNewSystem().DS.'includes'.DS;
        $this->setFilePath($path);
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('define(\'FORMDIN_VERSION_MIN\', \''.FORMDIN_VERSION.'\');');        
        $this->addBlankLine();
        $this->addLine('define(\'SYSTEM_VERSION\' , \''.$_SESSION[APLICATIVO]['GEN_SYSTEM_VERSION'].'\');');
        $this->addLine('define(\'SYSTEM_ACRONYM\' , \''.$_SESSION[APLICATIVO]['GEN_SYSTEM_ACRONYM'].'\');');
        $this->addLine('define(\'APLICATIVO\'     , SYSTEM_ACRONYM);');
        $this->addLine('define(\'SYSTEM_NAME\'    , \''.$_SESSION[APLICATIVO]['GEN_SYSTEM_NAME'].'\');');
        $this->addLine('//define(\'SYSTEM_NAME_SUB\' , \'Subtítulo do sistema\');');
        $this->addLine('//define(\'SYSTEM_UNIT\' , \'Nome unidade que irá aparecer no rodapé\');');        
        $this->addBlankLine();
        $this->addLine('if (! defined ( \'DS\' )) {');
        $this->addLine(ESP.'define(\'DS\'   , DIRECTORY_SEPARATOR);');
        $this->addLine('}');
        $this->addLine('?>');
        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
