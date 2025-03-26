<?php

namespace App\Repositories;

namespace App\Repositories;
use App\Connection;
use App\Models\Photos;
use App\Models\Projects;
use App\Models\ToDoList;
use PDO;

class ProjectsRepository
{
    private $connection;

    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->connect();
    }

    public function insert(Projects $project): int
    {
        $insertProject = $this->connection->prepare("INSERT INTO projects (title, description, start_date, end_date, service, customer_id, status) VALUES (:title, :description, :startDate, :endDate, :service, :customer_id, :status);");
        $insertProject->bindValue(":title", $project->getTitle());
        $insertProject->bindValue(":description", $project->getDescription());
        $insertProject->bindValue(":startDate", $project->getStartDate());
        $insertProject->bindValue(":endDate", $project->getEndDate());
        $insertProject->bindValue(":service", $project->getService());
        $insertProject->bindValue(":customer_id", $project->getClientId());
        $insertProject->bindValue(":status", $project->getStatus());

        $insertProject->execute();

        return $this->connection->lastInsertId();

    }

    public function update()
    {

    }

    public function show(int $id): Projects | null
    {
        //! Troquei a query que tinha customer_id por id, se vier a aparecer algum bug relacionado já sei onde procurar
        $search = $this->connection->prepare("SELECT * FROM projects WHERE id = :id");
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
        $project->setStatus($result['status']);

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
            $project->setStatus($row['status']);
            
            $projects[] = $project;
        }

        return $projects;
    }

    public function delete(Projects $project)
    {
        //! tomar cuidado com isso aqui pelo fato dos ids derem problemas mais pra frente
        $delete = $this->connection->prepare("DELETE FROM projects WHERE id = :id");
        $delete->bindValue(":id", $project->getId());
        $delete->execute();

        $delete = $this->connection->prepare("DELETE FROM project_tasks WHERE task_project_id = :id");
        $delete->bindValue(":id", $project->getId());
        $delete->execute();

        $delete = $this->connection->prepare("DELETE FROM project_pictures WHERE project_id = :id");
        $delete->bindValue(":id", $project->getId());
        $delete->execute();

        $delete = $this->connection->prepare("DELETE FROM project_documents WHERE document_project_id = :id");
        $delete->bindValue(":id", $project->getId());
        $delete->execute();
    }

    public function projectStatusOngoing(int $projectId)
    {
        $updateStatus = $this->connection->prepare("UPDATE projects SET status = 'Em andamento' WHERE id = :project_id");
        $updateStatus->bindValue(":project_id", $projectId);
        $updateStatus->execute();
    }

    public function projectStatusDone(int $projectId)
    {
        $updateStatus = $this->connection->prepare("UPDATE projects SET status = 'Concluído' WHERE id = :project_id");
        $updateStatus->bindValue(":project_id", $projectId);
        $updateStatus->execute();
    }

    public function projectStatusNotStarted(int $projectId)
    {
        $updateStatus = $this->connection->prepare("UPDATE projects SET status = 'Não iniciado' WHERE id = :project_id");
        $updateStatus->bindValue(":project_id", $projectId);
        $updateStatus->execute();
    }
}