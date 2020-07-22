<?php
declare(strict_types=1);


namespace App\Event;


use App\Entity\Comment;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class CommentEvent extends Event
{

    public const COMMENT_ADDED = 'comment_added';

    private $user;

    private $comment;

    public function __construct(User $user, Comment $comment)
    {
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Comment
     */
    public function getComment(): Comment
    {
        return $this->comment;
    }



}