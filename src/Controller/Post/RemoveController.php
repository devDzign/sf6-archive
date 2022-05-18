<?php

namespace App\Controller\Post;

use App\Controller\Post\Messenger\Message\AddPostCommand;
use App\Controller\Post\Messenger\Message\DeleteCommand;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class RemoveController extends AbstractController
{
    #[Route('/post/{id}/remove', name: 'app_post_remove')]
    public function __invoke(Post $post ,MessageBusInterface $messageBus): Response
    {
        $command = new DeleteCommand($post);
        $messageBus->dispatch($command);
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
}
