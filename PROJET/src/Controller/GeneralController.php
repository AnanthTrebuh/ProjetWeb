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

    /**
     * @route(
     *     name="generale_utilisateur_determine"
     * )
     */
    /*determine si l'utilisateur est un visiteur enregistrer un admin ou un visiteur non enregistrer */
    public function determineAction(){
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneByidentifiant($user);

        /* $args=array(
        *     'user'=>$utilisateur
 ,      * );
        * return $this->render('tree_trunk/test.html.twig', $args);
        */
        /*test si ça fonctionne bien*/
        if($utilisateur = null){
            return 'null';
        }
        else if($utilisateur->getIsadmin())
        {
            return 'admin';
        }
        else
        {
            return 'visiteur';
        }
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
}
