<?php

require "./../bootstrap.php";

use App\Connection;
$connection = new Connection;
$connection = $connection->connect();

$tablesDirectory = __DIR__ . "/tables";
$schemaFiles = array_diff(scandir($tablesDirectory), ['.', '..']);

$comandFlag = $argv[1] ?? null;

if ($comandFlag === 'rollback') {
    echo "Revertendo migrations... \n";
    foreach(array_reverse($schemaFiles) as $file) {
        $schema = include "{$tablesDirectory}/{$file}";
        $tableName = $schema["name"];

        try {
            $connection->exec("DROP TABLE IF EXISTS {$tableName}");
            $connection->exec("DELETE FROM migrations WHERE migration_name = '{$tableName}'");
        } catch (PDOException $e) {
            echo "$e \n";
        }

        $stmt = $connection->prepare("DELETE FROM migrations WHERE migration_name = ?");
        $stmt->execute([$tableName]);
    }

    $connection->exec("DROP DATABASE IF EXISTS projectmanager");
    exit("Rollback concluído com sucesso! \n");
}

$connection->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration_name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
");

foreach ($schemaFiles as $file) {
    $schema = include "{$tablesDirectory}/{$file}";

    $tableName = $schema['name'];
    $columns = $schema['columns'];
    $foreignKeys = $schema['foreign_keys'] ?? [];

    $checkMigration = $connection->prepare('SELECT COUNT(*) FROM migrations WHERE migration_name = ?');
    $checkMigration->execute([$tableName]);

    if ($checkMigration->fetchColumn() > 0) {
        echo "A tabela $tableName já foi criada! \n";
        continue;
    }

    echo "Criando tabela: $tableName... \n";

    $columnsSql = [];
    foreach ($columns as $columnName => $definition) {
        $columnsSql[] = "{$columnName} {$definition}";
    }

    foreach ($foreignKeys as $columnName => $definition) {
        $columnsSql[] = "FOREIGN KEY ({$columnName}) {$definition}";
    }

    $createTableSql = sprintf(
        "CREATE TABLE IF NOT EXISTS %s (%s);",
        $tableName,
        implode(', ', $columnsSql)
    );

    $connection->exec($createTableSql);

    $registerMigration = $connection->prepare("INSERT INTO migrations (migration_name, created_at) VALUES (?, NOW());");
    $registerMigration->execute([$tableName]);

    echo "Tabela '{$tableName}' criada com sucesso! \n";
    echo "------------------------------------------------------ \n";
}

echo "Todas as tabelas foram criadas com sucesso! \n";