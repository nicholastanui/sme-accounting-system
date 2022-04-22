<?php
namespace App\V1\Repository;
use App\V1\Data\UserData;
use App\V1\Data\CompanyData;
use App\V1\Data\PeriodData;
use App\V1\Data\SelectedPeriodData;
use App\V1\Data\CustomerData;
use App\V1\Data\SupplierData;
use App\V1\Data\SkuData;
use App\V1\Data\ServiceData;
use App\V1\Data\ProductData;
use PDO;
use Cake\Chronos\Chronos;
use DomainException;
final class SKRepository {

  /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function createUser(array $campaign): int
  {
      $today= date('Y-m-d H:i:s');
      $msisdn=preg_replace('/\s/', '',$campaign['msisdn']);
    $row = [
        'msisdn' =>$msisdn,
        'first_name' => preg_replace('/\s/', '',$campaign['first_name']),
        'last_name' => preg_replace('/\s/', '',$campaign['last_name']),
        'role' => preg_replace('/\s/', '',$campaign['role']),
        'company_id' => preg_replace('/\s/', '',$campaign['company_id']),
        'password' =>preg_replace('/\s/', '',$this->hashPassword($campaign['password'])),
        'created' =>$today,
        'updated' =>$today,
      //  'image'=>$campaign['image']!=null?$campaign['image']:"",
      //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

    ];
    if($this->existsUser($msisdn)){
      $result = (object)
        [
          'header'=>['responseCode'=>'401','responseMessage'=>'user already exists'],
          'body'=>[
            'data' =>'user already exists'
        ]

      ];

          echo json_encode($result);
    }else{
    $sql = "INSERT INTO users SET
            msisdn=:msisdn,
            first_name=:first_name,
            last_name=:last_name,
            password=:password,
            role=:role,
            company_id=:company_id,
            created=:created,
            updated=:updated
            ;";
            try {
                $this->connection->prepare($sql)->execute($row);

                return (int)$this->connection->lastInsertId();
              } catch( PDOException $e ) {
  // show error message as Json formatgetCampaignbyId
          $result = (object)
              [
                'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                'body'=>[
                        'data' => $e->getMessage()
                      ]
              ];

    echo json_encode($result);
              }
  }
  }
  public function hashPassword($password)
     {
         return password_hash($password,PASSWORD_DEFAULT);
     }

  public function existsUser($msisdn): bool
  {
    $sql='SELECT * FROM users WHERE msisdn = :msisdn';
    $sth =   $this->connection->prepare($sql);
    $sth->bindParam(':msisdn', $msisdn, PDO::PARAM_STR);
    $sth->execute();
    $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($campaign)){
      return false;
    }else{
      return true;
    }

  }
  public function existsCompany($business_name,$phone_number): bool
  {

    $sql='SELECT * FROM companies WHERE business_name = :business_name AND phone_number=:phone_number';
    $sth =   $this->connection->prepare($sql);
    $sth->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
    $sth->bindParam(':business_name', $business_name, PDO::PARAM_STR);
    $sth->execute();
    $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($campaign)){
      return false;
    }else{
      return true;
    }

  }


  public function createCompany(array $campaign): int
{
    $today= date('Y-m-d H:i:s');
    $msisdn=preg_replace('/\s/', '',$campaign['msisdn']);
    $business_name=$campaign['business_name'];
    $row = [
      'phone_number' =>$msisdn,
      'business_name' => $business_name,
      'location' => preg_replace('/\s/', '',$campaign['location']),
      'email' => preg_replace('/\s/', '',$campaign['email']),
      //  'lat' => preg_replace('/\s/', '',$campaign['lat']),
      //'lon' => preg_replace('/\s/', '',$campaign['lon']),
      'created' =>$today,
      'updated' =>$today,
    //  'image'=>$campaign['image']!=null?$campaign['image']:"",
    //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

  ];
  if($this->existsCompany($business_name,$msisdn)){
    $result = (object)
      [
        'header'=>['responseCode'=>'401','responseMessage'=>'company already exists'],
        'body'=>[
          'data' =>'Company already exists'
      ]

    ];

        echo json_encode($result);
    //    echo '{"error": {msg: company already exists! }';
  }else{
  $sql = "INSERT INTO companies SET
          phone_number=:phone_number,
          business_name=:business_name,
          location=:location,
          email=:email,

          created=:created,
          updated=:updated
          ;";
          try {
              $this->connection->prepare($sql)->execute($row);

              return (int)$this->connection->lastInsertId();
            } catch( PDOException $e ) {
// show error message as Json formatgetCampaignbyId
      $result = (object)
          [
              'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
              'body'=>[
                      'data' => $e->getMessage()
                    ]
            ];

  echo json_encode($result);
            }
}
}
public function getCompanyById($id):CompanyData
{
    try {
          $sql='SELECT * FROM companies WHERE id = :id';
          $sth =   $this->connection->prepare($sql);
          $sth->bindParam(':id', $id, PDO::PARAM_INT);
          $sth->execute();
          $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);


          return new CompanyData($campaign);
        } catch( PDOException $e ) {
            // show error message as Json format
            $result = (object)
                      [
                          'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                          'body'=>[
                                  'data' => $e->getMessage()
                                ]
                        ];

              echo json_encode($result);
          }
}
public function existsSupplier($msisdn): bool
{
  $sql='SELECT * FROM suppliers WHERE phone_number = :phone_number';
  $sth =   $this->connection->prepare($sql);
  $sth->bindParam(':phone_number', $msisdn, PDO::PARAM_STR);
  $sth->execute();
  $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
  if(empty($campaign)){
    return false;
  }else{
    return true;
  }

}
public function getSupplierById($id):SupplierData
{
    try {
          $sql='SELECT * FROM suppliers WHERE id = :id';
          $sth =   $this->connection->prepare($sql);
          $sth->bindParam(':id', $id, PDO::PARAM_INT);
          $sth->execute();
          $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);


          return new SupplierData($campaign);
        } catch( PDOException $e ) {
            // show error message as Json format
            $result = (object)
                      [
                          'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                          'body'=>[
                                  'data' => $e->getMessage()
                                ]
                        ];

              echo json_encode($result);
          }
}
public function createSupplier(array $campaign): int
{
  $today= date('Y-m-d H:i:s');
  $msisdn=preg_replace('/\s/', '',$campaign['phone_number']);
  $supplier_name=preg_replace('/\s/', '',$campaign['supplier_name']);
  $row = [
    'phone_number' =>$msisdn,
    'supplier_name' => $supplier_name,
    'email' => preg_replace('/\s/', '',$campaign['email']),
    'company_id'=> preg_replace('/\s/', '',$campaign['company']),
    //  'lat' => preg_replace('/\s/', '',$campaign['lat']),
    //'lon' => preg_replace('/\s/', '',$campaign['lon']),
    'created' =>$today,
    'updated' =>$today
  //  'image'=>$campaign['image']!=null?$campaign['image']:"",
  //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

];
if($this->existsSupplier($msisdn)){
  $result = (object)
    [
      'header'=>['responseCode'=>'401','responseMessage'=>'Supplier already exists'],
      'body'=>[
        'data' =>'Supplier already exists'
    ]

  ];

      echo json_encode($result);
}else{
$sql = "INSERT INTO suppliers SET
        phone_number=:phone_number,
        supplier_name=:supplier_name,
        email=:email,
        company_id=:company_id,
        created=:created,
        updated=:updated
        ;";
        try {
            $this->connection->prepare($sql)->execute($row);

            return (int)$this->connection->lastInsertId();
          } catch( PDOException $e ) {
// show error message as Json formatgetCampaignbyId
      $result = (object)
          [
              'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
              'body'=>[
                      'data' => $e->getMessage()
                    ]
            ];

  echo json_encode($result);
          }
}
}
public function getAccPeriodById($id):SelectedPeriodData
{
    try {
          $sql='SELECT accounting_period.name as name,selected_acc_period.period_id as id,selected_acc_period.company_id as company FROM accounting_period JOIN selected_acc_period on accounting_period.id=selected_acc_period.period_id WHERE selected_acc_period.company_id  = :company_id';
          $sth =   $this->connection->prepare($sql);
          $sth->bindParam(':company_id', $id, PDO::PARAM_INT);
          $sth->execute();
          $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
          return new SelectedPeriodData($campaign);
        } catch( PDOException $e ) {
            // show error message as Json format
            $result = (object)
                      [
                          'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                          'body'=>[
                                  'data' => $e->getMessage()
                                ]
                        ];

              echo json_encode($result);
          }
}
public function existsAccountingPeriod($name): bool
{

  $sql='SELECT * FROM accounting_period WHERE name = :name';
  $sth =   $this->connection->prepare($sql);
  $sth->bindParam(':name', $name, PDO::PARAM_STR);
  $sth->execute();
  $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
  if(empty($campaign)){
    return false;
  }else{
    return true;
  }

}
public function createAccountingPeriod(array $name): int
{
  $today= date('Y-m-d H:i:s');
  $n=$name['name'];
  $row = [

    'name' => preg_replace('/\s/', '',$n),


];
if($this->existsAccountingPeriod($n)){
  $result = (object)
    [
      'header'=>['responseCode'=>'401','responseMessage'=>'Accounting period already exists'],
      'body'=>[
        'data' =>'Accounting period already exists'
    ]

  ];

      echo json_encode($result);
    //  echo '{"error": {msg: accounting period already exists! }';
}else{
$sql = "INSERT INTO accounting_period SET
        name=:name

        ;";
        try {
            $this->connection->prepare($sql)->execute($row);

            return (int)$this->connection->lastInsertId();
          } catch( PDOException $e ) {
// show error message as Json formatgetCampaignbyId
$result = (object)
          [
              'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
              'body'=>[
                      'data' => $e->getMessage()
                    ]
            ];

  echo json_encode($result);
          }
}
}

