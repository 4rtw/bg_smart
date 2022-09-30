<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @package App\Controller
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/latest", name="app_latest_blog")
     */
    public function latest(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/detail", name="app_detail_blog")
     * @param PostRepository $postRepo
     * @return Response
     */
    public function details(PostRepository $postRepo): Response
    {
        $post = $postRepo->findOneBy(['id'=>36]);
        return $this->render('blog/detail.html.twig', [
            'post' => $post,
        ]);
    }
}
