<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FrontUserController extends AbstractController
{
    /**
     * @Route("/user/insert", name="insert_user")
     */
    public function insertUser(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        UserPasswordHasherInterface $userPasswordHasherInterface
    ) {
        $user = new User();

        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user->setRoles(["ROLE_USER"]);

            // On récupère le password entré dans le formulaire.
            $plainPassword = $userForm->get('password')->getData();

            // On hashe le password pour le sécuriser.
            $hashedPassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('front/user_form.html.twig', ['userForm' => $userForm->createView()]);
    }
}
