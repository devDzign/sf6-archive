<?php

namespace App\Controller\Post\Messenger\Handler;

use App\Controller\Post\Messenger\Message\AddPostCommand;
use App\Controller\Post\Messenger\Message\DeleteCommand;
use App\Controller\Post\Messenger\Message\UpdateCommand;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateCommandHandler implements MessageHandlerInterface, LoggerAwareInterface
{

    use LoggerAwareTrait;

    public function __construct(private PostRepository $postRepository, private EntityManagerInterface $entityManager)
    {
    }

    #[NoReturn]
    public function __invoke(UpdateCommand $command): void
    {
        $post = $this->postRepository->find($command->getId());
        if (!$post) {
            $this->logger?->alert(sprintf('Image post %d was missing!', $command->getId()));
            return;
        }

        $post->setCreatedAt(new \DateTime());
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}