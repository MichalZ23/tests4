<?php
declare(strict_types=1);


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $currentUserName = $this->getUser()->getUsername();

        return $this->render('admin/index.html.twig', [
            'users' => $users,
            'currentUserName' => $currentUserName
        ]);
    }

    /**
     * @Route("admin/user/delete/{id}", name="app_admin_user_delete")
     * @ParamConverter("id", class="App\Entity\User", options={"id" = "id"})
     */
    public function deleteUser(User $user, UserRepository $userRepository): RedirectResponse
    {
        $userRepository->remove($user, true);
        return new RedirectResponse($this->generateUrl('app_admin'));
    }
}
