<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Level;
use App\Entity\Player;
use App\Entity\User;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Créer 3 catégories sportives (minimum requis)
        $categories = [
            'Football',
            'Handball',
            'Basketball'
        ];

        $categoryObjects = [];
        foreach ($categories as $cat) {
            $category = new Category();
            $category->setNom($cat);
            $manager->persist($category);
            $categoryObjects[] = $category;
        }

        // Créer 4 niveaux (minimum requis)
        $levels = [
            'Ligue 1',
            'Ligue 2',
            'National',
            'Régional'
        ];

        $levelObjects = [];
        foreach ($levels as $lvl) {
            $level = new Level();
            $level->setNom($lvl);
            $manager->persist($level);
            $levelObjects[] = $level;
        }

        // Créer 1 admin et 1 utilisateur normal (minimum requis: 2 utilisateurs)
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setNom('Admin');
        $admin->setPrenom('Super');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $user = new User();
        $user->setEmail('user@example.com');
        $user->setNom('Dupont');
        $user->setPrenom('Alice');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        // Créer 4 joueurs (minimum requis)
        $joueurs = [
            ['Mbappé', 'Kylian', '1998-12-20', 0, 0],
            ['Karabatic', 'Nikola', '1984-04-11', 1, 0],
            ['Gobert', 'Rudy', '1992-06-26', 2, 1],
            ['Griezmann', 'Antoine', '1991-03-21', 0, 1]
        ];

        $playerObjects = [];
        foreach ($joueurs as $joueur) {
            $player = new Player();
            $player->setNom($joueur[0]);
            $player->setPrenom($joueur[1]);
            $player->setDateNaissance(new \DateTime($joueur[2]));
            $player->setCategory($categoryObjects[$joueur[3]]);
            $player->setLevel($levelObjects[$joueur[4]]);
            $manager->persist($player);
            $playerObjects[] = $player;
        }

        // Créer 2 avis (minimum requis)
        $review1 = new Review();
        $review1->setNote(5);
        $review1->setCommentaire('Excellent joueur, très rapide et technique !');
        $review1->setDateCreation(new \DateTime('2025-10-05'));
        $review1->setUser($user);
        $review1->setPlayer($playerObjects[0]); // Avis sur Mbappé
        $manager->persist($review1);

        $review2 = new Review();
        $review2->setNote(4);
        $review2->setCommentaire('Très bon handballeur, un pilier de l\'équipe.');
        $review2->setDateCreation(new \DateTime('2025-10-06'));
        $review2->setUser($user);
        $review2->setPlayer($playerObjects[1]); // Avis sur Karabatic
        $manager->persist($review2);

        $manager->flush();
    }
}
