<?php

namespace App\V1\Action;
use App\V1\Repository\AllServicesGetterRepository;
use App\V1\Data\ServiceData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllServicesGetterAction
{
    private AllServicesGetterRepository $servicesReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllServicesGetterRepository $repository)
    {
      //  $this->responder = $responder;
       $this->servicesReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findPeriods method
        $services = $this->servicesReader->findServices();

        return $this->transform($response, $services);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param CampaignData $period The accounting period
     *
     * @return ResponseInterface The response
     */
     private function transform(ResponseInterface $response, array $services): ResponseInterface
     {
             $periodList = [];

             foreach ($services as $service) {
                 $periodList[] = [

                'id' => $service->id,
                'service_name' => $service->serviceName,
                'price' =>$service->price

                ];
            }
        return $this->withJson(
            $response,
            [
              'header'=>['responseCode'=>'200','responseMessage'=>'Services fetched successfully!'],
              'body'=>[
        'data' => $periodList,
          ]
        ]
        );
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
