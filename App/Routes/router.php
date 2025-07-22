<?php
// TODO: Separar as rotas de acordo com as responsabilidades. Ex.: rotas de usuario: UserRoutes.php
//? Seria interessante se um usuario tentar acessar uma página eu mostrar pra ele que a pagina nao existe ao inves de redirecionar ele?
// TODO: tem que fazer o script que cria o banco de dados automaticamente, migrations, para as tabelas de permissao e provavelmente a de usuarios tambem

require "../vendor/autoload.php";
          
use App\Functions\Router;

use App\Routes\ClientRoutes;
use App\Routes\AdminRoutes;
use App\Routes\AuthRoutes;
use App\Routes\ReportRoutes;
use App\Routes\DocumentRoutes;
use App\Routes\PhotoRoutes;
use App\Routes\DefaultRoutes;
use App\Routes\ProjectRoutes;
use App\Routes\TasksRoutes;

$router = new Router();

(new ClientRoutes)->register($router);
(new AdminRoutes)->register($router);
(new AuthRoutes)->register($router);
(new ReportRoutes)->register($router);
(new DocumentRoutes)->register($router);
(new PhotoRoutes)->register($router);
(new ProjectRoutes)->register($router);
(new DefaultRoutes)->register($router);
(new TasksRoutes)->register($router);

$router->dispatch();
