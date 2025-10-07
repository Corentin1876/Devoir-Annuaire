<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlayerController extends AbstractController
{
    #[Route('/player/{id}', name: 'player_show')]
    public function show(Player $player, ReviewRepository $reviewRepository): Response
    {
        $user = $this->getUser();
        $hasAlreadyReviewed = false;
        
        if ($user) {
            $existingReview = $reviewRepository->findOneBy([
                'user' => $user,
                'player' => $player
            ]);
            $hasAlreadyReviewed = $existingReview !== null;
        }

        return $this->render('player/show.html.twig', [
            'player' => $player,
            'hasAlreadyReviewed' => $hasAlreadyReviewed,
        ]);
    }
}
