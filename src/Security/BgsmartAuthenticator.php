<?php

namespace App\Security;

use App\MyServices\ClientGoogle;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;


class BgsmartAuthenticator extends AbstractAuthenticator
{
    private $clientGoogle;
    private $userRepository;
    private $router;

    public function __construct(ClientGoogle $clientGoogle,UserRepository $userRepository, UrlGeneratorInterface $router)
    {
        $this->clientGoogle=$clientGoogle;
        $this->userRepository=$userRepository;
        $this->router=$router;
    }

    public function supports(Request $request): ?bool
    {
        return $request->query->has('code');
    }

    public function authenticate(Request $request): Passport
    {
        $code =$request->query->get('code');
        $this->clientGoogle->setTokenInSession($code);
        $userEmail=$this->clientGoogle->getClientEmail();
        return new SelfValidatingPassport(
            new UserBadge($userEmail,function (string $userEmail){
                return $this->userRepository->findOneBy(['email'=>$userEmail]);
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse(
            $this->router->generate('app_home')
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new RedirectResponse(
            $this->router->generate('login_failed')
        );
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
