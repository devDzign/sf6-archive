<?php

namespace App\Controller\Post\Messenger\Message;

use App\Entity\Post;

class DeleteCommand
{
    public function __construct(private Post $post)
    {
    }

    public function  getPost(): Post
    {
        return $this->post;
    }


}