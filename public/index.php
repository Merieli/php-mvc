<?php

use Alura\Mvc\Controllers\Error404Controller;
use Alura\Mvc\Repository\VideoRepository;
// O servidor do PHP automaticamente é configurado para sempre carregar o arquivo index.php quando qualquer rota é acessada, caso esteja utilizando outros servidores como o Apache ou Nginx, é necessário configurar o servidor para que ele carregue o arquivo index.php quando a rota for acessada
// Este arquivo index.php é o ponto único de entrada da aplicação. Esse padrão é conhecido como front controller. 

require_once __DIR__ . '/../vendor/autoload.php';

$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$videoRepository = new VideoRepository($pdo);


$routes = require_once __DIR__ . '/../config/routes.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

// O comentário abaixo ajuda o VS Code a identificar um tipo da variável
$key = "$httpMethod|$pathInfo";
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key];
    
    $controller = new $controllerClass($videoRepository);
} else {
    $controller = new Error404Controller();
}

/** @var \Alura\Mvc\Controllers\Controller $controller  */
$controller->processaRequisicao();
