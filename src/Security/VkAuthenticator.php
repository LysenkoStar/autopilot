<?php

namespace App\Security;

use App\Provider\VkUserProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class VkAuthenticator extends AbstractGuardAuthenticator
{
    private $provider;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(VkUserProvider $provider, EntityManagerInterface $em)
    {
        $this->provider = $provider;
        $this->em = $em;
    }

    public function supports(Request $request)
    {
//        return $request->query->get('code');
        return $request->attributes->get('_route') === 'admin' && $request->query->get('code');
    }

    public function getCredentials(Request $request)
    {
        return array(
            'code' => $request->query->get('code'),
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // get user frov VK
        /** @var $user \App\Entity\User **/
        $user = $this->provider->loadUserFromVk($credentials['code']);
        return new User($user);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response('Authentication failed', Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse(
            $this->provider->getAuthorizationLink(),
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
