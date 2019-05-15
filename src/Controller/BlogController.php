<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 12/05/19
 * Time: 18:13
 */

namespace App\Controller;

use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
    * @Route("/blog", name="blog_index")
    */

    public function index()
    {

        return $this->render('Blog/index.html.twig', [
                'owner' => 'Charlene',
            ]
        );
    }

    /**
     * @Route("/blog/show/{article}", name="blog_show", methods={"GET"}, requirements={"article"="[a-z0-9-]+"})
     */
    public function show(string $article = 'Article Sans Titre')
    {
        $article= str_replace('-', ' ', $article);
        $article = ucwords($article);
        return $this->render('Blog/show.html.twig', [
            'title' => $article,
            ]
        );
    }
}