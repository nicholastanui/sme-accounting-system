<?php
namespace App\V1\Main;
use App\V1\Repository\EditRepository;
use App\V1\Exception\ValidationException;


class CustomerEditor
{

    protected $period;
    protected $customResponse;

    public function __construct(EditRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateCustomer(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library
        if (empty($data['id'])) {
            $errors['id'] = 'Input required';
        }
        if (empty($data['msisdn'])) {
            $errors['msisdn'] = 'Input required';
        }

       if (empty($data['first_name'])) {
            $errors['first_name'] = 'Input required';
         }
       if (empty($data['last_name'])) {
             $errors['last_name'] = 'Input required';
          }

        // elseif (filter_var($data['campaign_name'], FILTER_VALIDATE_TEXT) === false) {
        //      $errors['campaign_name'] = 'Invalid email address';
        //  }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
    public function editCustomer(array $data)
    {


      // Input validation
      $this->validateCustomer($data);

      $insertId=$this->repository->editCustomer($data);

      return $insertId;
    }



}
