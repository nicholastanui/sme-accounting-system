<?php
namespace App\V1\Main;
use App\V1\Repository\EditRepository;
use App\V1\Exception\ValidationException;


class ExpenseEditor
{

    protected $period;
    protected $customResponse;

    public function __construct(EditRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateExpense(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library
        if (empty($data['id'])) {
            $errors['id'] = 'Input required';
        }
        if (empty($data['name'])) {
            $errors['name'] = 'Input required';
        }


        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
    public function editExpense(array $data)
    {


      // Input validation
      $this->validateExpense($data);

      $insertId=$this->repository->editExpense($data);

      return $insertId;
    }



}
