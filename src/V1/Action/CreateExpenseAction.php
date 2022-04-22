<?php

namespace App\V1\Action;
use App\V1\Main\ExpenseCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateExpenseAction
{
    private $expenseCreator;

    public function __construct(ExpenseCreator $expenseCreator)
    {
        $this->expenseCreator = $expenseCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $campaignId= $this->expenseCreator->createExpense($data);

        // Transform the result into the JSON representation
        $result = (object)
          [
            'header'=>['responseCode'=>'200','responseMessage'=>'Expense created successfully!'],
            'body'=>[
              'data' => $campaignId
          ]

        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
