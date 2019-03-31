<?php
namespace Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class SysinfoAPI {
    
    
    public function __construct(){
    }
    
    //--------------------------------------------------------------------------------
    public static function getInfo(Request $request, Response $response, array $args): Response
    {
        $result = array(
            'SYSTEM_NAME'=>SYSTEM_NAME
            ,'SYSTEM_ACRONYM'=>SYSTEM_ACRONYM
            ,'SYSTEM_VERSION'=>SYSTEM_VERSION
        );
        
        $response = $response->withJson($result);
        return $response;
    }
}