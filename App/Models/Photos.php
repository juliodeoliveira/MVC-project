<?php
namespace App\Models;

class Photos
{
    private string $photoNewPath;
    private string $photoName;
    private string $projectId;

    public function __construct(string $name, string $newPath, int $projectId)
    {
        $this->photoName = $name;
        $this->photoNewPath = $newPath;
        $this->projectId = $projectId;
    }

    public function getNewPhotoPath(): string
    {
        return $this->photoNewPath;
    }

    public function getPhotoName(): string
    {
        return $this->photoName;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }
}