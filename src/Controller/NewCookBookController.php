<?php
// src/Controller/NewCookBookController.php

namespace App\Controller;

use App\Entity\NewCookBook;
use App\Form\NewCookBookType;
use App\Repository\NewCookBookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NewCookBookController extends AbstractController
{
    #[Route('/new/cook/book', name: 'app_new_cook_book')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $recipes = $entityManager->getRepository(NewCookBook::class)->findAll();

        return $this->render('newCookBook/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    
    #[Route('/new/cook/book/categories', name: 'app_new_cook_book_categories')]
    public function category(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('newCookBook/category.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/new/cook/book/{id}', name: 'app_new_cook_book_id', requirements: ['id' => '\d+'])]
    public function show(CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        $newCookBooks = $category->getNewCookBooks();

        return $this->render('newCookBook/show.html.twig', [
            'category' => $category, 
            'newCookBooks' => $newCookBooks,
        ]);
    }

    #[Route('/new/cook/book/create', name: 'app_create_new_cook_book')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newCookBook = new NewCookBook();
        $form = $this->createForm(NewCookBookType::class, $newCookBook);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
    
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                // Güvenli dosya adı oluşturma
                $safeFilename = preg_replace('/[^a-zA-Z0-9-_]/', '_', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/images',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }
    
                $newCookBook->setImageFile($newFilename);
                $newCookBook->setImageName($newFilename);
            }

            $entityManager->persist($newCookBook);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_new_cook_book');
        }
    
        return $this->render('newCookBook/create.html.twig', [
            'form' => $form->createView(),
            'newCookBook' => $newCookBook,
        ]);
    }
    


    #[Route('/new/cook/book/add', name: 'newCookBookAdd', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;
        $categoryID = $data['category_id'] ?? null;
        $size = $data['size'] ?? null;

        if (empty($title)) {
            return new JsonResponse(['status' => 'Başlık zorunludur.'], Response::HTTP_BAD_REQUEST);
        }
        if (empty($description)) {
            return new JsonResponse(['status' => 'Açıklama zorunludur.'], Response::HTTP_BAD_REQUEST);
        }
        if (empty($categoryID)) {
            return new JsonResponse(['status' => 'Kategori zorunludur.'], Response::HTTP_BAD_REQUEST);
        }
        if (empty($size)) {
            return new JsonResponse(['status' => 'Porsiyon zorunludur.'], Response::HTTP_BAD_REQUEST);
        }

        $category = $categoryRepository->find($categoryID);
        if (!$category) {
            return new JsonResponse(['status' => 'Geçersiz kategori ID.'], Response::HTTP_BAD_REQUEST);
        }
        
        $newCookBook = new NewCookBook();
        $newCookBook->setTitle($title);
        $newCookBook->setDescription($description);
        $newCookBook->setCategory($category);
        $newCookBook->setSize($size);

        $this->entityManager = $entityManager;


        $this->entityManager->persist($newCookBook);
        $this->entityManager->flush();
        

        return new JsonResponse(['status' => 'Ürün başarıyla eklendi.', 'id' => $newCookBook->getId()], Response::HTTP_CREATED);

    }
}
