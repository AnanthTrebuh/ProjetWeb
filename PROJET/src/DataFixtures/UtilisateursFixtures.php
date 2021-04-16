<?php

namespace App\DataFixtures;

use App\Entity\Utilisateurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateursFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $admin  = new Utilisateurs();
        $admin->setIdentifiant("admin")
            ->setMotdepasse(sha1("nimda"))
            ->setIsadmin(true);
        $manager->persist($admin);

        $admin2  = new Utilisateurs();
        $admin2->setIdentifiant("admin2")
            ->setMotdepasse(sha1("nimda"))
            ->setIsadmin(true);
        $manager->persist($admin2);

        $gilles = new Utilisateurs();
        $gilles->setIdentifiant('gilles')
            ->setMotdepasse(sha1("sellig"))
            ->setNom('Subrenat')
            ->setPrenom('Gilles')
            ->setAnniversaire(new \DateTime('2000-01-01'))
            ->setIsadmin(false);
        $manager->persist($gilles);

        $rita = new Utilisateurs();
        $rita->setIdentifiant('rita')
            ->setMotdepasse(sha1("atir"))
            ->setNom('Zrour')
            ->setPrenom('Rita')
            ->setAnniversaire(new \DateTime('2001-01-02'))
            ->setIsadmin(false);
        $manager->persist($rita);

        $manager->flush();
    }
}
