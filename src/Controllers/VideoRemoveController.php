<?php

namespace Alura\Mvc\Controllers;

use Alura\Mvc\Repository\VideoRepository;

class VideoRemoveController implements Controller
{
    public function __construct(public readonly VideoRepository $videoRepository) {
    }

    public function processaRequisicao(): void
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if ($id === false || empty($id)) {
                header('Location: /?sucesso=0');
                return;
            }
            
            $this->videoRepository->remove($id);

            header('Location: /?sucesso=1');
        } catch (\Exception $e) {
            header('Location: /?sucesso=0');
        }
    }
}
