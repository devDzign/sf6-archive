<?php

namespace App\Controller\Post\Messenger\Message;

use App\Entity\Post;

class UpdateCommand
{
    public function __construct(private int $id)
    {
    }

    public function  getId(): int
    {
        return $this->id;
    }


}