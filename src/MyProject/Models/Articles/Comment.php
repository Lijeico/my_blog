<?php


namespace MyProject\Models\Articles;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;


class Comment extends ActiveRecordEntity
{
 protected static function getTableName(): string
 {
     return 'comments';
 }

 protected $authorId;

 protected $articleId;

 protected $text;

 protected $createdAt;

 public function getArticleId(): int
 {
     return $this->articleId;
 }

    public function getText(): string
 {
     return $this->text;
 }

 public function setText(string $text): void
 {
     $this->text = $text;
 }

 public function getAuthor(): User
 {
     return User::getById($this->authorId);
 }

 public function setAuthor(User $author): void
 {
     $this->authorId = $author->getId();
 }

 public function getCreatedAt(): string
 {
     return $this->createdAt;
 }

    public static function createFromArray(array $fields, User $author, $articleId): Comment
    {
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментарии');
        }

        $comment = new Comment();

        $comment->setAuthor($author);
        $comment->setText($fields['text']);
        $comment->articleId = $articleId;

       $comment->save();
        return $comment;
    }

    public function updateFromArray(array $fields): Comment
    {
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментарии');
        }

        $this->setText($fields['text']);

        $this->save();

        return $this;
    }

}