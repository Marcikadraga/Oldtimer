<?php

namespace app\model\forum;

use app\core\logger\SystemLog;
use app\model\BaseModel;
use app\model\topic\Topic;
use Exception;
use PDO;
use Throwable;

class ForumModel extends BaseModel {

    function getTopic($id): Forum|null {

        try {
            $query = ' SELECT * FROM topics WHERE id=? AND deleted_at IS NULL ';

            $statement = $this->pdo->prepare($query);
            $statement->execute([$id]);

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {

                return new Forum($result);
            }

        } catch (Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
        }
        return null;
    }


}
