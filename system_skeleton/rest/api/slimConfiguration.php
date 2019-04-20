<?php
function slimConfiguration()
{
    $configuration = [
        'settings' => [
            'displayErrorDetails' => getenv('DISPLAY_ERRORS_DETAILS'),
        ],
    ];
    $container = new \Slim\Container($configuration);

    /**
     * Converte os Exceptions entro da Aplicação em respostas JSON
     */
    $container['errorHandler'] = function ($container) {
        return function ($request, $response, $exception) use ($container) {
            $statusCode = $exception->getCode() ? $exception->getCode() : 500;
            return $container['response']
            ->withStatus($statusCode)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(["message" => $exception->getMessage()], $statusCode);
        };
    };
    
    /**
     * Converte os Exceptions de Erros 405 - Not Allowed
     */
    $container['notAllowedHandler'] = function ($container) {
        return function ($request, $response, $methods) use ($container) {
            return $container['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-Type', 'Application/json')
            ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
            ->withJson(["message" => "Method not Allowed; Method must be one of: " . implode(', ', $methods)], 405);
        };
    };    
    
    /**
     * Converte os Exceptions de Erros 404 - Not Found
     */
    $container['notFoundHandler'] = function ($container) {
        return function ($request, $response) use ($container) {
            return $container['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(['message' => 'Page not found']);
        };
    };
    
    return $container;
}