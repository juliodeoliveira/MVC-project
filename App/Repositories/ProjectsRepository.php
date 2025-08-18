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

    public function update(Projects $project)
    {
        $updateProject = $this->connection->prepare("UPDATE projects 
                                                    SET title = :projectTitle, 
                                                        description = :projectDescription,
                                                        start_date = :startDate, 
                                                        end_date = :endDate, 
                                                        service = :service
                                                    WHERE id = :id");

        $updateProject->bindValue(":projectTitle", $project->getTitle());
        $updateProject->bindValue(":projectDescription", $project->getDescription());
        $updateProject->bindValue(":startDate", $project->getStartDate());
        $updateProject->bindValue(":endDate", $project->getEndDate());
        $updateProject->bindValue(":service", $project->getService());
        $updateProject->bindValue(":id", $project->getId());

        $updateProject->execute();
    }

    public function show(int $id): Projects | null
    {
        $stmt = $this->connection->prepare("
            SELECT 
                p.id, p.title, p.start_date, p.end_date, p.service,
                p.description, p.customer_id, p.status,
                l.username AS leader_name
            FROM projects p
            LEFT JOIN project_leaders pl ON p.id = pl.project_id
            LEFT JOIN users l ON l.id = pl.user_id
            WHERE p.id = :id
        ");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        // Dados do projeto (vem repetido nas linhas, mas é o mesmo projeto)
        $first = $rows[0];

        $project = new Projects(
            $first['title'],
            $first['start_date'],
            $first['end_date'],
            $first['service']
        );

        $project->setId($first['id']);
        $project->setDescription($first['description']);
        $project->setClientId($first['customer_id']);
        $project->setStatus($first['status']);

        $leaders = array_filter(array_column($rows, 'leader_name'));
        $project->setLeaders($leaders);

        return $project;
    }

    public function all(int $clientId): array
    {
        $search = $this->connection->prepare("SELECT 
                                                projects.*, 
                                                users.username AS leader_name
                                            FROM 
                                                projects
                                            LEFT JOIN 
                                                project_leaders ON projects.id = project_leaders.project_id
                                            LEFT JOIN 
                                                users ON project_leaders.user_id = users.id
                                            WHERE 
                                                projects.customer_id = :id");
        $search->bindValue(":id", $clientId, PDO::PARAM_INT);
        $search->execute();
        $result = $search->fetchAll(PDO::FETCH_ASSOC);

        $projects = [];

        foreach ($result as $row) {
            $projectId = $row['id'];

            if (!isset($projects[$projectId])) {
                $project = new Projects($row["title"], $row["start_date"], $row["end_date"], $row["service"]);
                $project->setId($projectId);
                $project->setDescription($row['description']);
                $project->setClientId($row['customer_id']);
                $project->setStatus($row['status']);
                $project->setLeaders([]); 

                $projects[$projectId] = $project;
            }

            if (!empty($row['leader_name'])) {
                $leaders = $projects[$projectId]->getLeaders();
                $leaders[] = $row['leader_name'];
                $projects[$projectId]->setLeaders($leaders);
            }
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

    public function addLeader(int $projectId, int $userId)
    {
        $query = $this->connection->prepare("INSERT INTO project_leaders (project_id, user_id) VALUES (:projectId, :userId)");
        $query->bindValue(":projectId", $projectId);
        $query->bindValue(":userId", $userId);
        $query->execute();
    }

    public function clearLeaders(int $projectId): void
    {
        $query = $this->connection->prepare("DELETE FROM project_leaders WHERE project_id = :project_id");
        $query->bindValue(":project_id", $projectId);
        $query->execute();
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