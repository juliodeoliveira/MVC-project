<?php
namespace App\Models;

class Photos
{
    private string $photoNewPath;
    private string $photoName;
    private string $projectId;
    private int $photoId;

    public function __construct(string $name, string $newPath, int $projectId, int $photoId)
    {
        $this->photoName = $name;
        $this->photoNewPath = $newPath;
        $this->projectId = $projectId;
        $this->photoId = $photoId;
    }

    public function getPhotoId(): int
    {
        return $this->photoId;
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