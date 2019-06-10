<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 10/06/19
 * Time: 14:38
 */

namespace App\Controller;


use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TagController
 * @package App\Controller
 * @Route ("/tag")
 */

class TagController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */

    public function index(TagRepository $tagRepository)
    {
        return $this->render('Tag/index.html.twig', [
            'tags' => $tagRepository->findAll(),
        ]);
    }

    /**
     * @Route ("/{name}", name="tag_show", methods={"GET"})
     * @return Response A response instance
     */

    public function show(Tag $tag): Response
    {
        return $this->render('Tag/show.html.twig' ,  [
            'tag' => $tag,
        ]);
    }
}