<?php

namespace App\V1\Action;
use App\V1\Repository\AllCustomersGetterRepository;
use App\V1\Data\CustomerData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllCustomersGetterAction
{
    private AllCustomersGetterRepository $customersReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllCustomersGetterRepository $repository)
    {
      //  $this->responder = $responder;
       $this->customersReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response,array $args): ResponseInterface
    {
        $companyId = (int)$args['id'];
        // Optional: Pass parameters from the request to the findCustomers method
        $customers = $this->customersReader->findCustomers($companyId);

        return $this->transform($response, $customers);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param CampaignData $user The user
     *
     * @return ResponseInterface The response
     */
     private function transform(ResponseInterface $response, array $customers): ResponseInterface
     {
             $customerList = [];

             foreach ($customers as $customer) {
                 $customerList[] = [

                'id' => $customer->id,
                'msisdn' => $customer->msisdn,
                'first_name' => $customer->firstName,
                'last_name' => $customer->lastName,
                'company_id'=> $customer->companyId

                ];
            }
        return $this->withJson(
            $response,
            [
              'header'=>['responseCode'=>'200','responseMessage'=>'Customers fetched successfully!'],
              'body'=>[
        'data' => $customerList,
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
