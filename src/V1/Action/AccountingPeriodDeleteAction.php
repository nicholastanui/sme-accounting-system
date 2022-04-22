<?php

namespace App\V1\Action;

use App\V1\Main\PeriodDeleter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AccountingPeriodDeleteAction
{
    private PeriodDeleter $periodDeleter;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param PeriodDeleter $campaignDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(PeriodDeleter $periodDeleter)
    {
        $this->periodDeleter = $periodDeleter;

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
        $res=  $this->periodDeleter->deletePeriod($campaignId);
        $result = (object)
          [
            'header'=>['responseCode'=>'200','responseMessage'=>'Period deleted successfully!'],
            'body'=>[
              'data' => $campaignId
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
