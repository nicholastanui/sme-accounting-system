<?php
namespace App\V1\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class ServiceData
{
    public ?string $id = null;

    public ?string $serviceName = null;

    public ?string $price = null;

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
          $this->serviceName = $value['service_name'];
          $this->price=$value['price'];
          $this->companyId =$value['company_id'];
        }
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
      }
      else
      {
          $reader = new ArrayReader($data);
          $this->id = $reader->getString('id');
          $this->serviceName =  $reader->getString('service_name');
          $this->price=$reader->getString('price');
          $this->companyId = $reader->getString('company_id');
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
    }
  }
}
