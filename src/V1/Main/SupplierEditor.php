<?php
namespace App\V1\Main;
use App\V1\Repository\EditRepository;
use App\V1\Exception\ValidationException;


class SupplierEditor
{

    protected $period;
    protected $customResponse;

    public function __construct(EditRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateSupplier(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library
       if (empty($data['id'])) {
            $errors['id'] = 'Input required';
        }
       if (empty($data['phone_number'])) {
            $errors['phone_number'] = 'Input required';
        }

       if (empty($data['supplier_name'])) {
            $errors['supplier_name'] = 'Input required';
         }

       if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function editSupplier(array $data)
    {


      // Input validation
      $this->validateSupplier($data);

      $insertId=$this->repository->editSupplier($data);

      return $insertId;
    }



}
