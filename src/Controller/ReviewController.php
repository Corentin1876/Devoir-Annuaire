<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReviewController extends AbstractController
{
    #[Route('/player/{id}/review', name: 'review_new')]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, Player $player, EntityManagerInterface $em, ReviewRepository $reviewRepository): Response
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur a déjà laissé un avis pour ce joueur
        $existingReview = $reviewRepository->findOneBy([
            'user' => $user,
            'player' => $player
        ]);

        if ($existingReview) {
            $this->addFlash('error', 'Vous avez déjà laissé un avis pour ce joueur.');
            return $this->redirectToRoute('player_show', ['id' => $player->getId()]);
        }

        $review = new Review();
        $review->setPlayer($player);
        $review->setUser($user);
        $review->setDateCreation(new \DateTime());

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($review);
            $em->flush();

            $this->addFlash('success', 'Votre avis a été ajouté avec succès.');
            return $this->redirectToRoute('player_show', ['id' => $player->getId()]);
        }

        return $this->render('review/new.html.twig', [
            'form' => $form,
            'player' => $player,
        ]);
    }

    #[Route('/my-reviews', name: 'review_my_reviews')]
    #[IsGranted('ROLE_USER')]
    public function myReviews(ReviewRepository $reviewRepository): Response
    {
        $user = $this->getUser();
        $reviews = $reviewRepository->findBy(['user' => $user]);

        return $this->render('review/my_reviews.html.twig', [
            'reviews' => $reviews,
        ]);
    }
}
