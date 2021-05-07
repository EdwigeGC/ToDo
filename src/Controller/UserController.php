<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class UserController provides features to manage users for an admin user
 */
class UserController extends AbstractController
{
    /**
     * The function displays the list of all users
     * @Route("/users", name="user_list")
     * @param UserRepository $repository
     * @return Response
     */
    public function listAction(UserRepository $repository)
    {
        $this->denyAccessUnlessGranted('USER_EDIT',$this->getUser());
        return $this->render('user/list.html.twig', ['users' => $repository->findAll()]);
    }

    /**
     * The function displays the form to create a user
     *
     * @Route("/users/create", name="user_create")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     */
    public function createAction(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager):Response
    {
        $this->denyAccessUnlessGranted('USER_EDIT',$this->getUser());
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * The function displays the form to edit a user
     *
     * @Route("/users/{id}/edit", name="user_edit")
     *
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $manager
     *
     * @return RedirectResponse|Response
     */
    public function editAction(User $user, Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('USER_EDIT', $this->getUser());
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
