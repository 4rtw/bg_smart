<?php

namespace App\Controller;

use App\Entity\User;
use App\MyServices\ClientGoogle;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;


/**
 * Class SignUpController
 * @package App\Controller
 *  @Route("/signup")
 */
class SignUpController extends AbstractController
{
    private $client;
    private $userRepository;

    public function __construct(ClientGoogle $client, UserRepository $userRepository)
    {
        $this->client=$client;
        $this->userRepository=$userRepository;
    }


    /**
     * @Route("/", name="app_sign_up")
     * @return Response
     */
    public function signUp()
    {
        $newUser=$this->client->getUserIdentification();
        if (isset($newUser)){ //User failed their sign in
            $this->addFlash('warning','You have no account in Bgsmart, please create new account!!');
        }
        return $this->render('sign-up/index.html.twig');
    }

    /**
     * @Route("/with-bgs", name="app_sign_up_bgs")
     * @param Request $request
     * @param UserPasswordHasherInterface $hasher
     */
    public function signUpWithBgs( Request $request, UserPasswordHasherInterface $hasher, UserRepository $userRepository)
    {

        $user=new User();
        $lastname=$request->request->get('content');
        dd($lastname);
        $user->setLastName($lastname);

        $firstname=$request->request->get('firstName');
        $user->setFirstName($firstname);

        $email= $request->request->get('email');
        $user->setEmail($email);

        $plainPassword=$request->request->get('password');

        $user->setPassword($hasher->hashPassword($user,$plainPassword));
        $userExist=$userRepository->findOneBy(['email'=>$email]);
        if (isset($userExist))
        {
            $this->addFlash('success','You already have an account in bgsmart!!');
        }else{
            $userRepository->add($user,true);
            $this->addFlash('success','Welcome in Bgsmart!!');
        }

        return $this->json([
            'url'=> $this->generateUrl('app_home')
        ]);

    }

    /**
     * @Route("/with-google", name="sign_up_with_google")
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function signUpGoogle( Security $security){
        $user=$security->getUser();
        if (!isset($user))
        {
            $this->client->setPrompt('select_account');
            return $this->redirect($this->client->createAuthUrl());
        }else{
            return $this->redirectToRoute('app_home');
        }

    }

    /**
     * @Route("/account-exist", name="account_exist")
     */
    public function accExist()
    {
        $this->addFlash("warning", "You have an account with Bgsmart!!");
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/account/successfull", name="account_successful")
     */
    public function accCreated()
    {
        $this->addFlash("success", "Welcome in Bgsmart!!");
        return $this->redirectToRoute('app_home');
    }
}
