<?php
namespace App\Controllers;

class ContainerController 
{
    public function success(): void
    {
        require_once "../views/portal/success.php";
    }

    public function signinClient(): void 
    {
        require_once "../views/portal/clients/cadastro.php";
    }

    public function listCustomers(): void
    {
        require_once "../views/portal/clients/customers.php";
    }

    public function edition(): void
    {
        require_once "../views/portal/clients/editing.php";
    }
    
    public function findClients(): void
    {
        require_once "../views/portal/clients/searchClients.php";
    }

    public function listProjects(): void
    {
        require_once "../views/portal/projects/projects.php";
    }

    public function createProject(): void
    {
        require_once "../views/portal/projects/createProject.php";
    }

    public function findProject(): void
    {
        require_once "../views/portal/projects/findProjects.php";
    }

    public function toDoList(): void
    {
        require_once "../views/portal/projects/toDoList.php";
    }

    public function notFound(): void
    {
        require_once "../views/portal/notfound.php";
    }

    public function registerUser(): void
    {
        require_once "../views/portal/users/registerUser.php";
    }

    public function login(): void
    {
        require_once "../views/portal/users/loginUser.php";
    }

}