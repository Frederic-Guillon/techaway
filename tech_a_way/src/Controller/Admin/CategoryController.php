<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryReductType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/category", name="admin_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }


     /**
     * @Route("/create/mainCategory", name="create_main")
     */
    public function createMainCategory(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryReductType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La catégorie principale ' . $category->getName() . ' a bien été ajoutée');

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/create.main.html.twig', [
            'form' => $form->createView()
        ]);
    }

        /**
     * @Route("/create/subCategory", name="create_sub")
     */
    public function createSubCategory(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La sous-catégorie ' . $category->getName() . ' a bien été ajoutée');

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/create.sub.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
