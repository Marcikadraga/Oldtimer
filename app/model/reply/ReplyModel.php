<?php

namespace app\model\reply;

use app\core\logger\SystemLog;
use app\model\BaseModel;
use Exception;
use PDO;

class ReplyModel extends BaseModel {

    function getAllreply($id): array {

        try {
            $query = 'SELECT * FROM replys WHERE comment_id=:comment_id';

            $params = [
                'comment_id' => $id
            ];
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);

            $replys = [];
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                foreach ($result as $item) {
                    $replys[] = new Reply($item);
                }
            }
            return $replys;

        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
    }


    function getReplysLength($commentId) {

        try {

            $query = 'SELECT COUNT(reply) AS count FROM replys WHERE comment_id=:comment_id AND deleted_at IS NULL ';

            $params = [
                'comment_id' => $commentId,
            ];


            $statement = $this->pdo->prepare($query);
            $statement->execute($params);

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result["count"];



        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
    }

}
