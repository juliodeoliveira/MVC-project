<?php

namespace App\Controllers;

use App\Functions\URI;
use App\Controllers\ClientController;
use App\Controllers\ProjectsController;
class ReportController
{
    public function createProjectReport()
    {
        $uriExplode = URI::uriExplode();
        $getIdbyURI = (int) $uriExplode[sizeof($uriExplode)-1];

        $findProject = new ProjectsController();
        $project = $findProject->findProject($getIdbyURI);

        $clientInfo = new ClientController();
        $client = $clientInfo->findClients($project->getClientId());

        if ($project->getStatus() == "Concluído") {
            $status = "<li style='background-color: #cef1c6'><strong>Status do projeto:</strong> ". $project->getStatus() . "</li>";
        } else if ($project->getStatus() == "Em andamento") {
            $status = "<li style='background-color: #f1f0c6'><strong>Status do projeto:</strong> ". $project->getStatus() . "</li>";
        } else if ($project->getStatus() == "Não iniciado") {
            $status = "<li style='background-color: #f1c6c6'><strong>Status do projeto:</strong> ". $project->getStatus() . "</li>";
        }

        $reportValues = [
            "{{ CLIENTE }}" => $client->getEnterpriseName(),
            "{{ NOMEPROJETO }}" => $project->getTitle(),
            "{{ STATUS }}" => $status,
            "{{ DATAINICIO }}" => $project->getStartDate(),
            "{{ DATAFINAL }}" => $project->getEndDate(),
            "{{ SERVICO }}" => $project->getService(),
        ];

        $template = file_get_contents("./assets/template/reportTemplate.html");

        $report = str_replace(array_keys($reportValues), array_values($reportValues), $template);
        
        $fileName = "relatorio-" . $project->getTitle() . ".html";
        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . strlen($report));
        header("Pragma: no-cache");
        header("Expires: 0");

        echo $report;
        exit();
    }

    public function createClientReport() 
    {
        // TODO: aqui precisa de validacao 
        $uriExplode = URI::uriExplode();
        $getIdbyURI = (int) $uriExplode[sizeof($uriExplode)-1];

        $clientInfo = new ClientController();
        $client = $clientInfo->findClients($getIdbyURI);

        $projectInfo = new ProjectsController();
        $projects = $projectInfo->allProjects($getIdbyURI);

        

        $listItems = "";
        foreach ($projects as $project) {            
            if ($project->getStatus() == "Concluído") {
                $status = "<li style='background-color: #cef1c6'><strong>Status do projeto:</strong> ". htmlspecialchars($project->getStatus()) . "</li>";
            } else if ($project->getStatus() == "Em andamento") {
                $status = "<li style='background-color: #f1f0c6'><strong>Status do projeto:</strong> ". htmlspecialchars($project->getStatus()) . "</li>";
            } else if ($project->getStatus() == "Não iniciado") {
                $status = "<li style='background-color: #f1c6c6'><strong>Status do projeto:</strong> ". htmlspecialchars($project->getStatus()) . "</li>";
            }

            $listItems .= "<li><strong>Nome do projeto:</strong> " . htmlspecialchars($project->getTitle()) ."</li>";
            $listItems .= "<li><strong>Data de início:</strong> " . htmlspecialchars($project->getStartDate()) ."</li>";
            $listItems .= "<li><strong>Data de término:</strong> " . htmlspecialchars($project->getEndDate()) ."</li>";
            $listItems .= "<li><strong>Servico:</strong> " . htmlspecialchars($project->getService()) ."</li>";
            $listItems .= "$status";
            $listItems .= "<li><strong>Id do Projeto:</strong> " . htmlspecialchars($project->getId()) ."</li>";
            $listItems .= "<li><strong>Descricao do projeto:</strong> " . htmlspecialchars($project->getDescription()) ."</li>";
            $listItems .= "<br>";
            
        }

        if (!file_exists("./assets/template/clientReportTemplate.html")) {
            die("Erro: Template não encontrado! Entre em contato com o suporte técnico.");
        }

        $template = file_get_contents("./assets/template/clientReportTemplate.html");
        $template = str_replace("{{ CLIENTE }}", htmlspecialchars($client->getEnterpriseName()), $template);

        $report = str_replace("{{ PROJETOS }}", $listItems, $template);

        $fileName = "relatorio-cliente-" . $client->getEnterpriseName() . ".html";
        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . strlen($report));
        header("Pragma: no-cache");
        header("Expires: 0");

        echo $report;
        exit();
    }
}