<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneralController extends AbstractController
{
    /**
     * @Route("/", name="acceuil")
     */
    public function AcceuilAction() : Response
    {
        return $this->render('acceuil.html.twig');
    }



    public function menuAction() : Response{
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneByidentifiant($user);

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
        $utilisateur = $utilisateurRepository->findOneByidentifiant($user);


        $args =array(
            'user' => $utilisateur
        );

        return $this->render('Layouts/bandeau.html.twig', $args);
    }
}
