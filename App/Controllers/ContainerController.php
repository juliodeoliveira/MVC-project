<?php
namespace App\Controllers;

class ContainerController 
{
    public function signinClient(): void 
    {
        require_once "../views/portal/cadastro.php";
    }

    public function success(): void
    {
        require_once "../views/portal/success.php";
    }

    public function listCustomers(): void
    {
        require_once "../views/portal/customers.php";
    }
    public function edition(): void
    {
        require_once "../views/portal/editing.php";
    }

    public function listProjects(): void
    {
        require_once "../views/portal/projects.php";
    }
}