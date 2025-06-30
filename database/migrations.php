<?php
//TODO: Preciso fazer a migration das tabelas de permissao

//* php migrations.php 
//* php migrations.php --rollback

require "./../bootstrap.php";

use App\Connection;
$connection = new Connection;
$connection = $connection->connect();

$tablesDirectory = __DIR__ . "/tables";
$schemaFiles = array_diff(scandir($tablesDirectory), ['.', '..']);

$comandFlag = $argv[1] ?? null;

if ($comandFlag === '--rollback' || $comandFlag === "-r") {
    echo "♻️  Reverting migrations... \n";
    foreach(array_reverse($schemaFiles) as $file) {
        $schema = include "{$tablesDirectory}/{$file}";
        $tableName = $schema["name"];

        try {
            $connection->exec("DROP TABLE IF EXISTS {$tableName}");
            $connection->exec("DELETE FROM migrations WHERE migration_name = '{$tableName}'");
        } catch (PDOException $e) {
            exit("✅ Rollback done! \n");
        }

        $stmt = $connection->prepare("DELETE FROM migrations WHERE migration_name = ?");
        $stmt->execute([$tableName]);
    }

    $connection->exec("DROP DATABASE IF EXISTS projectmanager");
    exit("✅ Rollback done! \n");

} else {

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
        $primaryKey = $schema['primary_key'] ?? null;
        $indexes = $schema['indexes'] ?? [];
        $foreignKeys = $schema['foreign_keys'] ?? [];
        $uniques = $schema['uniques'] ?? [];
    
        $checkMigration = $connection->prepare('SELECT COUNT(*) FROM migrations WHERE migration_name = ?');
        $checkMigration->execute([$tableName]);
    
        if ($checkMigration->fetchColumn() > 0) {
            echo "⏭️  The table $tableName is already created! \n\n";
            continue;
        }
    
        echo "📦  Creating table: $tableName... \n";
    
        $columnsSql = [];
    
        // Colunas normais
        foreach ($columns as $columnName => $definition) {
            $columnsSql[] = "`{$columnName}` {$definition}";
        }
    
        // Chave primária composta
        if ($primaryKey && is_array($primaryKey)) {
            $columnsSql[] = "PRIMARY KEY (" . implode(", ", $primaryKey) . ")";
        }
    
        // Índices
        foreach ($indexes as $indexColumn) {
            $columnsSql[] = "KEY (`{$indexColumn}`)";
        }
    
        // Uniques
        foreach ($uniques as $uniqueColumn) {
            $columnsSql[] = "UNIQUE (`{$uniqueColumn}`)";
        }
    
        // Chaves estrangeiras
        foreach ($foreignKeys as $columnName => $definition) {
            $columnsSql[] = "FOREIGN KEY (`{$columnName}`) {$definition}";
        }
    
        $createTableSql = sprintf(
            "CREATE TABLE IF NOT EXISTS `%s` (%s);",
            $tableName,
            implode(', ', $columnsSql)
        );
    
        $connection->exec($createTableSql);
    
        $registerMigration = $connection->prepare("INSERT INTO migrations (migration_name, created_at) VALUES (?, NOW());");
        $registerMigration->execute([$tableName]);
    
        echo "✅  Table '{$tableName}' sucssesfully created! \n";
        echo "\n\n";
    }
    
    echo "✔  All tables succesfully created! \n";
}
