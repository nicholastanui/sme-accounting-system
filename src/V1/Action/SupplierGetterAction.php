<?php

namespace App\V1\Action;
use App\V1\Main\SupplierGetter;
use App\V1\Data\SupplierData;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class SupplierGetterAction
{
    private SupplierGetter $supplierGetter;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(SupplierGetter $repository)
    {
      //  $this->responder = $responder;
       $this->supplierGetter = $repository;
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
        $companyId = (int)$args['id'];

        // Invoke the domain (service class)
        $supplier = $this->supplierGetter->getSupplier($companyId);

        // Transform result
      return $this->transform($response, $supplier);
      //return $campaign;
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param CompanyData $company The company
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, SupplierData $supplier): ResponseInterface
    {
        // Turn that object into a structured array
        $data = [
            'id' => $supplier->id,
            'phone_number' => $supplier->phoneNumber,
            'supplier_name' => $supplier->supplierName,
            'email' => $supplier->email,
            'created' => $supplier->createdDate,
            'updated' => $supplier->updatedDate

        ];

        // Turn all of that into a JSON string and put it into the response body
        return $this->withJson($response,   [
            'header'=>['responseCode'=>'200','responseMessage'=>'Supplier fetched successfully!'],
            'body'=>
       (object) $data

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
