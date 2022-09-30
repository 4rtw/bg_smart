<?php

namespace App\Controller;

use App\MyServices\ClientGoogle;
use App\Repository\UserRepository;
use Google_Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class LoginController extends AbstractController
{
    private $client;
    private $userRepository;

    public function __construct(ClientGoogle $client, UserRepository $userRepository)
    {
        $this->client=$client;
        $this->userRepository=$userRepository;
    }

    /**
     * @Route("/login", name="app_login")
     * @param Request $request
     * @return Response
     */
    public function login(Request $request, UserRepository $repository, SessionInterface $session): Response
    {
//        $code=$request->query->get('code');
//        if(isset($code)){
//            //The user have the consent of Google for Login or for signUp
//            //------
//            //for Login with google Account
//            if($session->has("token")){
//                if ($this->client->isAccessTokenExpired())
//                {
//                    $this->client->setTokenInSession($code); //if token is expired this is a refresh token from authorization code
//                }
//                if ($this->client->isUserExistInDatabase()){
//                    return $this->redirectToRoute('app_account_exist');
//                }else{
//                    $this->client->saveUser()
//                }
//            }
//
//            //-----
//            //for Sign up with google Account
//        }else{
//
//        }



        $userId=$this->client->getUserIdentification();

        $user=$this->getUser();
        if(!isset($user)&&!isset($userId)){ //if there is no user connected and no redirection from google
            $this->client->setPrompt('select_account');
            $auth_url = $this->client->createAuthUrl();
            return $this->render('login/index.html.twig', [
                'redirect_link' => $auth_url
            ]);
        }else{
            if (isset($userId)) //sign up with google account
            {
                $this->client->saveUser();
                $this->addFlash('success', 'Welcome in Bgsmart !! ');
                $this->client->unsetSession();
                return $this->redirectToRoute('app_home');
            }
            return $this->redirectToRoute('app_home');
        }
    }

    /**
     * @Route("/login/errcredentials", name="login_failed")
     */
    public function errorCredentials()
    {
        $this->client->unsetSession();
        $this->addFlash('warning', 'You haven\'t account here!! Create one!!');
        return $this->redirectToRoute('app_sign_up');
    }

    /**
     * @Route("/logout", name="app_logout_g")
     */
    public function logout():Response
    {
        $this->client->unsetSession();
        return $this->redirectToRoute('app_home');
    }
}
