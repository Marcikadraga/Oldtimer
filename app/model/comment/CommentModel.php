<?php

namespace app\model\comment;

use app\core\logger\SystemLog;
use app\model\BaseModel;
use Exception;
use PDO;

class CommentModel extends BaseModel {

    function getComments($id): array {

        try {
            $query = "
                SELECT c.*,
                CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS real_name
                FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE topic_id=?;";
            $params=[$id];
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $comments = [];
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


    function insert(Comment $comment) {

        try {
            $query = '
            INSERT INTO comments(topic_id,user_id,message, created_at, updated_at, deleted_at)
            VALUES(:topic_id,:user_id,:message,:created_at,:updated_at,:deleted_at)';

            $params = [
                'topic_id'   => $comment->getTopicId(),
                'user_id'    => $comment->getUserId(),
                'message'    => $comment->getMessage(),
                'created_at' => $comment->getCreatedAt(),
                'updated_at' => $comment->getUpdatedAt(),
                'deleted_at' => $comment->getDeletedAt()

            ];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            //            return $this->pdo->lastInsertId();

        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
    }


    function getNumberOfComments($id) {

        $query = "
        SELECT COUNT(message) AS count
        FROM comments 
        WHERE topic_id=?;
        ";
        $params=[$id];
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return !empty($result) ? $result['count'] : 0;
    }

}
