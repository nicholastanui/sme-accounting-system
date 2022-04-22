<?php
namespace App\V1\Main;
use App\V1\Repository\SKRepository;
use App\V1\Exception\ValidationException;


class AccountingPeriodSetter
{

    protected $period;
    protected $customResponse;

    public function __construct(SKRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validatePeriod(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['company_id'])) {
            $errors['company_id'] = 'Input required';
        }

        if (empty($data['period_id'])) {
            $errors['period_id'] = 'Input required';
        }


        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function setAccountingPeriod(array $data)
    {
      // Input validation
      $this->validatePeriod($data);

      $insertId=$this->repository->setAccountingPeriod($data);

      return $insertId;
    }



}
