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
        if( $tableType == TableInfo::TB_TYPE_TABLE ){
            $this->addLine('//  TABLE: '.$tableName);
        }else{
            $this->addLine('//  VIEW: '.$tableName);
        }
        $this->addLine('//--------------------------------------------------------------------');
    }
    //--------------------------------------------------------------------------------------
    public function addRouterForTable()
    {
        $this->addBlankLine();
        $listTableNames = $this->getListTableNames();
        foreach ($listTableNames['TABLE_NAME'] as $key => $tableName) { 
            $tableType = strtoupper($listTableNames['TABLE_TYPE'][$key]);
            $this->addBlankLine();
            $this->addBlankLine();
            $this->addCommentTableOrView($tableType,$tableName);
            $tableName = ucfirst(strtolower($tableName));
            $this->addLine('$urlGrupo = $urlChamada.\'strtolower($tableName)\';');
            $this->addLine('$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {');
            $this->addLine(ESP.'$app->get($urlGrupo.\'\', '.$tableName.'API::class . \':selectAll\');');
            $this->addLine(ESP.'$app->get($urlGrupo.\'/{id:[0-9]+}\', '.$tableName.'API::class . \':selectById\');');
            $this->addBlankLine();
            if( $tableType == TableInfo::TB_TYPE_TABLE ){
                $this->addBlankLine();
                $this->addLine(ESP.'$app->post($urlGrupo.\'\', '.$tableName.'API::class . \':save\');');
                $this->addLine(ESP.'$app->put($urlGrupo.\'/{id:[0-9]+}\', '.$tableName.'API::class . \':save\');');
                $this->addLine(ESP.'$app->delete($urlGrupo.\'/{id:[0-9]+}\', '.$tableName.'API::class . \':delete\');');
            }
            $this->addLine('});');
        }
    }
    //--------------------------------------------------------------------------------------
    public function addNameSpaces($contract = false)
    {
        $this->addLine('use Psr\Http\Message\ResponseInterface as Response;');
        $this->addLine('use Psr\Http\Message\ServerRequestInterface as Request;');
        $this->addLine('use Slim\Routing\RouteCollectorProxy as RouteCollectorProxy;');
        $this->addLine('use Slim\Factory\AppFactory;');
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
    public function addFactoryAndMiddleware()
    {
        $this->addBlankLine();
        $this->addLine('/**');
        $this->addLine(' * Instantiate App');
        $this->addLine(' *');
        $this->addLine(' * In order for the factory to work you need to ensure you have installed');
        $this->addLine(' * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported');
        $this->addLine(' * ServerRequest creator (included with Slim PSR-7)');
        $this->addLine(' */');
        $this->addLine('$app = AppFactory::create();');
        $this->addBlankLine();
        $this->addLine('/**');
        $this->addLine(' * The routing middleware should be added earlier than the ErrorMiddleware');
        $this->addLine(' * Otherwise exceptions thrown from it will not be handled by the middleware');
        $this->addLine(' */');
        $this->addLine('$app->addRoutingMiddleware();');
        $this->addBlankLine();
        $this->addLine('/**');
        $this->addLine(' * Add Error Middleware');
        $this->addLine(' *');
        $this->addLine(' * @param bool                  $displayErrorDetails -> Should be set to false in production');
        $this->addLine(' * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler');
        $this->addLine(' * @param bool                  $logErrorDetails -> Display error details in error log');
        $this->addLine(' * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger  ');
        $this->addLine(' *');
        $this->addLine(' * Note: This middleware should be added last. It will not handle any exceptions/errors');
        $this->addLine(' * for middleware added after it.');
        $this->addLine(' */');
        $this->addLine('$displayErrorDetails = getenv(\'DISPLAY_ERRORS_DETAILS\');');
        $this->addLine('$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);');        
    }    
    //--------------------------------------------------------------------------------------
    public function addIndexRoutes()
    {
        $this->addBlankLine();
        $this->addBlankLine();
        $this->addLine('$urlChamada = ServerHelper::getRequestUri(true);');
        $this->addLine('$urlChamada = explode(\'api/\', $urlChamada);');
        $this->addLine('$urlChamada = $urlChamada[0];');
        $this->addLine('$urlChamada = $urlChamada.\'api/\';');
        $this->addLine('// Define app routes');
        $this->addLine('$app->get($urlChamada, function (Request $request, Response $response, $args) use ($app) {');
        $this->addLine(ESP.'$url = \ServerHelper::getCurrentUrl();');
        $this->addLine(ESP.'$routes = $app->getRouteCollector()->getRoutes();');
        $this->addLine(ESP.'$routesArray = array();');
        $this->addLine(ESP.'foreach ($routes as $route) {');
        $this->addLine(ESP.ESP.'$routeArray = array();');
        $this->addLine(ESP.ESP.'$routeArray[\'id\']  = $route->getIdentifier();');
        $this->addLine(ESP.ESP.'$routeArray[\'name\']= $route->getName();');
        $this->addLine(ESP.ESP.'$routeArray[\'methods\']= $route->getMethods()[0];');
        $this->addLine(ESP.ESP.'$routeArray[\'url\'] = $url.$route->getPattern();');
        $this->addLine(ESP.ESP.'$routesArray[] = $routeArray;');
        $this->addLine(ESP.'}');
        $this->addBlankLine();
        $this->addLine(ESP.'$msg = array( \'info\'=> SysinfoAPI::info()');
        $this->addLine(ESP.ESP.ESP.ESP.', \'endpoints\'=>array( \'qtd\'=> \CountHelper::count($routesArray)');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.',\'result\'=>$routesArray');
        $this->addLine(ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.ESP.')');
        $this->addLine(ESP.ESP.ESP.ESP.');');
        $this->addBlankLine();
        $this->addLine(ESP.'$msgJson = json_encode($msg);');
        $this->addLine(ESP.'$response->getBody()->write( $msgJson );');
        $this->addLine(ESP.'$result = $response->withHeader(\'Content-Type', 'application/json\');');
        $this->addLine(ESP.'return $result;');
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
        $this->addFactoryAndMiddleware();
        $this->addIndexRoutes();
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
