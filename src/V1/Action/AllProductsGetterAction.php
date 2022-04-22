<?php

namespace App\V1\Action;
use App\V1\Repository\AllProductsGetterRepository;
use App\V1\Data\ProductData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllProductsGetterAction
{
    private AllProductsGetterRepository $productsReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllProductsGetterRepository $repository)
    {
      //  $this->responder = $responder;
       $this->productsReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response,array $args): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findPeriods method
          $companyId = (int)$args['id'];
        $products = $this->productsReader->findProducts($companyId);

        return $this->transform($response, $products);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param CampaignData $period The accounting period
     *
     * @return ResponseInterface The response
     */
     private function transform(ResponseInterface $response, array $products): ResponseInterface
     {
             $periodList = [];

             foreach ($products as $product) {
                 $periodList[] = [

                'id' => $product->id,
                'product_name' => $product->productName,
                'buying_price' =>$product->buyingPrice,
                'sku_id'=>$product->sku,
                'supplier_id'=>$product->supplier,
                'created'=>$product->createdDate,
                'updated'=>$product->updatedDate

                ];
            }
        return $this->withJson(
            $response,
            [
                'header'=>['responseCode'=>'200','responseMessage'=>'Products fetched successfully!'],
              'body'=>[
        'data' => $periodList,
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
