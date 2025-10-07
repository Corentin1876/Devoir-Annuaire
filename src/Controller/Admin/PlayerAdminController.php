<?php

namespace App\Controller\Admin;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/player')]
class PlayerAdminController extends AbstractController
{
    #[Route('/', name: 'admin_player_index')]
    public function index(PlayerRepository $playerRepository): Response
    {
        return $this->render('admin/player/index.html.twig', [
            'players' => $playerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_player_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('admin_player_index');
        }

        return $this->render('admin/player/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_player_edit')]
    public function edit(Request $request, Player $player, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_player_index');
        }

        return $this->render('admin/player/edit.html.twig', [
            'form' => $form,
            'player' => $player,
        ]);
    }

    #[Route('/{id}', name: 'admin_player_delete', methods: ['POST'])]
    public function delete(Request $request, Player $player, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$player->getId(), $request->request->get('_token'))) {
            $em->remove($player);
            $em->flush();
        }

        return $this->redirectToRoute('admin_player_index');
    }
}
