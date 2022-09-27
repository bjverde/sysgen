<?php
namespace api_controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TGenericAPI
{
    public function __construct()
    {
    }
    public static function getBodyJson($msg, Response $response,$status=200)
    {
        $status = empty($status)?200:$status;
        $msgJson = json_encode($msg, JSON_UNESCAPED_UNICODE);
        $response->withHeader('Content-Type', 'application/json');        
        $response->getBody()->write( $msgJson );
        return $response->withStatus( $status );
    }
    public static function getSelectNumPage($args)
    {
        $page = \ArrayHelper::get($args,'page');
        return $page;
    }
    public static function getSelectNumRowsPerPage($args)
    {
        $rowsPerPage = \ArrayHelper::get($args,'rowsPerPage');
        $rowsPerPage = empty($page)?ROWS_PER_PAGE:$rowsPerPage;
        return $rowsPerPage;
    }
}