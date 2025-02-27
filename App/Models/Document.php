<?php
namespace App\Models;

class Document
{
    private string $documentNewPath;
    private string $documentName;
    private string $documentType;
    private string $projectId;
    private int $documentId;

    public function __construct(string $name, string $newPath, int $projectId, int $documentId, string $documentType)
    {
        $this->documentNewPath = $newPath;
        $this->documentName = $name;
        $this->documentType = $documentType;
        $this->projectId = $projectId;
        $this->documentId = $documentId;
    }

    public function getNewDocumentPath(): string
    {
        return $this->documentNewPath;
    }

    public function getDocumentName(): string
    {
        return $this->documentName;
    }

    public function getDocumentType(): string 
    {
        return $this->documentType;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getDocumentId(): int
    {
        return $this->documentId;
    }

    public function setNewDocumentPath($path): void 
    {
        $this->documentNewPath = $path;
    }

    public function setDocumentName($name): void 
    {
        $this->documentName = $name;
    }

    public function setDocumentType($type): void 
    {
        $this->documentType = $type;
    }
    
    public function setProjectId($id): void 
    {
        $this->projectId = $id;
    }
}