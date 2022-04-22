<?php
namespace App\V1\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class SkuData
{
    public ?string $id = null;

    public ?string $unit = null;


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
          $this->unit = $value['unit'];

        }
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
      }
      else
      {
          $reader = new ArrayReader($data);
          $this->id = $reader->getString('id');
          $this->unit =  $reader->getString('unit');

      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
    }
  }
}
