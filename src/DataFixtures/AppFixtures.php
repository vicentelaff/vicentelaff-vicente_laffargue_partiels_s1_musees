<?php

namespace App\DataFixtures;

use App\Entity\Musee;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // Tableau des villes des musées célèbres:
        $villes = ["Paris", "Saint-Pétersbourg", "Pékin", "New York"];

        // On stocke tous les objets créés dans le tableau:
        $tabObjectsVilles = [];
        foreach ($villes as $ville) {
            $v = new Ville;
            $v->setNom($ville);
            $manager->persist($v);
            $tabObjectsVilles[] = $v;
        }

        // Créer un nouveau musée pour alimenter la DB:
        $data = [
            [
                "nom" => "Louvre",
                "photo" => "url(https://cdn2.civitatis.com/francia/paris/entrada-museo-louvre-grid.jpg)",
                "adresse" => "Rue de Rivoli, 75001 Paris",
                "prix" => "17 €",
                "presentation" => "Le Musée du Louvre, situé à Paris, est le musée d'art le plus visité du monde, en plus d'être un monument historique et un musée national de la France. Il s'agit d'un repère central, situé sur la rive droite de la Seine dans le 1er arrondissement."
            ]
        ];

        foreach ($data as $m) {
            $musee = new Musee;
            $musee
                ->setNom($m["nom"])
                ->setPhoto($m["photo"])
                ->setAdresse($m["adresse"])
                ->setPrix($m["prix"])
                ->setPresentation($m["presentation"])
                ->setVille($tabObjectsVilles[0]);

                $manager->persist($musee);

        }

        $manager->flush();
    }
}
