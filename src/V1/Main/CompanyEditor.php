<?php
namespace App\V1\Main;
use App\V1\Repository\EditRepository;
use App\V1\Exception\ValidationException;


class CompanyEditor
{

    protected $user;
    protected $customResponse;

    public function __construct(EditRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateCompany(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['msisdn'])) {
            $errors['msisdn'] = 'Input required';
        }

       if (empty($data['business_name'])) {
            $errors['business_name'] = 'Input required';
         }
       if (empty($data['location'])) {
             $errors['location'] = 'Input required';
          }
       if (empty($data['email'])) {
              $errors['email'] = 'Input required';
           }
           if (empty($data['active'])) {
                  $errors['active'] = 'Input required';
               }

        // elseif (filter_var($data['campaign_name'], FILTER_VALIDATE_TEXT) === false) {
        //      $errors['campaign_name'] = 'Invalid email address';
        //  }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function editCompany(array $data)
    {
      // Input validation
      $this->validateCompany($data);

      $insertId=$this->repository->editCompany($data);

      return $insertId;
    }



}
