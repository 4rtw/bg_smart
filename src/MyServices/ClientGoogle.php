<?php

namespace  App\MyServices;

use App\Entity\User;
use App\Repository\UserRepository;
use Google_Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class ClientGoogle extends Google_Client
{
    private $session;
    private $userRepo;
    private $router;

    public function __construct(SessionInterface $session,UserRepository $userRepository, UrlGeneratorInterface $router)
    {
        parent::__construct();
        $this->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $this->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $this->addScope('https://www.googleapis.com/auth/userinfo.profile');
        $this->addScope('email');
        $this->setIncludeGrantedScopes(true);
        $this->setRedirectUri('https://127.0.0.1:8000/login');
        $this->setAccessType('offline');
        $this->session=$session;
        $this->userRepo=$userRepository;
        $this->router=$router;
    }

    public function setTokenInSession($code){
            $access_token=$this->fetchAccessTokenWithAuthCode($code);
            $this->session->set('token', $access_token);
//            $this->setAccessToken($access_token);
    }

    public function getUserIdentification()
    {
        $token=$this->session->get('token');
        if (isset($token))
        {
            try {
                $json_response = $this->getHttpClient()->request(
                    'GET',
                    urldecode("https://openidconnect.googleapis.com/v1/userinfo"), [
                        'headers' => ['Authorization' => 'Bearer ' . $token['access_token']]
                ]);
            } catch (GuzzleException $e) {

            }
            $response=json_decode($json_response->getBody());
            if($response->email_verified)
            return  $response;
        }
    }

    public function getName(){
        return $this->getUserIdentification()->family_name ." ". $this->getUserIdentification()->given_name;
    }

    public function getClientEmail(){
        return $this->getUserIdentification()->email;
    }

    public function unsetSession(){
        $this->session->set('token',null);
    }

    public function saveUser()
    {
        $userIdentified=$this->getUserIdentification();
        if($this->isUserExistInDatabase())
        {
            return  new \Exception("User already exist in database");
        }
        $user=new User();
        $user->setFirstName($userIdentified->family_name);
        $user->setLastName($userIdentified->given_name);
        $user->setEmail($userIdentified->email);
        $user->setPassword('0000');
        $user->setRoles(['ROLE_USER']);
        $this->userRepo->add($user,true);
        return null;
    }

    public function isUserExistInDatabase(){
        $userIdentified=$this->getUserIdentification();
        $userEmail=$userIdentified->email;
        $user=$this->userRepo->findOneBy(['email'=>$userEmail]);
        if(isset($user)){
            return true;
        }
        return false;
    }

}