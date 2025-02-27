<?php
namespace App\Controllers;

use App\Repositories\DocumentRepository;
use App\Models\Document;

class DocumentController
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

    public function saveDocument() 
    {
        if (empty($_FILES['projectDocument']['name'])) {
            return;
        }

        // This path refers to public, the folder that you required in the command php -S localhost:5500 -t public
        $destinyFolder = "./assets/projectDocuments/$_POST[projectIdDocument]";
        if (!file_exists($destinyFolder)) {
            mkdir($destinyFolder, 0777, true);
        }

        $getId = new DocumentRepository();
        $lastDocumentId = $getId->lastDocumentId() + 1;
        $_FILES['projectDocument']['name'] = str_replace(" ", "_", $lastDocumentId. "_" . basename($_FILES['projectDocument']['name']));
        $_FILES['projectDocument']['name'] = $this->nameSanitizer($_FILES['projectDocument']['name']);

        $tempName = $_FILES['projectDocument']['tmp_name'];
        $finalDestiny = $destinyFolder . "/" . $_FILES['projectDocument']['name'];

        move_uploaded_file($tempName, $finalDestiny);

        $documentType = $_FILES['projectDocument']['type'];
        $document = new Document($_FILES['projectDocument']['name'], $finalDestiny, (int) $_POST["projectIdDocument"], $lastDocumentId, $documentType);

        $addDocument = new DocumentRepository();
        $addDocument->addProjectDocument($document);
    }

    public function showDocuments(int $projectId): array
    {
        $documents = new DocumentRepository();
        return $documents->showProjectDocuments($projectId);
    }
}