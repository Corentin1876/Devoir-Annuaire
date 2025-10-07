<?php

namespace App\Controller\Admin;

use App\Entity\Level;
use App\Form\LevelType;
use App\Repository\LevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/level')]
class LevelController extends AbstractController
{
    #[Route('/', name: 'admin_level_index')]
    public function index(LevelRepository $levelRepository): Response
    {
        return $this->render('admin/level/index.html.twig', [
            'levels' => $levelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_level_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $level = new Level();
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($level);
            $em->flush();

            return $this->redirectToRoute('admin_level_index');
        }

        return $this->render('admin/level/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_level_edit')]
    public function edit(Request $request, Level $level, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_level_index');
        }

        return $this->render('admin/level/edit.html.twig', [
            'form' => $form,
            'level' => $level,
        ]);
    }

    #[Route('/{id}', name: 'admin_level_delete', methods: ['POST'])]
    public function delete(Request $request, Level $level, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$level->getId(), $request->request->get('_token'))) {
            $em->remove($level);
            $em->flush();
        }

        return $this->redirectToRoute('admin_level_index');
    }
}
