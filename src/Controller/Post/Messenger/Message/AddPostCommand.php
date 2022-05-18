<?php

namespace App\Controller\Post\Messenger\Message;

use App\Entity\Post;

class AddPostCommand
{
    public function __construct(private Post $post)
    {
    }

    public function  getPost(): Post
    {
        return $this->post;
    }


}