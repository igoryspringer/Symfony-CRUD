<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/article/login", name="article_login")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function SignIn(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/SignIn.html.twig', [
           'last_username' => $lastUsername,
           'error' => $error,
        ]);
    }

    /*
     * @Route("/create_user", name="create_user")
     *
     * @param Request $request
     *
     *@return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
    public function createUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
            $user->setRoles(['ROLE_ADMIN']);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('article_login');
        }

        return $this->render('security/Register.html.twig', ['user' => $user, 'form' => $form->createView()]);
    }*/
}
