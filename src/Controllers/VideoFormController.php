<?php

namespace Alura\Mvc\Controllers;

use Alura\Mvc\Repository\VideoRepository;

class VideoFormController implements Controller
{    
    public function __construct(public readonly VideoRepository $videoRepository) {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $video = null;

        if ($id !== false && !empty($id)) {
            try {
                $video = $this->videoRepository->find($id);
            } catch (\Exception $e) {
                header('Location: /?sucesso=0');
            }
        }

        require_once __DIR__ . '/../../views/video-form.php';
    }
}
