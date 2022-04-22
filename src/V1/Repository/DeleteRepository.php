<?php
namespace App\V1\Repository;
use PDO;
use Cake\Chronos\Chronos;
use DomainException;
final class DeleteRepository {

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

    public function deletePeriod(int $id): int
    {
        try {
            $sql='DELETE FROM accounting_period WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
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
    public function deleteProduct(int $id): int
    {
        try {
            $sql='DELETE FROM products WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
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
    public function deleteService(int $id): int
    {
        try {
            $sql='DELETE FROM services WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
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
    public function deleteCustomerService(int $id): int
    {
        try {
            $sql='DELETE FROM company_services WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
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
    public function deleteSku(int $id): int
    {
        try {
            $sql='DELETE FROM skus WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
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
    public function deleteExpense(int $id): int
    {
        try {
            $sql='DELETE FROM expense_category WHERE id = :id';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
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
    public function deleteUser(int $id): int
    {
      $date=date('Y-m-d H:i:s');
      $data = [
            'active' => 0,
            'id' => $id,
            'updated'=>$date
          ];
        try {
            $sql='UPDATE users SET active =:active,updated=:updated WHERE id = :id';
            $sth =   $this->connection->prepare($sql);

            $sth->execute($data);
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

    public function deleteCompany(int $id): int
    {
          $date=date('Y-m-d H:i:s');
            $data = [
          'active' => 0,
          'id' => $id,
          'updated'=>$date
          ];
        try {
            $sql='UPDATE companies SET active =:active,updated=:updated WHERE id = :id';
            $sth =   $this->connection->prepare($sql);

            $sth->execute($data);
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
