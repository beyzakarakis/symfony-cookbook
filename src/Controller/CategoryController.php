<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/category', name: 'api_category_')]
class CategoryController extends AbstractController
{
    private $categoryRepository;
    private $entityManager;

    public function __construct(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'] ?? null;

        if (empty($name)) {
            return new JsonResponse(['status' => 'Kategori adı zorunludur.'], Response::HTTP_BAD_REQUEST);
        }

        $category = new Category();
        $category->setName($name);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Kategori başarıyla eklendi.', 'id' => $category->getId()], Response::HTTP_CREATED);
    }
}
