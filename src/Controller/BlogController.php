<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 12/05/19
 * Time: 18:13
 */

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;

/**
 * Class BlogController
 * @package App\Controller
 * @Route("/blog")
 */

class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */

    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render('Blog/index.html.twig', [
                'articles' => $articles,
            ]
        );
    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     *
     * @return Response A response instance
     */

    public function show(?string $slug) : Response
    {

        if (!$slug) {
            throw $this
            ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with'.$slug.'title, found in article\'s table.'
            );
        }

        return $this->render('Blog/show.html.twig', [
            'article' => $article,
            'slug' => $slug
            ]
        );
    }

    /**
     * @param string $categoryName
     *
     * @Route("/category/{categoryName}" , name = "show_category")
     *
     * @return Response A response instance
     */

    public function showByCategory(string $categoryName = 'Javascript'): Response
    {
        $data = [];
        $data['category'] = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => mb_strtolower($categoryName)]);


        $data['articles'] = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['category' => $data['category']], ['id' => 'DESC'], 3);


        return $this->render(
            'Blog/category.html.twig',
            $data
        );
    }


}