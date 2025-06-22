<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;

final class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog_index')]
    public function index(BlogPostRepository $repo): Response
    {
        $posts = $repo->findBy([], ['createdAt' => 'DESC']);
        return $this->render('blog/index.html.twig', ['posts' => $posts]);
    }

    #[Route('/blog/{id}', name: 'blog_show')]
    public function show(BlogPost $post): Response
    {
        return $this->render('blog/show.html.twig', ['post' => $post]);
    }
}
