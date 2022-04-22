<?php
namespace App\V1\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class SupplierData
{
    public ?string $id = null;

    public ?string $supplierName = null;

    public ?string $phoneNumber= null;

    public ?string $createdDate = null;

    public ?string $updatedDate= null;

    public ?string $email= null;

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
          $this->supplierName = $value['supplier_name'];
          $this->email = $value['email'];
          $this->phoneNumber = $value['phone_number'];
          $this->createdDate =$value['created'];
          $this->updatedDate=$value['updated'];
          $this->companyId =$value['company_id'];

        }
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
      }
      else
      {
          $reader = new ArrayReader($data);
          $this->id = $reader->getString('id');
          $this->supplierName =  $reader->getString('supplier_name');
          $this->email = $reader->getString('email');
          $this->phoneNumber =  $reader->getString('phone_number');
          $this->createdDate = $reader->getString('created');
          $this->updatedDate = $reader->getString('updated');
          $this->companyId = $reader->getString('company_id');
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
    }
  }
}
