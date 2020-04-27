<?php

namespace App\Provider;

use App\Entity\AppSettings;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VkUserProvider
{
    private $vkAppId;
    private $vkAppSecret;
    private $httpClient;
    private $router;
    /** @var $em EntityManager **/
    private $em;

    const API_VERSION = 5.103;
    const AUTH_LINK = 'https://oauth.vk.com/authorize';
    const ACCESS_TOKEN = 'https://oauth.vk.com/access_token';
    const USER_INFO_URI = 'https://api.vk.com/method/users.get';

    /**
     * VkUserProvider constructor.
     * @param $app_id
     * @param $app_secret
     * @param HttpClientInterface $httpClient
     * @param RouterInterface $router
     * @param EntityManagerInterface $em
     */
    public function __construct($app_id, $app_secret, HttpClientInterface $httpClient, RouterInterface $router, EntityManagerInterface $em)
    {
        $this->vkAppId = $app_id;
        $this->vkAppSecret = $app_secret;
        $this->httpClient = $httpClient;
        $this->router = $router;
        $this->em = $em;
    }


    public function loadUserFromVk(string $code)
    {
        $url = sprintf(
            self::ACCESS_TOKEN . '?client_id=%s&client_secret=%s&redirect_uri=%s&code=%s',
            $this->vkAppId,
            $this->vkAppSecret,
            $this->router->generate('admin', [], 0),
            $code
        );

        $tokenRequest = $this->httpClient->request('POST', $url, [
            'headers' => [
                'Accept' => "application/json"
            ]
        ]);

        $token = $tokenRequest->toArray();

        $userRequest = $this->httpClient->request('GET', self::USER_INFO_URI, [
            'query' => [
                'user_ids' => $token['user_id'],
                'fields' => 'photo_50,city,verified,bdate,country,has_photo,has_mobile,photo_max,sex',
                'name_case' => 'nom',
                'access_token' => $token['access_token'],
                'v' => self::API_VERSION
            ],
        ]);

        $userData = ($userRequest->toArray())['response'][0];
        /** @var $vkUser User **/
        $vkUser = $this->em->getRepository(User::class)
                                ->findOneBy(['vk_id' => $userData['id']]);

        if (!is_null($vkUser) && $vkUser) {
            $vkUser->setAccessToken($token['access_token']);
        } else {
            $vkUser = new User($userData['id']);
            $vkUser->setName($userData['first_name']);
            $vkUser->setSurname($userData['last_name']);
            $vkUser->setIsClosed($userData['is_closed']);
            $vkUser->setCanAccessClosed($userData['can_access_closed']);
            $vkUser->setSex($userData['sex']);
            $vkUser->setBdate($userData['bdate']);
            $vkUser->setCityId($userData['city']['id']);
            $vkUser->setCity($userData['city']['title']);
            $vkUser->setCountryId($userData['country']['id']);
            $vkUser->setCountry($userData['country']['title']);
            $vkUser->setPhotoMin($userData['photo_50']);
            $vkUser->setPhotoMax($userData['photo_max']);
            $vkUser->setHasPhoto($userData['has_photo']);
            $vkUser->setHasMobile($userData['has_mobile']);
            $vkUser->setVerified($userData['verified']);
            $vkUser->setAccessToken($token['access_token']);
        }
        $this->em->persist($vkUser);
        $this->em->flush();

        return $vkUser;
    }

    /**
     * @return string
     */
    public function getAuthorizationLink()
    {
        $params = array(
            'client_id'     => $this->vkAppId,
            'redirect_uri'  => $this->router->generate('admin', [], 0),
        );

        return self::AUTH_LINK . '?' . urldecode(http_build_query($params));
    }
}