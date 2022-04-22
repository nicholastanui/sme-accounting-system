<?php
namespace App\V1\Main;
use App\V1\Repository\SKRepository;
use App\V1\Exception\ValidationException;


class ExpenseEntryCreator
{

    protected $user;
    protected $customResponse;

    public function __construct(SKRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateExpense(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['expense_id'])) {
            $errors['expense_id'] = 'Input required';
        }

       if (empty($data['amount'])) {
            $errors['amount'] = 'Input required';
         }
       if (empty($data['accounting_period'])) {
             $errors['accounting_period'] = 'Input required';
          }
          if (empty($data['company_id'])) {
                $errors['company_id'] = 'Input required';
             }
        // elseif (filter_var($data['campaign_name'], FILTER_VALIDATE_TEXT) === false) {
        //      $errors['campaign_name'] = 'Invalid email address';
        //  }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function createExpense(array $data)
    {
      // Input validation
      $this->validateExpense($data);

      $insertId=$this->repository->createExpenseEntry($data);

      return $insertId;
    }



}
