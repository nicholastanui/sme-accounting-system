<?php

namespace App\V1\Action;
use App\V1\Repository\AllCompanyUsersGetterRepository;
use App\V1\Data\ExpenseData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllCompanyUsersGetterAction
{
    private AllCompanyUsersGetterRepository $expensesReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllCompanyUsersGetterRepository $repository)
    {

       $this->expensesReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response,array $args): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findPeriods method
        $companyId = (int)$args['id'];
        $skus = $this->expensesReader->findUsers($companyId);

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
     private function transform(ResponseInterface $response, array $expenses): ResponseInterface
     {
             $expenseList = [];

             foreach ($expenses as $expense) {
                 $expenseList[] = [

                'id' => $expense->id,
                'first_name' => $expense->firstName,
                'company_id'=>$expense->companyId,
                'msisdn'=>$expense->msisdn,
                'last_name'=>$expense->lastName,
                'created'=>$expense->createdDate,
                'updated'=>$expense->updatedDate,
                'role'=>$expense->role,
                'active'=>$expense->active

                ];
            }
        return $this->withJson(
            $response,
            [
                'header'=>['responseCode'=>'200','responseMessage'=>'Company Users fetched successfully!'],
              'body'=>[
        'data' => $expenseList,
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
