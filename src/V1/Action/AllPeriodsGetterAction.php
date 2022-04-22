<?php

namespace App\V1\Action;
use App\V1\Repository\AllPeriodsGetterRepository;
use App\V1\Data\PeriodData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllPeriodsGetterAction
{
    private AllPeriodsGetterRepository $periodsReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllPeriodsGetterRepository $repository)
    {
      //  $this->responder = $responder;
       $this->periodsReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findPeriods method
        $periods = $this->periodsReader->findPeriods();

        return $this->transform($response, $periods);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param CampaignData $period The accounting period
     *
     * @return ResponseInterface The response
     */
     private function transform(ResponseInterface $response, array $periods): ResponseInterface
     {
             $periodList = [];

             foreach ($periods as $period) {
                 $periodList[] = [

                'id' => $period->id,
                'name' => $period->name

                ];
            }
        return $this->withJson(
            $response,
            [
                'header'=>['responseCode'=>'200','responseMessage'=>'Accounting period fetched successfully!'],
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
