<?php

namespace App\V1\Action;
use App\V1\Main\ExpenseEditor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExpenseEditAction
{
    private $accEditor;

    public function __construct(ExpenseEditor $accEditor)
    {
        $this->accEditor = $accEditor;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $campaignId= $this->accEditor->editExpense($data);

        // Transform the result into the JSON representation
        $result = (object)
          [
              'header'=>['responseCode'=>'200','responseMessage'=>'Sku edited successfully!'],
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
