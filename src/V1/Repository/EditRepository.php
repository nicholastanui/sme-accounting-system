<?php
namespace App\V1\Repository;
use PDO;
use Cake\Chronos\Chronos;
use DomainException;
final class EditRepository {

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
    public function editAccountingPeriod(array $name): int
    {
      $today= date('Y-m-d H:i:s');
      $n=$name['name'];
      $id=preg_replace('/\s/', '',$name['id']);
      $row = [

        'name' => preg_replace('/\s/', '',$n),
        'id'=>$id,
        'selected'=>preg_replace('/\s/', '',$name['selected'])
    ];
    try {
        $sql='UPDATE accounting_period SET name =:name,selected=:selected WHERE id = :id';
        $sth =   $this->connection->prepare($sql);
        $sth->execute($row);
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

    public function editProduct(array $campaign): int
    {
      $today= date('Y-m-d H:i:s');
      $product_name=$campaign['name'];
    $row = [
        'id'=>preg_replace('/\s/', '',$campaign['id']),
        'product_name'=>$product_name,
        'sku_id' =>preg_replace('/\s/', '',$campaign['sku']),
        'buying_price' => preg_replace('/\s/', '',$campaign['buying_price']),
        'supplier_id' => preg_replace('/\s/', '',$campaign['supplier']),
        'updated'=>$today
      //  'image'=>$campaign['image']!=null?$campaign['image']:"",
      //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

    ];

    $sql = "UPDATE products SET
            product_name=:product_name,
            sku_id=:sku_id,
            buying_price=:buying_price,
            supplier_id=:supplier_id,
            updated=:updated
            WHERE id=:id
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
    public function editCustomer(array $campaign): int
    {
      $today= date('Y-m-d H:i:s');
      $msisdn=preg_replace('/\s/', '',$campaign['msisdn']);
      $first_name=preg_replace('/\s/', '',$campaign['first_name']);
    $row = [
      'id'=>preg_replace('/\s/', '',$campaign['id']),
        'msisdn' =>$msisdn,
        'first_name' => $first_name,
        'last_name' => preg_replace('/\s/', '',$campaign['last_name']),
        'updated' =>$today

      //  'image'=>$campaign['image']!=null?$campaign['image']:"",
      //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

    ];

    $sql = "UPDATE customers SET
            first_name=:first_name,
            last_name=:last_name,
            msisdn=:msisdn,
            updated=:updated
            WHERE id=:id
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
    public function editService(array $name): int
    {
      $today= date('Y-m-d H:i:s');
      $n=$name['name'];
      $row = [
        'id'=>preg_replace('/\s/', '',$name['id']),

        'service_name' => $n,
      //  'service_name' => preg_replace('/\s/', '',$n),
        'price' => preg_replace('/\s/', '',$name['price']),

    ];

    $sql = "UPDATE services SET
            service_name=:service_name,
            price=:price
            WHERE id=:id
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
    public function editSku(array $name): int
    {
      $today= date('Y-m-d H:i:s');
      $n=$name['name'];
      $row = [
        'id'=>preg_replace('/\s/', '',$name['id']),
        'unit' => preg_replace('/\s/', '',$n),


    ];

    $sql = "UPDATE skus SET
            unit=:unit
            WHERE id=:id
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
    public function editSupplier(array $campaign): int
    {
      $today= date('Y-m-d H:i:s');
      $msisdn=preg_replace('/\s/', '',$campaign['phone_number']);
      $supplier_name=preg_replace('/\s/', '',$campaign['supplier_name']);
      $row = [
        'id'=> preg_replace('/\s/', '',$campaign['id']),
        'phone_number' =>$msisdn,
        'supplier_name' => $supplier_name,
        'email' => isset($campaign['email'])?preg_replace('/\s/', '',$campaign['email']):"not set",

        //  'lat' => preg_replace('/\s/', '',$campaign['lat']),
        //'lon' => preg_replace('/\s/', '',$campaign['lon']),
        'updated' =>$today
      //  'image'=>$campaign['image']!=null?$campaign['image']:"",
      //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

    ];

    $sql = "UPDATE suppliers SET
            phone_number=:phone_number,
            supplier_name=:supplier_name,
            email=:email,
            updated=:updated
            WHERE id=:id
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
    public function editExpense(array $name): int
    {

      $n=$name['name'];
      $row = [
        'id'=>preg_replace('/\s/', '',$name['id']),
        'expense_name' =>$n


    ];

    $sql = "UPDATE expense_category SET
            expense_name=:expense_name
            WHERE id=:id
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
    public function editCompany(array $campaign): int
    {

      $today= date('Y-m-d H:i:s');
      $id=preg_replace('/\s/', '',$campaign['id']);
      $msisdn=preg_replace('/\s/', '',$campaign['msisdn']);
      $business_name=preg_replace('/\s/', '',$campaign['business_name']);
      $row = [
        'id'=>preg_replace('/\s/', '',$campaign['id']),
        'phone_number' =>$msisdn,
        'business_name' => $business_name,
        'location' => preg_replace('/\s/', '',$campaign['location']),
        'email' => preg_replace('/\s/', '',$campaign['email']),
        //  'lat' => preg_replace('/\s/', '',$campaign['lat']),
        //'lon' => preg_replace('/\s/', '',$campaign['lon']),
        'active'=>preg_replace('/\s/', '',$campaign['active']),
        'updated' =>$today
      //  'image'=>$campaign['image']!=null?$campaign['image']:"",
      //  'target_amount' => preg_replace('/\s/', '',$campaign['target_amount']),

        ];

    $sql = "UPDATE companies SET
            phone_number=:phone_number,
            business_name=:business_name,
            location=:location,
            email=:email,
            active=:active,
            updated=:updated
            WHERE id=:id
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
