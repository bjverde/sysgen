<?php
namespace api_controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class SysinfoAPI {
        
    public function __construct(){
    }
    //--------------------------------------------------------------------------------
    public static function info()
    {
        $result = array(
            'SYSTEM_NAME'=>SYSTEM_NAME
            ,'SYSTEM_ACRONYM'=>SYSTEM_ACRONYM
            ,'SYSTEM_VERSION'=>SYSTEM_VERSION
        );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function getInfo(Request $request, Response $response, array $args)
    {
        $msg = self::info();
        $response = TGenericAPI::getBodyJson($msg,$response);
        return $response;
    }
}