<?php

namespace app\model\comment;

use app\core\logger\SystemLog;
use app\model\BaseModel;
use Exception;
use PDO;

class CommentModel extends BaseModel {

    function getCommentById($commentId) {

        try {
            $query = 'SELECT * FROM comments WHERE id=? AND deleted_at IS NULL LIMIT 1';
            $statement = $this->pdo->prepare($query);
            $statement->execute([$commentId]);
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
    }

    function getById($commentId): ?Comment {

        try {
            $query = 'SELECT * FROM comments WHERE id=? AND deleted_at IS NULL LIMIT 1';
            $statement = $this->pdo->prepare($query);
            $statement->execute([$commentId]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                return new Comment($result);
            }

        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
        return null;
    }

    function getComments($id): array {

        try {
            $query = "
                SELECT c.*,
                CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS real_name
                FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE topic_id=?
                ORDER BY id DESC;";

            $params = [$id];
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
//    /**
//     * @param $topicId
//     * @param $userId
//     * @return Comment[] ami ki van egészítve az isLiked
//     */
//    function getLikedComments($topicId, $userId): array {
//
//        try {
//            $query = "
//            SELECT c.*,
//                   CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS real_name,
//                   if(ml.id IS NULL, 0, 1) as is_liked
//            FROM comments c
//                     LEFT JOIN users u ON c.user_id = u.id
//                     LEFT JOIN msg_likes ml ON c.id = ml.comment_id and ml.user_id=:user_id
//            WHERE topic_id=:topic_id
//            ORDER BY id DESC";
//
//            $params = [
//                'topic_id'=>$topicId,
//                'user_id'=>$userId,
//            ];
//
//            $statement = $this->pdo->prepare($query);
//            $statement->execute($params);
//            $comments = [];
//            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
//
//            if (!empty($result)) {
//                foreach ($result as $item) {
//                    $comments[] = new Comment($item);
//                }
//            }
//            return $comments;
//
//        } catch (Exception $exception) {
//            die($exception->getMessage());
//        }
//    }

    /**
     * @param $topicId
     * @param $userId
     * @return Comment[] ami ki van egészítve az isLiked
     */

    //
    function getComment($topicId, $userId): array {

        try {
            $query = "
            SELECT c.*,
                   CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS real_name,
                   if(ml.id IS NULL, 0, 1) as is_liked
            FROM comments c
                     LEFT JOIN users u ON c.user_id = u.id
                     LEFT JOIN msg_likes ml ON c.id = ml.comment_id and ml.user_id=:user_id
            WHERE topic_id=:topic_id
            ORDER BY id DESC";

            $params = [
                'topic_id'=>$topicId,
                'user_id'=>$userId,
            ];

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
        WHERE topic_id=? AND deleted_at IS NULL ;
        ";
        $params = [$id];
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return !empty($result) ? $result['count'] : 0;
    }

    function delete($comment_id, $softDelete = true): bool {

        try {
            if ($softDelete === true) {
                $query = 'UPDATE comments SET deleted_at=:deleted_at WHERE id=:id';
                $params = [
                    'id'         => $comment_id,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                $query = 'DELETE FROM cars WHERE id=?';
                $params = [$comment_id];
            }
            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'delete');
        }
        return false;
    }

    function update(Comment $comment): bool {

        try {
            $query = '
            UPDATE comments
            SET message=:message
            WHERE id=:id';

            $params = [
                'id'=> $comment->getId(),
                'message' => $comment->getMessage()
            ];

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }
}
