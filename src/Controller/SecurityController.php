<?php

namespace App\Controller;

use App\Entity\User;
use App\Events\UserRegisteredEvent;
use App\Form\Model\UserRegistrationFormModel;
use App\Form\UserRegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        UserAuthenticatorInterface $authenticator,
        LoginFormAuthenticator $formAuthenticator,
        EventDispatcherInterface $eventDispatcher
    ) {
        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $DTO = $form->getData();
            if (!$DTO instanceof UserRegistrationFormModel) {
                throw new LogicException();
            }

            $user = new User();
            $user->setEmail($DTO->email);
            $user->setFirstName($DTO->firstName);

            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $DTO->plainPassword
                )
            );
            $user->setIsActive(true);

            $em->persist($user);
            $em->flush();

            $eventDispatcher->dispatch(new UserRegisteredEvent($user));

            return $authenticator->authenticateUser(
                $user,
                $formAuthenticator,
                $request
            );
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new LogicException();
    }
}
