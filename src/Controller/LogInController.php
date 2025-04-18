<?php

namespace App\Controller;

use App\Entity\LogIn;
use App\Form\LogInType;
use App\Repository\LogInRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class LogInController extends AbstractController
{

    #[Route('/log/in', name: 'app_log_in')]
    public function login(Request $request, LogInRepository $logInRepository): Response
    {
        $logIn = new LogIn();
        $form = $this->createForm(LogInType::class, $logIn);

        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $existingLogIn = $logInRepository->findOneBy([
                'username' => $logIn->getUsername(),
                'password' => $logIn->getPassword()
            ]);

            if ($existingLogIn) {
                return $this->redirectToRoute('app_create_new_cook_book');
            } else {
                $this->addFlash('error', 'Geçersiz kullanıcı adı veya şifre.');
                return $this->redirectToRoute('app_log_in');
            }
        }

        return $this->render('newCookBook/login2.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
