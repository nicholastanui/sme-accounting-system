<?php
namespace App\V1\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class CustomerData
{
    public ?string $id = null;

    public ?string $firstName = null;

    public ?string $msisdn= null;

    public ?string $createdDate = null;

    public ?string $lastName= null;

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
          $this->firstName = $value['first_name'];
          $this->lastName = $value['last_name'];
          $this->msisdn = $value['msisdn'];
          $this->createdDate =$value['created'];
          $this->companyId =$value['company_id'];

        }
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
      }
      else
      {
          $reader = new ArrayReader($data);
          $this->id = $reader->getString('id');
          $this->firstName =  $reader->getString('first_name');
          $this->lastName = $reader->getString('last_name');
          $this->msisdn =  $reader->getString('msisdn');
          $this->createdDate = $reader->getString('created');
          $this->companyId = $reader->getString('company_id');
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
    }
  }
}
