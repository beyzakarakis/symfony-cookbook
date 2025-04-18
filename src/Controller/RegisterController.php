<?php

namespace App\Controller;

use App\Entity\LogIn;
use App\Form\RegisterType;
use App\Repository\LogInRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $logIn = new LogIn();
        $form = $this->createForm(RegisterType::class, $logIn);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $randomUsername = strtolower($logIn->getName()) . rand(100, 999);
            $logIn->setUsername($randomUsername);

            $entityManager->persist($logIn);
            $entityManager->flush();

            $this->addFlash('success', 'Kaydınız tamamlanmıştır! Kullanıcı adınız: ' . $randomUsername);

            return $this->redirectToRoute('app_register');
        }

        return $this->render('newCookBook/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
