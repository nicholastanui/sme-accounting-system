<?php
namespace App\V1\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class ProductData
{
    public ?string $id = null;

    public ?string $productName = null;

    public ?string $buyingPrice = null;

    public ?string $supplier = null;

    public ?string $createdDate = null;

    public ?string $updatedDate = null;

    public ?string $sku = null;
    
    public ?string $companyId= null;
    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [],$p2 = null)
    {
      if($p2==null){
        //$reader = new ArrayReader($data);
        foreach ($data as $key => $value) {
          $this->id = $value['id'];
          $this->productName = $value['product_name'];
          $this->buyingPrice=$value['buying_price'];
          $this->createdDate =$value['created'];
          $this->updatedDate = $value['updated'];
          $this->supplier=$value['supplier_id'];
          $this->sku=$value['sku_id'];
          $this->companyId =$value['company_id'];
        }
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
      }
      else
      {
          $reader = new ArrayReader($data);
          $this->id = $reader->getString('id');
          $this->productName =  $reader->getString('product_name');
          $this->buyingPrice=$reader->getString('buying_price');
          $this->supplier=$reader->getString('supplier_id');
          $this->sku=$reader->getString('sku_id');
          $this->createdDate = $reader->getString('created');
          $this->updatedDate =  $reader->getString('updated');
          $this->companyId = $reader->getString('company_id');
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
    }
  }
}
