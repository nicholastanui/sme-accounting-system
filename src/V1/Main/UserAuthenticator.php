<?php

namespace App\V1\Main;
use App\V1\Repository\SKRepository;
use App\V1\Exception\ValidationException;


class UserAuthenticator
{

    protected $user;
    protected $customResponse;

    public function __construct(SKRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateUser(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['msisdn'])) {
            $errors['msisdn'] = 'Input required';
        }

       if (empty($data['first_name'])) {
            $errors['first_name'] = 'Input required';
         }
       if (empty($data['last_name'])) {
             $errors['last_name'] = 'Input required';
          }
       if (empty($data['password'])) {
              $errors['password'] = 'Input required';
           }
       if (empty($data['role'])) {
               $errors['role'] = 'Input required';
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
    private function validateCred(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['msisdn'])) {
            $errors['msisdn'] = 'Input required';
        }


       if (empty($data['password'])) {
              $errors['password'] = 'Input required';
           }
       // if (empty($data['end_date'])) {
       //         $errors['end_date'] = 'Input required';
       //      }

        //elseif (filter_var($data['campaign_name'], FILTER_VALIDATE_TEXT) === false) {
        //     $errors['campaign_name'] = 'Invalid email address';
        // }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
    public function createUser(array $data)
    {
      // Input validation
      $this->validateUser($data);

      $insertId=$this->repository->createUser($data);

      return $insertId;
    }


     public function loginUser(array $data){

       $this->validateCred($data);

       $insertId=$this->repository->loginUser($data);
       return $insertId;
     }

}
