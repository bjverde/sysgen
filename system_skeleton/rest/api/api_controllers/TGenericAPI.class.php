<?php
namespace api_controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TGenericAPI
{
    public function __construct()
    {
    }

    public static function getBodyJson($msg, Response $response)
    {
        $msgJson = json_encode($msg);
        $response->getBody()->write( $msgJson );
        return $response->withHeader('Content-Type', 'application/json');
    }
}