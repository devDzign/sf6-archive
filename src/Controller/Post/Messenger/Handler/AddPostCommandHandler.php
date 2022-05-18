<?php

namespace App\Controller\Post\Messenger\Handler;

use App\Controller\Post\Messenger\Message\AddPostCommand;
use App\Repository\PostRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddPostCommandHandler implements MessageHandlerInterface
{

    public function __construct(private PostRepository $postRepository)
    {
    }

    #[NoReturn]
    public function __invoke(AddPostCommand $command): void
    {
        $post = $command->getPost();
        $this->postRepository->add($post, true);

    }
}