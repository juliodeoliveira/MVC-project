<?php

namespace App\Controllers;

use App\Functions\URI;
use App\Controllers\ClientController;
class ReportController
{
    public function createProjectReport()
    {
        // TODO: aqui precisa de validacao 
        $reportValues = json_decode($_POST["projectInfo"], true);

        $reportValues = [
            "{{ CLIENTE }}" => $reportValues['client'],
            "{{ NOMEPROJETO }}" => $reportValues['title'],
            "{{ STATUS }}" => $reportValues['status'],
            "{{ DATAINICIO }}" => $reportValues['startDate'],
            "{{ DATAFINAL }}" => $reportValues['endDate'],
            "{{ SERVICO }}" => $reportValues['service'],
        ];

        $template = file_get_contents("./assets/template/reportTemplate.html");

        $report = str_replace(array_keys($reportValues), array_values($reportValues), $template);
        
        $fileName = "relatorio.html";
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
            $listItems .= "<li><strong>Nome do projeto:</strong> " . $project->getTitle() ."</li>";
            $listItems .= "<li><strong>Data de início:</strong> " . $project->getStartDate() ."</li>";
            $listItems .= "<li><strong>Data de término:</strong> " . $project->getEndDate() ."</li>";
            $listItems .= "<li><strong>Servico:</strong> " . $project->getService() ."</li>";
            $listItems .= "<li><strong>Id do Projeto:</strong> " . $project->getId() ."</li>";
            $listItems .= "<li><strong>Descricao do projeto:</strong> " . $project->getDescription() ."</li>";
            $listItems .= "<br>";
            
        }

        $template = file_get_contents("./assets/template/clientReportTemplate.html");
        $template = str_replace("{{ CLIENTE }}", $client->getEnterpriseName(), $template);

        $report = str_replace("{{ PROJETOS }}", $listItems, $template);

        $fileName = "relatorio-cliente.html";
        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . strlen($report));
        header("Pragma: no-cache");
        header("Expires: 0");

        echo $report;
        exit();
    }
}