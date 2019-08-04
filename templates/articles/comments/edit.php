<?php

include __DIR__ . '/../../header.php';
?>
    <h1>Редактирование комментариев</h1>
<?php if(!empty($error)): ?>
    <div style="color: red;"><?= $error ?></div>
<?php endif; ?>
    <form action="/articles/<?=$article->getId()?>/comments/<?=$comment->getId()?>/edit" method="post">
        <label for="name">Текст комментария</label><br>
        <input type="text" name="text" id="text" value="<?= $_POST['text'] ?? $comment->getText() ?>" size="50"><br>
        <br>
        <input type="submit" value="Обновить">
    </form>
<?php include __DIR__ . '/../../footer.php'; ?>