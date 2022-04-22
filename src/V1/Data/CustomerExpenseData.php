<?php
namespace App\V1\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class CustomerExpenseData
{
    public ?string $id = null;

    public ?string $expenseId = null;

    public ?string $companyId= null;

    public ?string $accoutingPeriod= null;

    public ?string $expenseDate= null;

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
          $this->expenseId = $value['expense_id'];
          $this->companyId =$value['company_id'];
          $this->accoutingPeriod =$value['accounting_period'];
          $this->expenseDate =$value['expense_date'];

        }

      }
      else
      {
          $reader = new ArrayReader($data);
          $this->id = $reader->getString('id');
          $this->expenseId =  $reader->getString('expense_id');
          $this->companyId = $reader->getString('company_id');
          $this->accoutingPeriod =$reader->getString('accounting_period');
          $this->expenseDate =$reader->getString('expense_date');
      //  var_dump($reader);
      //  $this->id = $reader->getInt('id');
    }
  }
}
