<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

class VideoRepository
{
    public function __construct(private PDO $pdo)  {
        
    }

    public function add(Video $video): void
    {
        $sql = 'INSERT INTO videos (url, title) VALUES (?, ?);';
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(1, $video->url);
        $statement->bindValue(2, $video->title);

        $result = $statement->execute();
        if ($result === false) {
            throw new \RuntimeException('Erro ao inserir vídeo no banco de dados');
        }

        $id = $this->pdo->lastInsertId();
        $video->setId(intval($id));
    }

    public function remove(int $id): void
    {
        $sql = 'DELETE FROM videos WHERE id = ?;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);

        $result = $statement->execute();
        if ($result === false) {
            throw new \RuntimeException('Erro ao excluir vídeo no banco de dados');
        }
    }

    public function update(Video $video): void
    {
        $sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id;';
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':url', $video->url);
        $statement->bindValue(':title', $video->title);
        $statement->bindValue(':id', $video->id, PDO::PARAM_INT);

        $result = $statement->execute();
        if ($result === false) {
            throw new \RuntimeException('Erro ao excluir vídeo no banco de dados');
        }
    }

    public function all(): array
    {
        // PDO::FETCH_ASSOC - retorna um array associativo, onde as chaves são os nomes das colunas
        $videoList = $this->pdo
            ->query('SELECT * FROM videos;')
            ->fetchAll(PDO::FETCH_ASSOC);
        return array_map(
            $this->hydrateVideo(...), 
            $videoList
        );
    }

    public function find(int $id): Video
    {
        $sql = 'SELECT * FROM videos WHERE id = ?;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);

        $result = $statement->execute();
        if ($result === false) {
            throw new \RuntimeException('Erro ao obter o vídeo do banco de dados');
        }

        return $this->hydrateVideo($statement->fetch(PDO::FETCH_ASSOC));
    }

    private function hydrateVideo(array $videoData): Video
    {
        $video = new Video($videoData['url'], $videoData['title']);
        $video->setId($videoData['id']);

        return $video;
    }
}
