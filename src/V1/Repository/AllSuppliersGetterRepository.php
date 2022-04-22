<?php

namespace App\V1\Repository;
use App\V1\Data\SupplierData;
use PDO;

/**
 * Repository.
 */
final class AllSuppliersGetterRepository
{

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

    /**
     * Find users.
     *
     * @return CampaignGetterData[] A list of campaigns
     */
    public function findSuppliers($id): array
    {

      try {
            $sql='SELECT * FROM suppliers WHERE company_id=:company_id ORDER By id DESC';
            $sth =   $this->connection->prepare($sql);
            $sth->bindParam(':company_id',$id, PDO::PARAM_INT);
            $sth->execute();
            $suppliers = $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];

          // Convert to list of objects
          return $this->hydrate($suppliers,SupplierData::class);
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
    private function hydrate(array $rows, string $class): array
    {
        /** @var T[] $result */
        $result = [];

        foreach ($rows as $row) {

           $result[] = new $class($row,"all");
        }
//  var_dump($result);
        return $result;
    }
}
