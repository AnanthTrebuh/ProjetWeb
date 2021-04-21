<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneralController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function AccueilAction() : Response
    {
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        return $this->render('Layouts/accueil.html.twig', ['user'=>$utilisateur]);
    }



    public function menuAction() : Response{
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));

        $produitRep = $em->getRepository('App:TreeTrunk');
        $produits = $produitRep->findAll();

        $args =array(
            'user' => $utilisateur,
            'produits' => $produits
        );

        return $this->render('Layouts/menu.html.twig', $args);
    }

    public function bandeauAction() : Response{
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));


        $args =array(
            'user' => $utilisateur
        );

        return $this->render('Layouts/bandeau.html.twig', $args);
    }
}
/*
 * Nathan Hubert
 * Valentin Lescorbie
 */