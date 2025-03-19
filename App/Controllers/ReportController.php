<?php

namespace App\Controllers;

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
}