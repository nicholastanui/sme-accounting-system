<?php

namespace App\V1\Action;
use App\V1\Main\AccountingPeriodGetter;
use App\V1\Data\SelectedPeriodData;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AccountingPeriodGetterAction
{
    private AccountingPeriodGetter $periodGetter;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AccountingPeriodGetter $repository)
    {
      //  $this->responder = $responder;
       $this->periodGetter = $repository;
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
        $periodId = (int)$args['id'];

        // Invoke the domain (service class)
        $period = $this->periodGetter->getAccountingPeriod($periodId);

        // Transform result
      return $this->transform($response, $period);
      //return $campaign;
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param periodData $period The period
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, SelectedPeriodData $period): ResponseInterface
    {
        // Turn that object into a structured array
        $data = [
            'id' => $period->id,
            'name' => $period->name


        ];

        // Turn all of that into a JSON string and put it into the response body
        return $this->withJson($response,   [
              'header'=>['responseCode'=>'200','responseMessage'=>'Period fetched successfully!'],
            'body'=>[
      'data' => $data,
        ]
      ]);
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
