<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 06/06/19
 * Time: 17:06
 */

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route ("/", name = "add_category")
     * @return Response A response instance
     * @IsGranted("ROLE_ADMIN")
     */

    public function addCategory(Request $request): Response
    {

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            return $this->redirectToRoute('add_category');

        }

        return $this->render(
            'Blog/add.html.twig' , [
                'form' => $form->createView()
            ]
        );
    }
}