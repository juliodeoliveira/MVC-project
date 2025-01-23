<?php
namespace App\Functions;

class Router
{
    private $routes = [];

    // Adiciona uma rota
    public function add(string $method, string $path, callable $handler)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->normalizePath($path),
            'handler' => $handler
        ];
    }

    // Processa a requisição
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->normalizePath($_SERVER['REQUEST_URI']);

        // Trunca a URI para comparar apenas a base (ex.: /editing/1 => /editing)
        $uri = $this->truncateURI($uri);

        foreach ($this->routes as $route) {
            if ($method === $route['method'] && $uri === $route['path']) {
                // Executa o handler da rota
                call_user_func($route['handler']);
                return;
            }
        }

        $this->handleNotFound();
    }

    // Normaliza o caminho removendo barras extras
    private function normalizePath(string $path): string
    {
        return rtrim($path, '/') ?: '/';
    }

    private function truncateURI(string $uri): string
    {
        $parts = explode('/', $uri);
        return '/' . ($parts[1] ?? ''); // Mantém apenas a primeira parte após a raiz
    }

    private function handleNotFound()
    {
        http_response_code(404);  // Define o código de resposta HTTP como 404
        require_once "../views/portal/notfound.php";  // Inclui a página de erro 404
        exit;  // Garante que o código pare de executar após a página de erro ser exibida
    }
}