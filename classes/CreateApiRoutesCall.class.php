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

class CreateApiRoutesCall extends TCreateFileContent
{
    private $listTableNames;

    public function __construct($listTableNames)
    {
        $this->setListTableNames($listTableNames);
        $this->setFileName('routes.php');
        $path = TGeneratorHelper::getPathNewSystem().DS.'api'.DS;
        $this->setFilePath($path);
    }
    //--------------------------------------------------------------------------------------
    public function setListTableNames($listTableNames)
    {
        TGeneratorHelper::validateListTableNames($listTableNames);
        $this->listTableNames = $listTableNames;
    }
    public function getListTableNames()
    {
        return $this->listTableNames;
    }
    //--------------------------------------------------------------------------------------
    private function addClass($contract = false)
    {
        $listTableNames = $this->getListTableNames();
        if($contract){
            foreach ($listTableNames['TABLE_NAME'] as $tableName) {
                $tableName = ucfirst(strtolower($tableName));
                $this->addLine(ESP.','.$tableName.'API');
            }
        }else{
            foreach ($listTableNames['TABLE_NAME'] as $tableName) {
                $tableName = ucfirst(strtolower($tableName));
                $this->addLine('use api_controllers\\'.$tableName.'API;');
            }
        }
    }
    //--------------------------------------------------------------------------------------
    public function addFileRouter()
    {
        $listTableNames = $this->getListTableNames();
        foreach ($listTableNames['TABLE_NAME'] as $tableName) {
            $this->addLine('require_once \'routes\'.DS.\''.$tableName.'.route.php\';');
        }
    }
    //--------------------------------------------------------------------------------------
    public function addCommentTableOrView($tableType,$tableName){
        $this->addLine('//--------------------------------------------------------------------');
        if( $tableType == TGeneratorHelper::TABLE_TYPE_TABLE ){
            $this->addLine('//  TABLE: '.$tableName);
        }else{
            $this->addLine('//  VIEW: '.$tableName);
        }
        $this->addLine('//--------------------------------------------------------------------');
    }
    //--------------------------------------------------------------------------------------
    public function addRouterForTable()
    {
        $listTableNames = $this->getListTableNames();
        foreach ($listTableNames['TABLE_NAME'] as $key => $tableName) { 
            $tableType = strtoupper($listTableNames['TABLE_TYPE'][$key]);
            $this->addBlankLine();
            $this->addBlankLine();
            $this->addCommentTableOrView($tableType,$tableName);
            $tableName = ucfirst(strtolower($tableName));
            $this->addLine('$app->group(\'/'.strtolower($tableName).'\', function() use ($app) {');
            $this->addLine(ESP.'$app->get(\'\', '.$tableName.'API::class . \':selectAll\');');
            $this->addLine(ESP.'$app->get(\'/{id:[0-9]+}\', '.$tableName.'API::class . \':selectById\');');
            $this->addBlankLine();
            if( $tableType == TGeneratorHelper::TABLE_TYPE_TABLE ){
                $this->addBlankLine();
                $this->addLine(ESP.'$app->post(\'\', '.$tableName.'API::class . \':save\');');
                $this->addLine(ESP.'$app->put(\'/{id:[0-9]+}\', '.$tableName.'API::class . \':save\');');
                $this->addLine(ESP.'$app->delete(\'/{id:[0-9]+}\', '.$tableName.'API::class . \':delete\');');
            }
            $this->addLine('});');
        }
    }
    //--------------------------------------------------------------------------------------
    public function addNameSpaces($contract = false)
    {
        $this->addBlankLine();
        $this->addLine('use api_controllers\SysinfoAPI;');
        if($contract){
            $this->addLine('use api_controllers\{');        
            $this->addClass($contract);
            $this->addLine('};');
        }else{
            $this->addClass($contract);
        }
    }
    //--------------------------------------------------------------------------------------
    public function addIndexRoutes()
    {
        $this->addBlankLine();
        $this->addLine('$app->get("/", function ($request, $response, $args) use ($app) {');
        $this->addLine(ESP.'$url = \ServerHelper::getCurrentUrl();');
        $this->addLine(ESP.'$url = substr($url,0,strlen($url)-1);');
        $this->addLine(ESP.'$routes = $app->getContainer()->router->getRoutes();');
        $this->addLine(ESP.'$routesArray = array();');
        $this->addLine(ESP.'foreach ($routes as $route) {');
        $this->addLine(ESP.ESP.'$routeArray = array();');
        $this->addLine(ESP.ESP.'$met = $route->getMethods();');
        $this->addLine(ESP.ESP.'$routeArray[\'methods\']  = $met[0];');
        $this->addLine(ESP.ESP.'$routeArray[\'url\']  = $url.$route->getPattern();');
        $this->addLine(ESP.ESP.'$routesArray[] = $routeArray;');
        $this->addLine(ESP.'}');
        $this->addBlankLine();
        $this->addLine(ESP.'$msg = array( \'info\'=> SysinfoAPI::info()');
        $this->addLine(ESP.ESP.ESP.ESP.', \'endpoints\'=>array( \'qtd\'=> \CountHelper::count($routesArray)');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.',\'result\'=>$routesArray');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.')');
        $this->addLine(ESP.ESP.ESP.ESP.');');
        $this->addBlankLine();
        $this->addLine(ESP.'$response = $response->withJson($msg);');
        $this->addLine(ESP.'return $response;');
        $this->addLine('});');
        $this->addBlankLine();
        $this->addLine('$app->get(\'/sysinfo\', SysinfoAPI::class . \':getInfo\');');
    }    
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addNameSpaces();
        $this->addBlankLine();
        $this->addLine('$app = new \Slim\App(slimConfiguration());');
        $this->addIndexRoutes();        
        $this->addBlankLine();
        $this->addRouterForTable();
        $this->addBlankLine();
        $this->addLine('$app->run();');
        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
