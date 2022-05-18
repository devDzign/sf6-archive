<?php

namespace App\Controller\Post\Messenger\Handler;

use App\Controller\Post\Messenger\Message\AddPostCommand;
use App\Controller\Post\Messenger\Message\DeleteCommand;
use App\Entity\Post;
use App\Repository\PostRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteCommandHandler implements MessageHandlerInterface
{

    public function __construct(private PostRepository $postRepository)
    {
    }

    #[NoReturn]
    public function __invoke(DeleteCommand $command): void
    {
        if($post instanceof Post){
            $this->postRepository->remove($post, true);
        }

    }
}