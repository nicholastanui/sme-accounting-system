<?php
namespace App\V1\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class CompanyData
{
    public ?string $id = null;

    public ?string $businessName = null;

    public ?string $phoneNumber= null;

    public ?string $createdDate = null;

    public ?string $updatedDate = null;

    public ?string $location= null;

    public ?string $email = null;

    public ?string $lat = null;

    public ?string $lon = null;

    public ?string $active = null;
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
          $this->businessName = $value['business_name'];
          $this->phoneNumber = $value['phone_number'];
          $this->location = $value['location'];
          $this->createdDate =$value['created'];
          $this->updatedDate = $value['updated'];
          $this->email= $value['email'];
          $this->lat=$value['lat'];
          $this->lon=$value['lon'];
          $this->active=$value['active'];

        }
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
      }
      else
      {
          $reader = new ArrayReader($data);
          $this->id = $reader->getString('id');
          $this->businessName =  $reader->getString('business_name');
          $this->phoneNumber = $reader->getString('phone_number');
          $this->location =  $reader->getString('location');
          $this->createdDate = $reader->getString('created');
          $this->updatedDate =  $reader->getString('updated');
          $this->email=  $reader->getString('email');
          $this->lat=$reader->getString('lat');
          $this->lon=$reader->getString('lon');
          $this->active=$reader->getString('active');
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
    }
  }
}
