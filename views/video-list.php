<?php require_once __DIR__ . '/header-html.php'; ?>
<ul class="videos__container" alt="videos alura">
    <?php foreach ($videoList as $video): ?>
        <li class="videos__item">
            <iframe width="100%" height="72%" src="<?php echo $video->url ?>" title="YouTube video player"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
            <div class="descricao-video">
                <img src="./img/logo.png" alt="logo canal alura">
                <h3><?php echo $video->title ?></h3>
                <div class="acoes-video">
                    <!-- A sintaxe com < ? = abaixo é igual a iniciar a tag php e fazer um echo -->
                    <a href="/editar-video?id=<?= $video->id ?>">Editar</a>
                    <a href="/remover-video?id=<?= $video->id; ?>">Excluir</a>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?php require_once __DIR__ . '/fim-html.php'; 