public function existsCustomer($msisdn): bool
{

  $sql='SELECT * FROM customers  WHERE msisdn = :msisdn';
  $sth =   $this->connection->prepare($sql);
  $sth->bindParam(':msisdn', $msisdn, PDO::PARAM_STR);
  $sth->execute();
  $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
  if(empty($campaign)){
    return false;
  }else{
    return true;
  }

}
public function createCustomer(array $campaign): int
{
  $today= date('Y-m-d H:i:s');
  $msisdn=preg_replace('/\s/', '',$campaign['msisdn']);
  $first_name=preg_replace('/\s/', '',$campaign['first_name']);
$row = [
    'msisdn' =>$msisdn,
    'first_name' => $first_name,
    'last_name' => preg_replace('/\s/', '',$campaign['last_name']),
    'company_id'=> preg_replace('/\s/', '',$campaign['company']),
    'created' =>$today,
    'updated' =>$today
  //  'image'=>$campaign['image']!=null?$campaign['image']:"",
  //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

];
if($this->existsCustomer($msisdn)){
  $result = (object)
    [
      'header'=>['responseCode'=>'401','responseMessage'=>'Customer already exists'],
      'body'=>[
        'data' =>'Customer already exists'
    ]

  ];

      echo json_encode($result);
}else{
$sql = "INSERT INTO customers SET
        first_name=:first_name,
        last_name=:last_name,
        msisdn=:msisdn,
        company_id=:company_id,
        created=:created,
        updated=:updated
        ;";
        try {
            $this->connection->prepare($sql)->execute($row);

            return (int)$this->connection->lastInsertId();
          } catch( PDOException $e ) {
// show error message as Json formatgetCampaignbyId
      $result = (object)
          [
              'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
              'body'=>[
                      'data' => $e->getMessage()
                    ]
            ];

            echo json_encode($result);
          }
}
}
public function getCustomerbyId($id):CustomerData
{
    try {
          $sql='SELECT * FROM customers WHERE id = :id';
          $sth =   $this->connection->prepare($sql);
          $sth->bindParam(':id', $id, PDO::PARAM_INT);
          $sth->execute();
          $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);


          return new CustomerData($campaign);
        } catch( PDOException $e ) {
            // show error message as Json format
            $result = (object)
                      [
                          'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                          'body'=>[
                                  'data' => $e->getMessage()
                                ]
                        ];

              echo json_encode($result);
          }
}
  public function getUserbyId($id):UserData
  {
      try {
            $sql='SELECT * FROM users WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);


            return new UserData($campaign);
          } catch( PDOException $e ) {
              // show error message as Json format
              $result = (object)
                        [
                            'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                            'body'=>[
                                    'data' => $e->getMessage()
                                  ]
                          ];

                echo json_encode($result);
            }
  }

  public function loginUser(array $login):bool{

    $msisdn=preg_replace('/\s/', '',$login['msisdn']);
    $pass=preg_replace('/\s/', '',$login['password']);
  $row = [
      'msisdn' =>$msisdn,

    ];

    try {
          $sql='SELECT * FROM users WHERE msisdn = :msisdn';
          $sth =   $this->connection->prepare($sql);
          $sth->bindParam(':msisdn', $msisdn, PDO::PARAM_STR);
          $sth->execute();
          $campaign = $sth->fetch(PDO::FETCH_ASSOC);

          if(empty($campaign)){
              return false;

          }else{

            $hashedPassword = $campaign['password'];
            $verify = password_verify($pass,$hashedPassword);
            if($verify){
              return true;
            }else{

              return false;

            }

          }


        } catch( PDOException $e ) {
            // show error message as Json format
            $result = (object)
                      [
                          'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                          'body'=>[
                                  'data' => $e->getMessage()
                                ]
                        ];

              echo json_encode($result);
          }
  }
  public function existsSku($name): bool
  {
    $sql='SELECT * FROM skus WHERE unit = :unit';
    $sth =   $this->connection->prepare($sql);
    $sth->bindParam(':unit', $name, PDO::PARAM_STR);
    $sth->execute();
    $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($campaign)){
      return false;
    }else{
      return true;
    }

  }
  public function createSku(array $name): int
  {
    $today= date('Y-m-d H:i:s');
    $n=$name['name'];
    $row = [

      'unit' => preg_replace('/\s/', '',$n),


  ];
  if($this->existsSku($n)){
    $result = (object)
      [
        'header'=>['responseCode'=>'401','responseMessage'=>'Sku already exists'],
        'body'=>[
          'data' =>'Sku already exists'
      ]

    ];

        echo json_encode($result);
  }else{
  $sql = "INSERT INTO skus SET
          unit=:unit
          ;";
          try {
              $this->connection->prepare($sql)->execute($row);

              return (int)$this->connection->lastInsertId();
            } catch( PDOException $e ) {
  // show error message as Json formatgetCampaignbyId
        $result = (object)
            [
                'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                'body'=>[
                        'data' => $e->getMessage()
                      ]
              ];

    echo json_encode($result);
            }
  }
  }
  public function getSkuById($id):SkuData
  {
      try {
            $sql='SELECT * FROM skus WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);


            return new SkuData($campaign);
          } catch( PDOException $e ) {
              // show error message as Json format
              $result = (object)
                        [
                            'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                            'body'=>[
                                    'data' => $e->getMessage()
                                  ]
                          ];

                echo json_encode($result);
            }
  }
  public function existsService($name): bool
  {
    $sql='SELECT * FROM services WHERE service_name = :service_name';
    $sth =   $this->connection->prepare($sql);
    $sth->bindParam(':service_name', $name, PDO::PARAM_STR);
    $sth->execute();
    $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($campaign)){
      return false;
    }else{
      return true;
    }

  }
  public function createService(array $name): int
  {
    $today= date('Y-m-d H:i:s');
    $n=$name['name'];
    $row = [
      'service_name' => $n,
      'company_id' => preg_replace('/\s/', '',$name['company']),
      'price' => preg_replace('/\s/', '',$name['price']),

  ];
  if($this->existsService($n)){
    $result = (object)
      [
        'header'=>['responseCode'=>'401','responseMessage'=>'Service already exists'],
        'body'=>[
          'data' =>'Service already exists'
      ]

    ];

        echo json_encode($result);
  }else{
  $sql = "INSERT INTO services SET
          service_name=:service_name,
          price=:price,
          company_id=:company_id
          ;";
          try {
              $this->connection->prepare($sql)->execute($row);

              return (int)$this->connection->lastInsertId();
            } catch( PDOException $e ) {
  // show error message as Json formatgetCampaignbyId
  $result = (object)
            [
                'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                'body'=>[
                        'data' => $e->getMessage()
                      ]
              ];

    echo json_encode($result);
            }
  }
  }

  public function getServiceById($id):ServiceData
  {
      try {
            $sql='SELECT * FROM services WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);


            return new ServiceData($campaign);
          } catch( PDOException $e ) {
              // show error message as Json format
              $result = (object)
                        [
                            'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                            'body'=>[
                                    'data' => $e->getMessage()
                                  ]
                          ];

                echo json_encode($result);
            }
  }

  public function existsProduct($name): bool
  {
    $sql='SELECT * FROM products WHERE product_name = :product_name';
    $sth =   $this->connection->prepare($sql);
    $sth->bindParam(':product_name', $name, PDO::PARAM_STR);
    $sth->execute();
    $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($campaign)){
      return false;
    }else{
      return true;
    }

  }

  public function createProduct(array $campaign): int
  {
    $today= date('Y-m-d H:i:s');
    $product_name=$campaign['name'];
  $row = [
      'product_name'=>$product_name,
      'sku_id' =>preg_replace('/\s/', '',$campaign['sku']),
      'buying_price' => preg_replace('/\s/', '',$campaign['buying_price']),
      'supplier_id' => preg_replace('/\s/', '',$campaign['supplier']),
      'company_id' => preg_replace('/\s/', '',$campaign['company']),
      'created' =>$today,
      'updated'=>$today
    //  'image'=>$campaign['image']!=null?$campaign['image']:"",
    //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

  ];
  if($this->existsProduct($product_name)){
    $result = (object)
      [
        'header'=>['responseCode'=>'401','responseMessage'=>'Product already exists'],
        'body'=>[
          'data' =>'Product already exists'
      ]

    ];

        echo json_encode($result);
  }else{
  $sql = "INSERT INTO products SET
          product_name=:product_name,
          sku_id=:sku_id,
          buying_price=:buying_price,
          supplier_id=:supplier_id,
          company_id=:company_id,
          created=:created,
          updated=:updated
          ;";
          try {
              $this->connection->prepare($sql)->execute($row);

              return (int)$this->connection->lastInsertId();
            } catch( PDOException $e ) {
  // show error message as Json formatgetCampaignbyId
  $result = (object)
            [
                'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                'body'=>[
                        'data' => $e->getMessage()
                      ]
              ];

    echo json_encode($result);
            }
  }
  }
  public function getProductById($id):ProductData
  {
      try {
            $sql='SELECT * FROM products WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);


            return new ProductData($campaign);
          } catch( PDOException $e ) {
              // show error message as Json format
              $result = (object)
                        [
                            'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                            'body'=>[
                                    'data' => $e->getMessage()
                                  ]
                          ];

                echo json_encode($result);
            }
  }
  public function isSetPeriod($acc,$com): bool
  {

    $sql='SELECT * FROM selected_acc_period WHERE company_id = :company_id AND period_id=:period_id';
    $sth =   $this->connection->prepare($sql);
    $sth->bindParam(':company_id', $com, PDO::PARAM_STR);
    $sth->bindParam(':period_id', $acc, PDO::PARAM_STR);
    $sth->execute();
    $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($campaign)){
      return false;
    }else{
      return true;
    }

  }
  public function setAccountingPeriod(array $name): int
  {
    $today= date('Y-m-d H:i:s');
    $p=preg_replace('/\s/', '',$name['period_id']);

    $c=preg_replace('/\s/', '',$name['company_id']);
    $row = [

      'period_id' => preg_replace('/\s/', '',$p),
      'company_id' => preg_replace('/\s/', '',$c),
      ];
    if($this->isSetPeriod($p,$c)){

      $this->deletePeriod($c);//delete the selected period and recreate

      $sql = "INSERT INTO selected_acc_period SET
              company_id=:company_id,
              period_id=:period_id

              ;";
              try {
                  $this->connection->prepare($sql)->execute($row);

                  return (int)$this->connection->lastInsertId();
                } catch( PDOException $e ) {
      // show error message as Json formatgetCampaignbyId
      $result = (object)
                [
                    'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                    'body'=>[
                            'data' => $e->getMessage()
                          ]
                  ];

        echo json_encode($result);
                }
  }else{
          $sql = "INSERT INTO selected_acc_period SET
          company_id=:company_id,
          period_id=:period_id

          ;";
          try {
              $this->connection->prepare($sql)->execute($row);

              return (int)$this->connection->lastInsertId();
            } catch( PDOException $e ) {
  // show error message as Json formatgetCampaignbyId
          $result = (object)
            [
                'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                'body'=>[
                        'data' => $e->getMessage()
                      ]
              ];

    echo json_encode($result);
            }
     }
  }
  private function deletePeriod($company){
    try {
        $sql='DELETE FROM selected_acc_period WHERE company_id = :company_id';
        $sth =   $this->connection->prepare($sql);
        $sth->bindParam(':company_id', $company, PDO::PARAM_INT);
        $sth->execute();
        $count = $sth->rowCount();
        return $count;
      } catch( PDOException $e ) {
    // show error message as Json format
    $result = (object)
              [
                  'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                  'body'=>[
                          'data' => $e->getMessage()
                        ]
                ];

      echo json_encode($result);
      }
  }
  public function createExpenseEntry(array $campaign): int
  {
    $today= date('Y-m-d H:i:s');
    $expense=preg_replace('/\s/', '',$campaign['expense_id']);
    $amount=preg_replace('/\s/', '',$campaign['amount']);
  $row = [
      'expense_id' =>$expense,
      'amount' => $amount,
      'accounting_period' => preg_replace('/\s/', '',$campaign['accounting_period']),
      'company_id'=> preg_replace('/\s/', '',$campaign['company_id']),
      'expense_date' =>$today

    //  'image'=>$campaign['image']!=null?$campaign['image']:"",
    //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

  ];

  $sql = "INSERT INTO expenses SET
          expense_id=:expense_id,
          amount=:amount,
          accounting_period=:accounting_period,
          company_id=:company_id,
          expense_date=:expense_date
          ;";
          try {
              $this->connection->prepare($sql)->execute($row);

              return (int)$this->connection->lastInsertId();
            } catch( PDOException $e ) {
  // show error message as Json formatgetCampaignbyId
            $result = (object)
                [
                'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                'body'=>[
                        'data' => $e->getMessage()
                      ]
                    ];

    echo json_encode($result);
            }

  }
  public function existsExpense($name): bool
  {
    $sql='SELECT * FROM expense_category WHERE expense_name = :expense_name';
    $sth =   $this->connection->prepare($sql);
    $sth->bindParam(':expense_name', $name, PDO::PARAM_STR);
    $sth->execute();
    $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($campaign)){
      return false;
    }else{
      return true;
    }

  }
  public function createExpense(array $name): int
  {

    $n=$name['name'];
    $row = [
      'expense_name' => $n

  ];
  if($this->existsExpense($n)){
    $result = (object)
      [
        'header'=>['responseCode'=>'401','responseMessage'=>'Expense already exists'],
        'body'=>[
          'data' =>'Expense already exists'
      ]

    ];

        echo json_encode($result);
  }else{
  $sql = "INSERT INTO expense_category SET
          expense_name=:expense_name
          ;";
          try {
              $this->connection->prepare($sql)->execute($row);

              return (int)$this->connection->lastInsertId();
            } catch( PDOException $e ) {
  // show error message as Json formatgetCampaignbyId
        $result = (object)
              [
                'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                'body'=>[
                        'data' => $e->getMessage()
                      ]
                    ];

                    echo json_encode($result);
            }
  }
  }

  public function isSetService($acc,$com): bool
  {

    $sql='SELECT * FROM company_services WHERE company_id = :company_id AND service_id=:service_id';
    $sth =   $this->connection->prepare($sql);
    $sth->bindParam(':company_id', $com, PDO::PARAM_STR);
    $sth->bindParam(':service_id', $acc, PDO::PARAM_STR);
    $sth->execute();
    $campaign = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($campaign)){
      return false;
    }else{
      return true;
    }

  }
  public function createCustomerService(array $name): int
  {
    $today= date('Y-m-d H:i:s');
    $p=preg_replace('/\s/', '',$name['service']);

    $c=preg_replace('/\s/', '',$name['company']);
    $row = [
      'price' => preg_replace('/\s/', '',$name['price']),
      'service_id' => preg_replace('/\s/', '',$p),
      'company_id' => preg_replace('/\s/', '',$c),
      ];
    if($this->isSetService($p,$c)){

      $this->deleteService($c,$p);//delete the service and recreate

      $sql = "INSERT INTO company_services SET
              company_id=:company_id,
              service_id=:service_id,
              price=:price

              ;";
              try {
                  $this->connection->prepare($sql)->execute($row);

                  return (int)$this->connection->lastInsertId();
                } catch( PDOException $e ) {
      // show error message as Json formatgetCampaignbyId
              $result = (object)
                [
                    'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                    'body'=>[
                            'data' => $e->getMessage()
                          ]
                  ];

                  echo json_encode($result);
                }
              }else{
                  $sql = "INSERT INTO company_services SET
                  company_id=:company_id,
                  service_id=:service_id,
                  price=:price
                  ;";
                  try {
                      $this->connection->prepare($sql)->execute($row);

                      return (int)$this->connection->lastInsertId();
                    } catch( PDOException $e ) {
  // show error message as Json formatgetCampaignbyId
                  $result = (object)
                            [
                                'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
                                'body'=>[
                                        'data' => $e->getMessage()
                                      ]
                              ];

                    echo json_encode($result);
              }
     }
  }
  private function deleteService($company,$service){
    try {
        $sql='DELETE FROM company_services WHERE company_id = :company_id AND service_id=:service_id';
        $sth =   $this->connection->prepare($sql);
        $sth->bindParam(':company_id', $company, PDO::PARAM_INT);
        $sth->bindParam(':service_id', $service, PDO::PARAM_INT);
        $sth->execute();
        $count = $sth->rowCount();
        return $count;
      } catch( PDOException $e ) {
    // show error message as Json format
    $result = (object)
      [
        'header'=>['responseCode'=>'401','responseMessage'=> $e->getMessage()],
        'body'=>[
          'data' => $e->getMessage()
      ]

    ];

        echo json_encode($result);

      }
  }
}
