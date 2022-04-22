<?php
namespace App\V1\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class SelectedPeriodData
{
    public ?string $id = null;

    public ?string $name = null;

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
          $this->name = $value['name'];
          $this->companyId =$value['company'];

        }
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
      }
      else
      {
          $reader = new ArrayReader($data);
          $this->id = $reader->getString('id');
          $this->name =  $reader->getString('name');
          $this->companyId = $reader->getString('company');
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
    }
  }
}
