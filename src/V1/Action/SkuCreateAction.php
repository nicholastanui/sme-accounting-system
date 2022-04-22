<?php

namespace App\V1\Action;
use App\V1\Main\SkuCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SkuCreateAction
{
    private $skuCreator;

    public function __construct(SkuCreator $skuCreator)
    {
        $this->skuCreator = $skuCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $campaignId= $this->skuCreator->createSku($data);

        // Transform the result into the JSON representation
        $result = (object)
          [
            'header'=>['responseCode'=>'200','responseMessage'=>'Sku created successfully!'],
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
