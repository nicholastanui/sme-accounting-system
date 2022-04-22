<?php

namespace App\V1\Action;
use App\V1\Repository\AllSuppliersGetterRepository;
use App\V1\Data\SupplierData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllSuppliersGetterAction
{
    private AllSuppliersGetterRepository $supplierReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllSuppliersGetterRepository $repository)
    {
      //  $this->responder = $responder;
       $this->supplierReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response,array $args): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findCustomers method
        $companyId = (int)$args['id'];
        $suppliers = $this->supplierReader->findSuppliers($companyId);

        return $this->transform($response, $suppliers);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param CampaignData $user The user
     *
     * @return ResponseInterface The response
     */
     private function transform(ResponseInterface $response, array $suppliers): ResponseInterface
     {
             $customerList = [];

             foreach ($suppliers as $supplier) {
                 $customerList[] = [

                'id' => $supplier->id,
                'supplier_name' => $supplier->supplierName,
                'email' => $supplier->email,
                'phone_number' => $supplier->phoneNumber,
                'created' => $supplier->createdDate,
                'updated' => $supplier->updatedDate,
                ];
            }
        return $this->withJson(
            $response,
            [
              'header'=>['responseCode'=>'200','responseMessage'=>'Suppliers fetched successfully'],
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
