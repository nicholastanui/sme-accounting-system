<?php
namespace App\V1\Main;
use App\V1\Repository\EditRepository;
use App\V1\Exception\ValidationException;


class AccountingPeriodEditor
{

    protected $period;
    protected $customResponse;

    public function __construct(EditRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validatePeriod(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['name'])) {
            $errors['name'] = 'Input required';
        } if (empty($data['id'])) {
            $errors['id'] = 'Input required';
        } if (empty($data['selected'])) {
            $errors['selected'] = 'Input required';
        }
        if ($errors) {
      
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function editAccountingPeriod(array $data)
    {


      // Input validation
      $this->validatePeriod($data);

      $insertId=$this->repository->editAccountingPeriod($data);

      return $insertId;
    }



}
