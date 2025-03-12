<?php
namespace App\Repositories;

use App\Connection;
use App\Models\Photos;
use PDO;

class PhotosRepository
{
    private $connection;

    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->connect();
    }

    public function addProjectPhoto(Photos $photos): void 
    {
        $add = $this->connection->prepare("INSERT INTO project_pictures (id, project_id, photo_name, photo_description, photo_path) VALUES (:id, :projectId, :photoName, :photoDescription, :photoPath);");
        $add->bindValue(":id", $photos->getPhotoId());
        $add->bindValue(":projectId", $photos->getProjectId());
        $add->bindValue(":photoName", $photos->getPhotoName());
        $add->bindValue(":photoDescription", $photos->getPhotoName());
        $add->bindValue(":photoPath", $photos->getNewPhotoPath());
        $add->execute();
    }

    public function showProjectPhotos(int $projectId)
    {
        $search = $this->connection->prepare("SELECT * FROM project_pictures WHERE project_id = :projectId");
        $search->bindValue(":projectId", $projectId);
        $search->execute();
        $result = $search->fetchAll(PDO::FETCH_ASSOC);

        $photosObject = [];
        foreach ($result as $photo) {
            $newPhoto = new Photos($photo["photo_name"], $photo["photo_path"], (int) $photo["project_id"], (int) $photo["id"]);
            $photosObject[] = $newPhoto;
        }

        return $photosObject;
    }

    public function lastPhotoId()
    {
        $lastId = $this->connection->prepare("SELECT id FROM project_pictures ORDER BY id DESC LIMIT 1");
        $lastId->execute();
        $result = $lastId->fetchColumn();
        return $result;
    }

    public function deletingPhoto(int $photoId)
    {        
        $delete = $this->connection->prepare("DELETE FROM project_pictures WHERE id = :id");
        $delete->bindValue(":id", $photoId);
        $delete->execute();
        
        $checkId = "SELECT COUNT(*) AS total FROM project_pictures";
        $stmt = $this->connection->query($checkId);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['total'] == 0) {
            $resetId = "ALTER TABLE project_pictures AUTO_INCREMENT = 1";
            $this->connection->exec($resetId);
        } 
    }
}