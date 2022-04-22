<?php
namespace App\V1\Main;
use App\V1\Repository\SKRepository;
use App\V1\Exception\ValidationException;


class SupplierCreator
{

    protected $supplier;
    protected $customResponse;

    public function __construct(SKRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateSupplier(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['phone_number'])) {
            $errors['phone_number'] = 'Input required';
        }

       if (empty($data['supplier_name'])) {
            $errors['supplier_name'] = 'Input required';
         }

         if (empty($data['company'])) {
               $errors['company'] = 'Input required';
            }
        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function createSupplier(array $data)
    {
      // Input validation
      $this->validateSupplier($data);

      $insertId=$this->repository->createSupplier($data);

      return $insertId;
    }



}
