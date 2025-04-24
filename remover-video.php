<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = $_GET['id'];
$sql = 'DELETE FROM videos WHERE id = ?;';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $id);
$statement->execute();

// TODO: implementar alerta de erro em caso de erro
if($statement->execute() === false) {
    header('Location: /index.php?sucesso=0');
} else {
    header('Location: /index.php?sucesso=1');
}

