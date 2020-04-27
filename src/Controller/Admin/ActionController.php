<?php

namespace App\Controller\Admin;

use App\Entity\Group;
use App\Repository\GroupRepository;
use App\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ActionController extends AbstractController
{
    /** @var $security Security **/
    private $security;
    /** @var $em EntityManagerInterface **/
    private $em;
    /** @var $session SessionInterface **/
    private $session;

    public function __construct(Security $security, EntityManagerInterface $em, SessionInterface $session)
    {
        $this->security = $security;
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * @Route("/admin/action", name="action")
     */
    public function index()
    {
        /** @var $user User **/
        $user = $this->security->getUser();
        /** @var $groupRepo GroupRepository **/
        $groupRepo = $this->em->getRepository(Group::class);
        $enabledGroups = $groupRepo->findBy([
            'user' => $user->getVkId(),
            'connected' => true
        ]);

        return $this->render('admin/action/index.html.twig', [
            'enabledGroups' => $enabledGroups,
        ]);
    }
}
