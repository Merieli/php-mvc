<?php

return [
    'GET|/' => \Alura\Mvc\Controllers\VideoListController::class,
    'GET|/novo-video' => \Alura\Mvc\Controllers\VideoFormController::class,
    'POST|/novo-video' => \Alura\Mvc\Controllers\VideoCreateController::class,
    'GET|/editar-video' => \Alura\Mvc\Controllers\VideoFormController::class,
    'POST|/editar-video' => \Alura\Mvc\Controllers\VideoUpdateController::class,
    'GET|/remover-video' => \Alura\Mvc\Controllers\VideoRemoveController::class,
];