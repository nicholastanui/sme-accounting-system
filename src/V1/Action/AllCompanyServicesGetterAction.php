<?php

namespace App\V1\Action;
use App\V1\Repository\AllCompanyServicesGetterRepository;
use App\V1\Data\CpmpanyServiceData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllCompanyServicesGetterAction
{
    private AllCompanyServicesGetterRepository $servicesReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllCompanyServicesGetterRepository $repository)
    {
      //  $this->responder = $responder;
       $this->servicesReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response,array $args): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findPeriods method
          $companyId = (int)$args['id'];
        $services = $this->servicesReader->findServices($companyId);

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
                'service_id' => $service->serviceId,
                'company_id'=>$service->companyId,
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
