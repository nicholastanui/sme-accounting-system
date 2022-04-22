<?php
namespace App\V1\Main;
use App\V1\Repository\EditRepository;
use App\V1\Exception\ValidationException;


class ProductEditor
{

    protected $period;
    protected $customResponse;

    public function __construct(EditRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateProduct(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library
        if (empty($data['id'])) {
            $errors['id'] = 'Input required';
        }
        if (empty($data['name'])) {
            $errors['name'] = 'Input required';
        }

        if (empty($data['sku'])) {
            $errors['sku'] = 'Input required';
        }
        if (empty($data['buying_price'])) {
            $errors['buying_price'] = 'Input required';
        }
        if (empty($data['supplier'])) {
            $errors['supplier'] = 'Input required';
        }

        if ($errors) {
          var_dump($errors);
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function editProduct(array $data)
    {


      // Input validation
      $this->validateProduct($data);

      $insertId=$this->repository->editProduct($data);

      return $insertId;
    }



}
