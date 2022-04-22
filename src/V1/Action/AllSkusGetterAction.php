<?php

namespace App\V1\Action;
use App\V1\Repository\AllSkusGetterRepository;
use App\V1\Data\SkuData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllSkusGetterAction
{
    private AllSkusGetterRepository $skusReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllSkusGetterRepository $repository)
    {
      //  $this->responder = $responder;
       $this->skusReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findPeriods method
        $skus = $this->skusReader->findSkus();

        return $this->transform($response, $skus);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param CampaignData $period The accounting period
     *
     * @return ResponseInterface The response
     */
     private function transform(ResponseInterface $response, array $skus): ResponseInterface
     {
             $periodList = [];

             foreach ($skus as $sku) {
                 $periodList[] = [

                'id' => $sku->id,
                'unit' => $sku->unit,


                ];
            }
        return $this->withJson(
            $response,
            [
                'header'=>['responseCode'=>'200','responseMessage'=>'Skus fetched successfully!'],
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
