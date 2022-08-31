<?php

namespace app\model\comment;

use app\model\BaseModel;
use Exception;
use PDO;

class CommentModel extends BaseModel {

    function getAllComments(): array {

        try {
            $query = 'SELECT * FROM comments WHERE deleted_at IS NULL';

            $comments = [];

            $statemenet = $this->pdo->prepare($query);
            $statemenet->execute();

            $result = $statemenet->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                foreach ($result as $item) {
                    $comments[] = new Comment($item);
                }
            }
            return $comments;

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    function getCommentsById($id): array {

        try {
            $query = 'SELECT * FROM comments WHERE topic_id =? AND deleted_at IS NULL';
            $params = [$id];
            $comments = [];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                foreach ($result as $item) {
                    $comments[] = new Comment($item);
                }
            }
            return $comments;

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }

}
