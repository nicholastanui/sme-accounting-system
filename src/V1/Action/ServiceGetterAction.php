<?php

namespace App\V1\Action;
use App\V1\Main\ServiceGetter;
use App\V1\Data\ServiceData;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ServiceGetterAction
{
    private ServiceGetter $serviceGetter;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(ServiceGetter $repository)
    {
      //  $this->responder = $responder;
       $this->serviceGetter = $repository;
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
        $service = $this->serviceGetter->getService($periodId);

        // Transform result
      return $this->transform($response, $service);
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
    private function transform(ResponseInterface $response, ServiceData $service): ResponseInterface
    {
        // Turn that object into a structured array
        $data = [
            'id' => $service->id,
            'service_name' => $service->serviceName,
            'price'=>$service->price

        ];

        // Turn all of that into a JSON string and put it into the response body
        return $this->withJson($response,   [
            'header'=>['responseCode'=>'200','responseMessage'=>'Service fetched successfully!'],
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
