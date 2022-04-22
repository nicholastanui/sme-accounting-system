<?php
namespace App\V1\Main;
use App\V1\Repository\SKRepository;
use App\V1\Exception\ValidationException;


class CompanyServiceCreator
{

    protected $user;
    protected $customResponse;

    public function __construct(SKRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateCustomerService(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['company'])) {
            $errors['company'] = 'Input required';
        }

       if (empty($data['service'])) {
            $errors['service'] = 'Input required';
         }
       if (empty($data['price'])) {
             $errors['price'] = 'Input required';
          }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function createCustomerService(array $data)
    {
      // Input validation
      $this->validateCustomerService($data);

      $insertId=$this->repository->createCustomerService($data);

      return $insertId;
    }



}
