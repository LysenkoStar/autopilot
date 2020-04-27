<?php

namespace App\Controller\Admin;

use App\Entity\Group;
use App\Repository\GroupRepository;
use App\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use VK\Client\VKApiClient;
use Symfony\Component\HttpClient\HttpClient;

class GroupsController extends AbstractController
{
    /** @var $security Security **/
    private $security;
    /** @var $router RouterInterface **/
    private $router;
    /** @var $em EntityManagerInterface **/
    private $em;
    /** @var $session SessionInterface **/
    private $session;


    public function __construct(Security $security, RouterInterface $router, EntityManagerInterface $em, SessionInterface $session)
    {
        $this->security = $security;
        $this->router = $router;
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * @Route("/admin/groups/{page}", name="groups", defaults={"page": 1}, requirements={"page"="\d+"}, methods={"GET"})
     * @param int $page
     * @return Response
     * @throws \Exception
     */
    public function index($page = 1)
    {
        try {
            /** @var $user User **/
            $user = $this->security->getUser();
            /** @var $vkUser \App\Entity\User **/
            $vkUser = $this->em->getRepository(\App\Entity\User::class)->find($user->getVkId());
            /** @var $groupRepo GroupRepository **/
            $groupRepo = $this->em->getRepository(Group::class);
            // count of groups on page
            $groupLimit = 5;

            if (!$vkUser || is_null($vkUser)) throw new \Exception('Попробуйте перезайти в приложение для отображения ваших групп.', 500);

            // для получения access_token группы
            if (isset($_GET['code']) && isset($_GET['state'])) {
                $groupId = $_GET['state'];
                /** @var $client HttpClient **/
                $client = HttpClient::create();
                $data = array(
                    'client_id' => $_ENV['VK_APP_ID'],
                    'client_secret' => $_ENV['VK_APP_SECRET'],
                    'redirect_uri' => $this->router->generate('groups', [], 0),
                    'code' => $_GET['code']
                );
                $response = $client->request('GET', 'https://oauth.vk.com/access_token?' . urldecode(http_build_query($data)));
                $content = $response->toArray();

                $accessToken = $content['access_token_' . $groupId];
                if ($accessToken && !is_null($accessToken)) {
                    /** @var $grp Group **/
                    $grp = $groupRepo->findOneBy(['vk_id' => $groupId, 'user' => $vkUser->getVkId() ]);
                    $grp->setConnected(true);
                    $grp->setAccessToken($accessToken);
                    $this->em->persist($grp);
                    $this->em->flush();

                    $this->addFlash('success', 'Ваша группа успешно подключена!' );
                } else {
                    $this->addFlash('error', 'Что то пошло не так. Попробуйте повторить действие немного позже или обратитесь к администратору' );
                }

                return $this->redirectToRoute('groups');
            }

            $userGroups = $groupRepo->getGroupsByUser($vkUser->getVkId(), $page, $groupLimit);
            /** @var $group Group **/
            foreach ($userGroups as &$group) {
                $group->connect = 'https://oauth.vk.com/authorize?' . urldecode(http_build_query([
                        'client_id' => $_ENV['VK_APP_ID'],
                        'redirect_uri' => $this->router->generate('groups', [], 0),
                        'group_ids' => $group->getVkId(),
                        'display' => 'page',
                        'scope' => 'manage,messages,photos,docs,wall',
                        'response_type' => 'code',
                        'v' => $_ENV['VK_APP_VERSION'],
                        'state' => $group->getVkId(),
                    ]));
            }

            // Pagination
            $maxPages = ceil($userGroups->count() / $groupLimit);
            $thisPage = $page;

            return $this->render('admin/groups/index.html.twig', [
                'groups' => $userGroups,
                'maxPages' => $maxPages,
                'thisPage' => $thisPage,

            ]);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @Route("/admin/groups/{group}/settings", name="group_settings", requirements={"group"="\d+"}, methods={"GET"})
     * @param int $group
     * @return Response
     */
    public function settings(int $group)
    {
        return $this->render('admin/groups/settings.html.twig');
    }

    /**
     * @Route("/admin/groups/update", name="group_update")
     */
    public function updateGroups()
    {
        /** @var $user User **/
        $user = $this->security->getUser();
        /** @var $vkUser \App\Entity\User **/
        $vkUser = $this->em->getRepository(\App\Entity\User::class)->find($user->getVkId());
        /** @var $groupRepo GroupRepository **/
        $groupRepo = $this->em->getRepository(Group::class);

        $vk = new VKApiClient();
        $userGroups = $vk->groups()->get($user->getAccessToken(), array(
            'user_id' => $user->getVkId(),
            'extended' => true,
            'fields' => array('members_count'),
            'filter' => array('admin'),
            'count' => 1000
        ));

        if (!empty($userGroups) && is_array($userGroups)) {
            foreach ($userGroups['items'] as &$group) {
                if ($newGroup = $groupRepo->findOneBy(['user' => $user->getVkId(), 'vk_id' => $group['id'] ])) {
                    $newGroup->setImage($group['photo_50']);
                    $newGroup->setName($group['name']);
                    $newGroup->setClosed($group['is_closed']);
                    $newGroup->setMembersCount($group['members_count']);
                } else {
                    $newGroup = new Group();
                    $newGroup->setUser($vkUser);
                    $newGroup->setImage($group['photo_50']);
                    $newGroup->setVkId($group['id']);
                    $newGroup->setName($group['name']);
                    $newGroup->setType($group['type']);
                    $newGroup->setClosed($group['is_closed']);
                    $newGroup->setMembersCount($group['members_count']);
                }
                $this->em->persist($newGroup);
                $this->em->flush();
            }
        }
        $this->addFlash('success', 'Информация о группах успешно обновлена!' );
        return $this->redirectToRoute('groups');
    }

}
