<?php

namespace App\Repositories;

namespace App\Repositories;
use App\Connection;
use App\Models\Projects;
use PDO;

class ProjectsRepository
{
    private $connection;

    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->connect();
    }

    public function insert()
    {

    }

    public function update()
    {

    }

    public function show(int $id): Projects | null
    {
        $search = $this->connection->prepare("SELECT * FROM projects WHERE customer_id = :id");
        $search->bindValue(":id", $id, PDO::PARAM_INT);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        $project = new Projects($result['title'], $result['start_date'], $result['end_date'], $result['service']);
        $project->setId($result['id']);
        $project->setDescription($result['description']);
        $project->setClientId($result['customer_id']);

        return $project;
    }

    public function all(int $clientId): array
    {
        $search = $this->connection->prepare("SELECT * FROM projects WHERE customer_id = :id");
        $search->bindValue(":id", $clientId, PDO::PARAM_INT);
        $search->execute();
        $result = $search->fetchAll(PDO::FETCH_ASSOC);

        $projects = [];
        foreach ($result as $row) {
            $project = new Projects($row["title"], $row["start_date"], $row["end_date"], $row["service"]);
            $project->setId($row['id']);
            $project->setDescription($row['description']);
            $project->setClientId($row['customer_id']);
            
            $projects[] = $project;
        }

        return $projects;
    }

}