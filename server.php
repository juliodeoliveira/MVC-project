<?php
// serve.php
require __DIR__ . '/vendor/autoload.php'; // garante que todas as classes sejam carregadas
use App\Functions\LoadEnv;


$host = LoadEnv::fetchEnv("HOST");
$port = LoadEnv::fetchEnv("PORT");
$docRoot = 'public'; // Ajuste se a pasta public estiver em outro lugar

echo "Iniciando servidor PHP em http://$host:$port\n";
echo "Document root: $docRoot\n";
echo "Pressione Ctrl+C para parar.\n\n";

// Monta o comando
$command = sprintf('php -S %s:%d -t public', $host, $port);

// Executa o servidor
passthru($command);
