<?php

namespace App\V1\Action;
use App\V1\Repository\AllExpensesGetterRepository;
use App\V1\Data\ExpenseData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllExpensesGetterAction
{
    private AllExpensesGetterRepository $expensesReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllExpensesGetterRepository $repository)
    {

       $this->expensesReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findPeriods method
        $skus = $this->expensesReader->findExpenses();

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
                'expense_name' => $expense->name,


                ];
            }
        return $this->withJson(
            $response,
            [
                'header'=>['responseCode'=>'200','responseMessage'=>'Expenses fetched successfully!'],
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
