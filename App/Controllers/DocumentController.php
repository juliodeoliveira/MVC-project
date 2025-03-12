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

    public function deleteDocuments(string $documentSrc)
    {        
        $id = strpos(basename($documentSrc), "_");
        $documentId = (int) substr(basename($documentSrc), 0, $id);

        $deleteDocuments = new DocumentRepository();
        $deleteDocuments->deletingDocuments($documentId);

        unlink(str_replace("http://localhost:5500", ".", $documentSrc));

        $this->deleteEmptyDirs("./assets/projectDocument");
    }

    public function deleteAllDocuments(int $folderId): void
    {   
        if (file_exists("./assets/projectDocuments/$folderId")) {
            $filesPath = array_diff(scandir("./assets/projectDocuments/$folderId"), array('.', '..'));
    
            foreach ($filesPath as $file) {
                unlink("./assets/projectDocuments/$folderId/".$file);
            }
            rmdir("./assets/projectDocuments/$folderId/");
        }
    }

    public function downloadDocument()
    {
        $path = $_GET['file'];
        $file = basename($_GET['file']);

        //TODO: apagar esses registros quando o projeto vencer
        //TODO: Transformar isso em um metodo do controller
        
        if (file_exists($path)) {
            header("Content-Description: File Transfer");
            header("Content-Type: aplication/octet-stream");
            header("Content-Disposition: attachment; filename=\"$file\" ");
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: " . filesize($path));
            readfile($path);
            exit;
        } else {
            http_response_code(404);
            require_once "../views/portal/notfound.php";
        }
    }
}