<?php
namespace App\Controllers;

use app\traits\View;
// mostra informações que precisa, tipo mostrar os formulários e páginas
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
}