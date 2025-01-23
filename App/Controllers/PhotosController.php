<?php

namespace App\Controllers;

use App\Repositories\PhotosRepository;

use App\Models\Photos;

class PhotosController
{
    private function nameSanitizer($fileName)
    {
        $map = [
            'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
            'Á' => 'A', 'À' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'Í' => 'I', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
            'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'Ç' => 'C', 'Ñ' => 'N'
        ];
        
        return strtr($fileName, $map);
    }

    private function deleteEmptyDirs($dir, $rootDir = "./assets/projectPhotos") {
        if (!is_dir($dir)) {
            return;
        }
    
        $items = scandir($dir);
        $items = array_diff($items, array('.', '..'));
    
        foreach ($items as $item) {
            $path = $dir . DIRECTORY_SEPARATOR . $item;
    
            if (is_dir($path)) {
                $this->deleteEmptyDirs($path, $rootDir);
            }
        }
    
        // Reescaneia os itens restantes após tentar remover subdiretórios
        $remainingItems = array_diff(scandir($dir), array('.', '..'));
    
        // Só tenta remover o diretório se ele não for o diretório raiz
        if (empty($remainingItems) && $dir !== $rootDir) {
            rmdir($dir);
            echo "Diretório vazio removido: $dir\n";
        }
    }


    public function processPhoto(): void
    {
        if (empty($_FILES['projectPhoto']['name'])) {
            return;
        }
        
        // This path refers to public, the folder that you required in the command php -S localhost:5500 -t public
        $destinyFolder = "./assets/projectPhotos/$_POST[projectIdPhoto]";
        if (!file_exists($destinyFolder)) {
            mkdir($destinyFolder, 0777, true);
        }

        $getId = new PhotosRepository();
        $lastPhotoId = $getId->lastPhotoId() + 1;
        $_FILES['projectPhoto']['name'] = str_replace(" ", "_", $lastPhotoId. "_" . basename($_FILES['projectPhoto']['name']));
        $_FILES['projectPhoto']['name'] = $this->nameSanitizer($_FILES['projectPhoto']['name']);

        $tempName = $_FILES['projectPhoto']['tmp_name'];
        $finalDestiny = $destinyFolder . "/" . $_FILES['projectPhoto']['name'];
        
        move_uploaded_file($tempName, $finalDestiny);

        $photos = new Photos($_FILES['projectPhoto']['name'], $finalDestiny, (int) $_POST["projectIdPhoto"], $lastPhotoId);

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

        $deletePhotos = new PhotosRepository();
        $deletePhotos->deletingPhoto($photoId);

        unlink(str_replace("http://localhost:5500", ".", $imageSrc));

        $this->deleteEmptyDirs("./assets/projectPhotos");
    }
}