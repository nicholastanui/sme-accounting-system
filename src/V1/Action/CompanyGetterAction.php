<?php

namespace App\V1\Action;
use App\V1\Main\CompanyGetter;
use App\V1\Data\CompanyData;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class CompanyGetterAction
{
    private CompanyGetter $companyGetter;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(CompanyGetter $repository)
    {
      //  $this->responder = $responder;
       $this->companyGetter = $repository;
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
        $user = $this->companyGetter->getCompany($companyId);

        // Transform result
      return $this->transform($response, $user);
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
    private function transform(ResponseInterface $response, CompanyData $company): ResponseInterface
    {
        // Turn that object into a structured array
        $data = [
            'id' => $company->id,
            'phone_number' => $company->phoneNumber,
            'business_name' => $company->businessName,
            'email' => $company->email,
            'location' => $company->location,
            'lat' => $company->lat,
            'lon' => $company->lon,
            'active' => $company->active,

        ];

        // Turn all of that into a JSON string and put it into the response body
        return $this->withJson($response,   [
            'header'=>['responseCode'=>'200','responseMessage'=>'Company fetched successfully!'],
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
