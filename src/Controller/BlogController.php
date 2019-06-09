<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 12/05/19
 * Time: 18:13
 */

namespace App\Controller;

use App\Entity\Category;
use App\Form\ArticleSearchType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;

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

    public function index(Request $request): Response
    {
        $form = $this->createForm(ArticleSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $form->getData();
        }

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        /*return $this->render('Blog/index.html.twig', [
                'articles' => $articles,
            ]
        ); */

       /*$category = new Category();
        $formCategory = $this->createForm(CategoryType::class, $category); */

        $formSearch = $this->createForm(
            ArticleSearchType::class,
            null,
            ['method' => Request::METHOD_GET]
        );

        return $this->render(
            'Blog/index.html.twig', [
                'articles' => $articles,
                'form' => $formSearch->createView(),
                //'formCategory' => $formCategory->createView(),
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

    public function show(?string $slug): Response
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
                'No article with' . $slug . 'title, found in article\'s table.'
            );
        }

        return $this->render('Blog/show.html.twig', [
                'article' => $article,
                'slug' => $slug
            ]
        );
    }

    /**
     *
     * @Route("/category/{name}" , name = "show_category")
     *
     * @return Response A response instance
     */

    public function showByCategory(Category $category): Response
    {

        /* $category = $this->getDoctrine()
             ->getRepository(Category::class)
             ->findOneBy(['name' => $categoryName]); */


        /*$articles= $this->getDoctrine()
         ->getRepository(Article::class)
          ->findBy(['category' => $category, ['id' => 'DESC'], 3]);
*/


        $articles = $category->getArticles();

        return $this->render(
            'Blog/category.html.twig',
            [
                'category' => $category,
                'articles' => $articles
            ]
        );
    }

}