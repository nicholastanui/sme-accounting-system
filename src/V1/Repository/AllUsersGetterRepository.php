<?php

namespace App\V1\Repository;
use App\V1\Data\UserData;
use PDO;

/**
 * Repository.
 */
final class AllUsersGetterRepository
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
    public function findUsers(): array
    {
      try {
            $sql='SELECT * FROM users ORDER By id DESC';
            $sth =   $this->connection->prepare($sql);
            $sth->execute();
            $users = $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];

          // Convert to list of objects
          return $this->hydrate($users,UserData::class);
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
