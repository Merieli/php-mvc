<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$sql = 'INSERT INTO videos (url, title) VALUES (?, ?);';
$statement = $pdo->prepare($sql);

//$_GET - é uma variável superglobal que contém os dados enviados via GET
//$_POST - é uma variável superglobal que contém os dados enviados via POST, e entre chaves na sequencia deve ser passado o name do campo do formulário que se deseja capturar
$url= $_POST['url'];
$titulo = $_POST['titulo'];

$statement->bindValue(1, $url);
$statement->bindValue(2, $titulo);

// Padrão Post-Redirect-Get -> antes foi efetuado um post e agora redireciona para o index.php com o método GET
if($statement->execute() === false) {
    header('Location: /index.php?sucesso=0');
} else {
    header('Location: /index.php?sucesso=1');
}


