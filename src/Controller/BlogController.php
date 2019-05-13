<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 12/05/19
 * Time: 18:13
 */

namespace App\Controller;

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
}