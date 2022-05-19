<?php

namespace App\Controller\Post\Messenger\Handler;

use App\Controller\Post\Messenger\Message\AddPostCommand;
use App\Controller\Post\Messenger\Message\DeleteCommand;
use App\Controller\Post\Messenger\Message\UpdateCommand;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateCommandHandler implements MessageHandlerInterface
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[NoReturn]
    public function __invoke(UpdateCommand $command): void
    {
        if($command->getPost() instanceof Post){
            $this->entityManager->flush();
        }
    }
}