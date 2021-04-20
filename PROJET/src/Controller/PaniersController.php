<?php

namespace App\Controller;

use App\Entity\Paniers;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PaniersController extends AbstractController
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
        $panierRepository = $em->getRepository('App:Paniers');
        $paniers = $panierRepository->findBy(array('idU'=> $utilisateur->getId()));
        $produitRep = $em->getRepository('App:TreeTrunk');
        $produits = $produitRep->findAll();

        $args = array(
            'paniers' => $paniers,
            'produits' => $produits
        );
        return $this->render('paniers/affiche.html.twig', $args);

    }

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

        $produitRep =$em->getRepository('App:TreeTrunk');
        $paniersRep =$em->getRepository('App:Paniers');

        for ($i = 1 ; $i < (count($all)+1)/2; $i++)
        {
            $qtt = $request->request->get($i);

            if((int)$qtt > 0) {
                $idP = $request->request->get(-$i);
                $produit = $produitRep->find((int)$idP);
                $ok = false;
                $paniers = $paniersRep->findAll();
                for ($j = 0; $j < count($paniers); $j++) {
                        $panier = $paniers[$j];
                        if($panier->getIdU() == $utilisateur->getId() && $panier->getIdP() == $produit->getId()) {
                            $panier->setQuantite($panier->getQuantite() + (int)$qtt);
                            $ok = true;
                        }
                }
                if (!$ok) {
                    $panier = new Paniers();
                    $panier->setQuantite((int)$qtt)
                        ->setIdP($produit->getId())
                        ->setIdU($utilisateur->getId());
                }
                $produit->setQuantite($produit->getQuantite() - (int)$qtt);
                $em->persist($panier);
                $em->persist($produit);
            }
        }
        $em->flush();
        return $this->redirectToRoute('treeTrunk_list');
        //return $this->render('paniers/ajout_panier.html.twig');
    }

    /**
     * @route(
     *     "panier/suppr/{id}",
     *     name="panier_suppr_items"
     *     )
     */
    public function panierSupprItemAction(){

    }

}
