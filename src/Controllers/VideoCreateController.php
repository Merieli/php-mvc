<?php

namespace Alura\Mvc\Controllers;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class VideoCreateController implements Controller
{
    public function __construct(public readonly VideoRepository $videoRepository) { 
    }

    public function processaRequisicao(): void
    {
        try {
            $url= filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
            $titulo = filter_input(INPUT_POST, 'titulo');
            
            if ($titulo === false || $url === false) {
                header('Location: /?sucesso=0');
                return;
            }

            $newVideo = new Video($url, $titulo);

            $this->videoRepository->add( $newVideo);
            header('Location: /?sucesso=1');
        } catch (\Exception $e) {
            header('Location: /?sucesso=0');
        }

    }
}
