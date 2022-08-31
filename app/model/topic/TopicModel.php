<?php

namespace app\model\topic;

use app\model\BaseModel;
use Exception;
use PDO;

class TopicModel extends BaseModel {

    function GetAllTopics(): array {

        try {

            $query = 'SELECT * FROM topics WHERE deleted_at IS NULL';
            $topics = [];

            $statement = $this->pdo->prepare($query);
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                foreach ($result as $item) {
                    $topics[] = new Topic($item);
                }
            }
            return $topics;

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }

}
