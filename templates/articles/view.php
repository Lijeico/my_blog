<?php include __DIR__ . '/../header.php'; ?>
<h1><?= $article->getName() ?></h1>
<p><?= $article->getText() ?></p>
<p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
<?php if ($edit): ?> <p><a href="<?= $article->getId() ?>/edit">Редактировать</a></p> <?php endif; ?>

<h3>Comments:</h3>

<?php
if ($user === null) {
    $result = 'Log in to see the comments';
} else { ?>

    <form action="/articles/<?= $article->getId() ?>/comments" method="post">
        <label for="comment">Add comment</label><br>
<!--        <input type="text" name="text" id="comment" value="--><?//= $_POST['text'] ?? "" ?><!--" size="50"><br>-->
        <textarea id="comment" name="text" rows="4" cols="70"><?= $_POST['text'] ?? "" ?></textarea>
        <br>
        <input type="submit" value="Добавить">
    </form>
    <br>
    <?php
    $result = '';
    foreach ($comments as $comment) {
        if ($comment->getArticleId() === $article->getId()) {
            $result .= '<div style="border: 1px solid black; padding: 10px" id="article_' . $article->getId() . '_comment_' . $comment->getId() . '">
   
    <p>Posted by:  ' . $comment->getAuthor()->getNickname() . '</p>
    <p>' . $comment->getText() . '</p>
    <p>Created at: ' . $comment->getCreatedAt() . '</p>';
            if (($comment->getAuthor()->getId() === $user->getId()) || $edit === true) {
                $result .= '<p><a href="/articles/' . $article->getId() . '/comments/' . $comment->getId() . '/edit">Редактировать</a></p>';
            }
            $result .= '</div>
    <br>';
        }
    }

    if ($result === "") {
        $result = 'No comments';
    }
}
echo $result;
?>

<?php include __DIR__ . '/../footer.php'; ?>
