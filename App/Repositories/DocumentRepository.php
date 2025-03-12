<?php
namespace App\Repositories;

use App\Models\Document;
use App\Connection;
use PDO;

class DocumentRepository
{
    private $connection;

    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->connect();
    }

    public function lastDocumentId()
    {
        $lastId = $this->connection->prepare("SELECT docs_id FROM project_documents ORDER BY docs_id DESC LIMIT 1");
        $lastId->execute();
        $result = $lastId->fetchColumn();
        return $result;
    }

    public function addProjectDocument(Document $document)
    {
        $add = $this->connection->prepare("INSERT INTO project_documents (docs_id, document_project_id, document_name, document_type, document_path) VALUES (:docsId, :documentProjectId, :documentName, :documentType, :documentPath);");
        $add->bindValue(":docsId", $document->getDocumentId());
        $add->bindValue(":documentProjectId", $document->getProjectId());
        $add->bindValue(":documentName", $document->getDocumentName());
        $add->bindValue(":documentType", $document->getDocumentType());
        $add->bindValue(":documentPath", $document->getNewDocumentPath());
        $add->execute();
    }

    public function showProjectDocuments(int $projectId)
    {
        $search = $this->connection->prepare("SELECT docs_id, document_project_id, document_name, document_type, document_path FROM project_documents WHERE document_project_id = :projectId");
        $search->bindValue(":projectId", $projectId);
        $search->execute();
        $result = $search->fetchAll(PDO::FETCH_ASSOC);

        $documents = [];
        foreach ($result as $row) {
            $doc = new Document($row["document_name"], $row["document_path"], $row["document_project_id"], $row["docs_id"], $row["document_type"]);

            $documents[] = $doc;
        }

        return $documents;
    }

    public function deletingDocuments(int $documentId)
    {        
        $delete = $this->connection->prepare("DELETE FROM project_documents WHERE id = :id");
        $delete->bindValue(":id", $documentId);
        $delete->execute();
        
        $checkId = "SELECT COUNT(*) AS total FROM project_documents";
        $stmt = $this->connection->query($checkId);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['total'] == 0) {
            $resetId = "ALTER TABLE project_documents AUTO_INCREMENT = 1";
            $this->connection->exec($resetId);
        } 
    }
}