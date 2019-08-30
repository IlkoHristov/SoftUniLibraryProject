<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Role;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\UserType;
use SoftUniBlogBundle\Service\Users\UserService;
use SoftUniBlogBundle\Service\Users\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("register",name="user_register")
     * @param Request $request
     * @return Response
     */

    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $passwordHash = $this->get("security.password_encoder")
                ->encodePassword($user, $user->getPassword());

            $roleUser = $this->getDoctrine()->getRepository(Role::class)
                ->findOneBy(['name' => 'ROLE_USER']);
            $user->addRole($roleUser);
            $user->setPassword($passwordHash);
            $user->setImage('');
            if(null!==$this->userService->findOneByEmail($form['email']->getData())){
                $this->addFlash("errors", "Email already taken!");
                return $this->render("users/register.html.twig",
                    [
                        'form'=>$this->createForm(UserType::class)->createView()
                    ]);
            }

            if($form['password']['first']->getData()!==$form['password']['second']->getData()){
                $this->addFlash("errors", "Password mismatch!");
                return $this->render("users/register.html.twig",
                    [
                        'user'=>$user,
                        'form'=>$this->createForm(UserType::class)->createView()
                    ]);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('users/register.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/profile",name="user_profile")
     */

    public function profile()
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $currentUser = $userRepository->find($this->getUser());

        return $this->render("users/profile.html.twig", ['user' => $currentUser]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */

    public function logout()
    {
        throw new \Exception("Login failed");
    }

    /**
     * @Route("/profile/edit", name="user_edit_profile",methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function edit()
    {
        $userRepository=$this->getDoctrine()->getRepository(User::class);
        $currentUser=$userRepository->find($this->getUser());

        return $this->render("users/edit.html.twig",
            [
                'user'=>$currentUser,
                'form'=>$this->createForm(UserType::class)
                ->createView()
            ]

            );
    }

    /**
     * @Route("/profile/edit", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function editProcess(Request $request)
    {
        $userRepository=$this->getDoctrine()->getRepository(User::class);
        $currentUser=$userRepository->find($this->getUser());
        $form = $this->createForm(UserType::class, $currentUser);
        /**
         *@var User $currentUser
         */
        if($currentUser->getEmail() === $request->request->get('email')){
            $form->remove('email');
        }
        $form->remove('password');
        $form->handleRequest($request);
        $this->uploadFile($form, $currentUser);
        $this->userService->update($currentUser);




        return $this->redirectToRoute("user_profile");
    }

    /**
     * @param FormInterface $form
     * @param User $user
     */
    public function uploadFile(FormInterface $form, User $user)
    {
        /**
         * @var UploadedFile $file
         */
        $file = $form['image']->getData();

        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        if ($file) {
            $file->move(
                $this->getParameter('users_directory'),
                $fileName
            );

            $user->setImage($fileName);
        }
    }
}
