<?php

namespace App\V1\Action;
use App\V1\Repository\AllCompaniesGetterRepository;
use App\V1\Data\CompanyData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllCompaniesGetterAction
{
    private AllCompaniesGetterRepository $companiesReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CompanyReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllCompaniesGetterRepository $repository)
    {
      //  $this->responder = $responder;
       $this->companiesReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findUsers method
        $users = $this->companiesReader->findCompanies();

        return $this->transform($response, $users);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param CompanyData $company The company
     *
     * @return ResponseInterface The response
     */
     private function transform(ResponseInterface $response, array $companies): ResponseInterface
     {
             $companyList = [];

             foreach ($companies as $company) {
                 $companyList[] = [

                'id' => $company->id,
                'phone_number' => $company->phoneNumber,
                'business_name' => $company->businessName,
                'email' => $company->email,
                'location' => $company->location,
                'lat' => $company->lat,
                'lon' => $company->lon,
                'created' => $company->createdDate,
                'updated'=> $company->updatedDate,
                'active' => $company->active,

                ];
            }
        return $this->withJson(
            $response,
            [
              'header'=>['responseCode'=>'200','responseMessage'=>'Accounting period fetched successfully!'],
              'body'=>[
        'data' => $companyList,
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
