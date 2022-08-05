<?php

namespace app\model\color;

use app\core\logger\SystemLog;
use app\model\BaseModel;
use Exception;
use PDO;

class ColorModel extends BaseModel {

    /**
     * @return Color[]
     */
    public function getAllColors(): array {

        try {
            $query = 'SELECT * FROM colors WHERE deleted_at IS NULL';

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
                $query = 'UPDATE colors SET deleted_at=:deleted_at WHERE id=:id';
                $params = [
                    'id'         => $color_id,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                $query = 'DELETE FROM colors WHERE id=?';
                $params = [$color_id];
            }

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'delete');
        }

        return false;
    }


    public function insertColor(Color $color): bool {

        try {
            $query = '
            INSERT INTO colors(name_of_color, rgb, created_at, updated_at, deleted_at)
            VALUES(:name_of_color,:rgb,:created_at,:updated_at,:deleted_at)';

            $params = [
                'name_of_color' => $color->getNameOfColor(),
                'rgb'           => $color->getRgb(),
                'created_at'    => $color->getCreatedAt(),
                'updated_at'    => $color->getUpdatedAt(),
                'deleted_at'    => $color->getDeletedAt()
            ];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $this->pdo->lastInsertId();

        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
    }


    public function getColorById($colorId) {

        try {
            $query = 'SELECT * FROM colors WHERE id=? AND deleted_at IS NULL LIMIT 1';
            $statement = $this->pdo->prepare($query);
            $statement->execute([$colorId]);
            return $statement->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
    }


    public function getById($colorId): ?Color {

        try {

            $query = 'SELECT * FROM colors WHERE id=? AND deleted_at IS NULL LIMIT 1';

            $statement = $this->pdo->prepare($query);
            $statement->execute([$colorId]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                return new Color($result);
            }

        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
        return null;
    }


    public function update(Color $color): bool {

        try {
            $query = '
            UPDATE colors
            SET name_of_color=:name_of_color,
                rgb=:rgb,
                created_at=:created_at,
                updated_at=:updated_at,
                deleted_at=:deleted_at

            
            WHERE id=:id';

            $params = [
                'id'            => $color->getId(),
                'name_of_color' => $color->getNameOfColor(),
                'rgb'           => $color->getRgb(),
                'created_at'    => $color->getCreatedAt(),
                'updated_at'    => $color->getUpdatedAt(),
                'deleted_at'    => $color->getDeletedAt()

            ];

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


}
