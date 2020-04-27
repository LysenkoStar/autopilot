<?php

namespace App\Controller;

use App\Classes\Handler\ServerHandler;
use App\Entity\Group;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CallbackController extends AbstractController
{
    /** @var $em EntityManagerInterface **/
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/callback/{group}", name="callback", requirements={"group"="\d+"}, methods={"GET"})
     * @param int $group
     * @return void
     */
    public function index(int $group)
    {
        try {
//            /** @var $groupRepo GroupRepository **/
//            $groupRepo = $this->em->getRepository(Group::class);
//            /** @var $group Group **/
//            $grp = $groupRepo->findOneBy([ 'vk_id' => $group ]);
//
//            if (!$grp) throw new Exception('Group with ID '. $group . 'not found!',500);

            $handler = new ServerHandler();
            $data = json_decode(file_get_contents('php://input'));

            $handler->parse($data);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
