<?php

namespace App\Controllers;

use App\Repositories\PhotosRepository;

use App\Models\Photos;

class PhotosController
{
    // Images
    public function processPhoto(): void
    {

        //TODO: se o nome da foto ja existe no banco de dados ela nao deve ser inserida

        // This path refers to public, the folder that you required in the command php -S localhost:5500 -t public
        $destinyFolder = "./assets/projectPhotos/$_POST[projectIdPhoto]";
        if (!file_exists($destinyFolder)) {
            mkdir($destinyFolder, 0777, true);
        }

        $getId = new PhotosRepository();
        $lastPhotoId = $getId->lastPhotoId() + 1;
        $_FILES['projectPhoto']['name'] = $lastPhotoId. "_" . basename($_FILES['projectPhoto']['name']);

        $tempName = $_FILES['projectPhoto']['tmp_name'];
        $finalDestiny = $destinyFolder . "/" . $_FILES['projectPhoto']['name'];
        
        move_uploaded_file($tempName, $finalDestiny);

        $photos = new Photos($_FILES['projectPhoto']['name'], $finalDestiny, (int) $_POST["projectIdPhoto"]);

        $addPhoto = new PhotosRepository();
        $addPhoto->addProjectPhoto($photos);
    }

    public function showPhotos(int $projectId): array 
    {
        $photos = new PhotosRepository();
        return $photos->showProjectPhotos($projectId);
    }

    public function deletePhoto(string $imageSrc) 
    {
        $id = strpos(basename($imageSrc), "_");
        $photoId = (int) substr(basename($imageSrc), 0, $id);

        $deletePhoto = new PhotosRepository();
        $deletePhoto->deletePhoto($photoId);

        unlink(str_replace("http://localhost:5500", ".", $imageSrc));
    }
}