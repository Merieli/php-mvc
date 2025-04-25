<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$sql = 'INSERT INTO videos (url, title) VALUES (?, ?);';
$statement = $pdo->prepare($sql);

//$_GET - é uma variável superglobal que contém os dados enviados via GET
//$_POST - é uma variável superglobal que contém os dados enviados via POST, e entre chaves na sequencia deve ser passado o name do campo do formulário que se deseja capturar
// filter_input - filtra a entrada de dados obtida de uma requisição, evitando que o usuário envie dados inválidos ou maliciosos
// filter_var - filtra uma variável qualquer, permitindo validar e sanitizar os dados
$url= filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
$titulo = filter_input(INPUT_POST, 'titulo');

if ($titulo === false || $url === false) {
    header('Location: /index.php?sucesso=0');
    exit();
}


$statement->bindValue(1, $url);
$statement->bindValue(2, $titulo);

// Padrão Post-Redirect-Get -> antes foi efetuado um post e agora redireciona para o index.php com o método GET
if($statement->execute() === false) {
    header('Location: /index.php?sucesso=0');
} else {
    header('Location: /index.php?sucesso=1');
}


