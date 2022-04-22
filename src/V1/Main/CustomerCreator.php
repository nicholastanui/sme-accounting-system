<?php
namespace App\V1\Main;
use App\V1\Repository\SKRepository;
use App\V1\Exception\ValidationException;


class CustomerCreator
{

    protected $user;
    protected $customResponse;

    public function __construct(SKRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateCustomer(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['msisdn'])) {
            $errors['msisdn'] = 'Input required';
        }

       if (empty($data['first_name'])) {
            $errors['business_name'] = 'Input required';
         }
       if (empty($data['last_name'])) {
             $errors['last_name'] = 'Input required';
          }
          if (empty($data['company'])) {
                $errors['company'] = 'Input required';
             }
        // elseif (filter_var($data['campaign_name'], FILTER_VALIDATE_TEXT) === false) {
        //      $errors['campaign_name'] = 'Invalid email address';
        //  }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function createCustomer(array $data)
    {
      // Input validation
      $this->validateCustomer($data);

      $insertId=$this->repository->createCustomer($data);

      return $insertId;
    }



}
