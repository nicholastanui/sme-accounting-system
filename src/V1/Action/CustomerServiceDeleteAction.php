<?php

namespace App\V1\Action;

use App\V1\Main\CustomerServiceDeleter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class CustomerServiceDeleteAction
{
    private CustomerServiceDeleter $serviceDeleter;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param ServiceDeleter $campaignDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(CustomerServiceDeleter $serviceDeleter)
    {
        $this->serviceDeleter = $serviceDeleter;

    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The routing arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $campaignId = (int)$args['id'];

        // Invoke the domain (service class)
        $res=  $this->serviceDeleter->deleteService($campaignId);
        $result = (object)
          [
            'header'=>['responseCode'=>'200','responseMessage'=>'Services deleted successfully!'],
            'body'=>[
                'data' => $res
              ]
          ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
        // Render the json response
        return $this->withJson($response);
    }
    public function withJson(
        ResponseInterface $response,
        $data = null,
        int $options = 0
    ): ResponseInterface {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write((string)json_encode($data, $options));

        return $response;
    }
}
