<?php

namespace app\model\msgLike;

use app\core\logger\SystemLog;
use app\model\BaseModel;
use PDO;
use Throwable;

class MsgLikeModel extends BaseModel {

    function isliked($comment_id, $user_id): int {

        try {
            $query = 'SELECT * FROM msg_likes WHERE comment_id=? AND user_id=?';
            $params = [$comment_id, $user_id];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $statement->rowCount();

        } catch (Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
        }

        return 166;
    }


    /**
     * @param $comment_id
     * @return int[] userId lista
     */
    function whereLiked($comment_id): array {

        try {

            $query = 'SELECT user_id FROM msg_likes WHERE comment_id=:comment_id';
            $params = [
                'comment_id' => $comment_id,
            ];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);

            $result = [];
            foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row){
                $result[] = $row['user_id'];
            }

            return array_unique($result);

        } catch (Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
        }

        return [];
    }
}
