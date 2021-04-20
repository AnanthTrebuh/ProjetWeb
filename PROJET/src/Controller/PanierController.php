<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Paniers;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends AbstractController
{
    /**
     * @route(
     *     "panier/list_Produit",
     *     name="panier_list_produit"
     * )
     */
    public function listProduitAction(){
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur || $utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }
        $panierRepository = $em->getRepository('App:Panier');
        $paniers = $panierRepository->findBy(array('idU'=> $utilisateur->getId()));

        $args = array(
            'paniers' => $paniers
        );
        return $this->render('panier/affiche.html.twig', $args);

    }


    /*
    public function ajoutPanierAction(Request $request)
    {
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur || $utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }

            $all = $request->request->all();

            dump($all);

           for ($i = 0 ; $i < count($all); $i++)
            {
                $qtt = $request->request->get($i);
                $idP = $request->request->get(-$i);
                $produitRep =$em->getRepository('App:TreeTrunk');
                $produit = $produitRep->find($idP);

                $panier = new Panier();
                $panier->setQuantite($qtt)
                        ->setIdP($produit)
                        ->setIdU($utilisateur);


                //$produit->setQuantite($produit->getQuantite() - $qtt);
                $em->persist($panier);
                //$em->persist($produit);
            }
            $em->flush();
        return $this->render('panier/ajout_panier.html.twig');
    }//pas correct à corriger !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*/
    /**
     * @route(
     *     "panier/ajout",
     *     name="ajout_panier"
     *     )
     */
    public function ajoutPanierAction(Request $request){
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur || $utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }
        $all = $request->request->all();
        for ($i = 0 ; $i < count($all); $i++)
        {
            $qtt = $request->request->get($i);
            $idP = $request->request->get(-$i);
            $produitRep =$em->getRepository('App:TreeTrunk');
            $produit = $produitRep->find($idP);

            $panier = new Paniers();
            $panier->setQuantite($qtt)
                ->setIdP($idP)
                ->setIdU($utilisateur->getId());

            dump($qtt);
            $produit2 = $produit;
            /*$produit2->setQuantite($produit->getQuantite() -  $qtt);
            $em->persist($panier);
            $em->persist($produit);
            */
        }
        $em->flush();
        return $this->redirectToRoute('treeTrunk_list');
        //return $this->render('panier/ajout_panier.html.twig');
    }


}
