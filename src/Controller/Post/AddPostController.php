<?php

namespace App\Controller\Post;

use App\Controller\Post\Messenger\Message\AddPostCommand;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class AddPostController extends AbstractController
{
    #[Route('/post/add', name: 'app_post')]
    public function __invoke(MessageBusInterface $messageBus): Response
    {
        $command = new AddPostCommand(
            (new Post())
                ->setTitle('Test title')
                ->setDescription('some description super cool')
        );
        $messageBus->dispatch($command);
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
}
