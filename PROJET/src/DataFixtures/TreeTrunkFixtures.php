<?php

namespace App\DataFixtures;

use App\Entity\TreeTrunk;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TreeTrunkFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $arbre1 = new TreeTrunk();
        $arbre1->setName("Bouleau")
                ->setPrix(49.99)
            ->setQuantite(500);
        $arbre2 = new TreeTrunk();
        $arbre2->setName("Cerisier")
            ->setPrix(45.99)
            ->setQuantite(500);
        $arbre3 = new TreeTrunk();
        $arbre3->setName("Noyer")
            ->setPrix(51.99)
            ->setQuantite(500);
        $arbre4 = new TreeTrunk();
        $arbre4->setName("Baobab")
            ->setPrix(69.99)
            ->setQuantite(500);
        $arbre5 = new TreeTrunk();
        $arbre5->setName("Chêne")
            ->setPrix(40.99)
            ->setQuantite(500);
        $arbre6 = new TreeTrunk();
        $arbre6->setName("Hêtre")
            ->setPrix(43.99)
            ->setQuantite(500);
        $arbre7 = new TreeTrunk();
        $arbre7->setName("Ebène")
            ->setPrix(50.)
            ->setQuantite(500);
        $arbre8 = new TreeTrunk();
        $arbre8->setName("Mastier")
            ->setPrix(60.)
            ->setQuantite(500);
        $arbre9 = new TreeTrunk();
        $arbre9->setName("Pin")
            ->setPrix(54.99)
            ->setQuantite(500);

        $manager->persist($arbre1);
        $manager->persist($arbre2);
        $manager->persist($arbre3);
        $manager->persist($arbre4);
        $manager->persist($arbre5);
        $manager->persist($arbre6);
        $manager->persist($arbre7);
        $manager->persist($arbre8);
        $manager->persist($arbre9);

        $manager->flush();
    }
}
/*
 * Nathan Hubert
 * Valentin Lescorbie
 */