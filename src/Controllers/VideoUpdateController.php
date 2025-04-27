<?php

namespace Alura\Mvc\Controllers;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class VideoUpdateController implements Controller
{
    public function __construct(public readonly VideoRepository $videoRepository) {
    }

    public function processaRequisicao(): void
    {
        
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
            $title = filter_input(INPUT_POST, 'titulo');
            
            if (($id === false && !empty($id)) || $url === false || $title === false) {
                header('Location: /?sucesso=0');
                exit();
            }

            $video = new Video($url, $title);
            $video->setId($id);

            $this->videoRepository->update($video);

            header('Location: /?sucesso=1');
        } catch (\Exception $e) {
            header('Location: /?sucesso=0');
        }

    }
}
