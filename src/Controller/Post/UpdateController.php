<?php

namespace App\Controller\Post;

use App\Controller\Post\Messenger\Message\AddPostCommand;
use App\Controller\Post\Messenger\Message\DeleteCommand;
use App\Controller\Post\Messenger\Message\UpdateCommand;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/post/{id}/update', name: 'app_post_update')]
    public function __invoke(int $id,MessageBusInterface $messageBus): Response
    {


        $command = new UpdateCommand($id);
        $messageBus->dispatch($command);
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
}
