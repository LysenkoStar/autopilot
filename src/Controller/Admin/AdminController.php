<?php

namespace App\Controller\Admin;

use App\Security\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    /** @var $security Security **/
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        /** @var $user User **/
        $user = $this->security->getUser();

        return $this->render('admin/main/index.html.twig', [
            'user' => $user,
        ]);
    }
}
