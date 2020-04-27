<?php

namespace App\Controller\Admin;

use App\Entity\AppSettings;
use App\Form\AppSettingsType;
use App\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class SettingsController extends AbstractController
{

    /** @var $security Security **/
    private $security;
    /** @var $em EntityManagerInterface **/
    private $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    /**
     * @Route("/admin/settings", name="settings")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        /** @var $user User **/
        $user = $this->security->getUser();
        /** @var $appUser \App\Entity\User **/
        $appUser = $this->em->getRepository(\App\Entity\User::class)->find($user->getVkId());

        /** @var $appSettings AppSettings **/
        (is_null($appUser->getAppSettings())) ? $appSettings = new AppSettings() : $appSettings = $appUser->getAppSettings();

        $form = $this->createForm(AppSettingsType::class, $appSettings);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $appSettings = $form->getData();
            $this->em->persist($appSettings);
            $appUser->setAppSettings($appSettings);
            $this->em->persist($appUser);
            $this->em->flush();

            $this->addFlash('success', 'Настройки приложения успешно сохранены!' );
            return $this->redirectToRoute('settings');
        }

        return $this->render('admin/settings/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
