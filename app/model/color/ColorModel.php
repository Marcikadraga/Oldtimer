<?php

namespace app\model\color;

use app\model\BaseModel;
use Exception;
use PDO;

class ColorModel extends BaseModel {

    /**
     * @return Color[]
     */
    public function getAllColors(): array {

        try {
            $query = 'SELECT * FROM color WHERE deleted_at IS NULL';

            $colors = [];

            $statement = $this->pdo->prepare($query);
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                foreach ($result as $item) {
                    $colors[] = new Color($item);
                }
            }
            return $colors;
        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }

    public function delete($color_id, $softDelete = true): bool {

        try {

            if ($softDelete === true) {
                //TODO ,soft micsoda?
                $query = 'UPDATE color SET deleted_at=:deleted_at WHERE id=:id';
                $params = [
                    'id'         => $color_id,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                $query = 'DELETE FROM color WHERE id=?';
                $params = [$color_id];
            }

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'delete');
        }

        return false;
    }

}
