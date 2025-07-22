<?php
//* php seeder.php
require "./../bootstrap.php";

use App\Connection;
$connection = new Connection;
$connection = $connection->connect();

$seedsDir = __DIR__ . '/seeds';
$seedsFile = scandir($seedsDir);

$success = true;

foreach ($seedsFile as $file) {
    if ($file === '.' || $file === '..') continue;

    $tableName = strtolower(preg_replace('/Seeder\.php$/i', '', $file));
    $records = include "$seedsDir/$file";

    try {
        $countQuery = $connection->prepare("SELECT COUNT(*) AS total FROM $tableName");
        $countQuery->execute();
        $count = $countQuery->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    } catch (PDOException $e) {
        echo "⚠️  The table $tableName does not exists, make shure to run migrations first...\n\n";
        $success = false;
        continue;
    }

    if ($count > 0) {
        echo "⚠️  The table '$tableName' is not empty. Ignoring seed...\n";
        continue;
    }

    foreach ($records as $record) {
        $columns = array_keys($record);
        $values = array_values($record);

        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $columnList = implode(', ', $columns);

        try {
            $query = "INSERT INTO $tableName ($columnList) VALUES ($placeholders)";
            $query = $connection->prepare($query);
            $query->execute($values);
        } catch (PDOException $e) {
            echo "⚠️  The table $tableName does not exists, make shure to run migrations first...\n\n";
            $success = false;
            continue;
        }
    }
}

if (!$success) {
    echo "⚠️  Seeder finished with warnings... \n";
} else {
    echo "🌱  Seed applied for: '$tableName'.\n";
}