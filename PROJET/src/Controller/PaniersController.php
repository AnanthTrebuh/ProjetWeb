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
    }

    /**
     * @route(
     *     "panier/suppr/{id}",
     *     name="panier_suppr_items"
     *     )
     */
    public function panierSupprItemAction($id){
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur || $utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }
        $this->supprItemAction($id);

        return $this->redirectToRoute('panier_list_produit');
    }

    /**
     * @route(
     *     "panier/vider",
     *      name="panier_vider"
     * )
     */
    public function panierViderAction()
    {
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur || $utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }
        $panierRep = $em->getRepository('App:Paniers');
        $paniers = $panierRep->findBy(array('idU'=> $utilisateur->getId()));

        for($i = 0; $i < count($paniers); $i ++){
            $panier = $paniers[$i];
            $this->supprItemAction($panier->getId());
        }

        return $this->redirectToRoute('panier_list_produit');

    }
    /**
     * @route(
     *     "panier/user_suppr/{id}",
     *      name="panier_suppr_user_panier"
     * )
     */
    public function AdminPanierViderAction($id)
    {
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }
        $panierRep = $em->getRepository('App:Paniers');
        $paniers = $panierRep->findBy(array('idU'=> $id));

        for($i = 0; $i < count($paniers); $i ++){
            $panier = $paniers[$i];
            $this->supprItemAction($panier->getId());
        }

        return $this->redirectToRoute('utilisateurs_list');

    }
    /**
     * @param $id
     */
    public function supprItemAction($id){
        $em = $this->getDoctrine()->getManager();

        $produitRep = $em->getRepository('App:TreeTrunk');
        $panierRep = $em->getRepository('App:Paniers');

        $panier = $panierRep->find($id);
        $produit = $produitRep->find($panier->getIdP());

        $produit->setQuantite($produit->getQuantite()+$panier->getQuantite());

        $em->remove($panier);
        $em->persist($produit);

        $em->flush();
    }

    /**
     * @route(
     *     "panier/commander",
     *      name="panier_commander"
     *     )
     */
    public function commandeAction(){
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur || $utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }

        $panierRep = $em->getRepository('App:Paniers');
        $paniers = $panierRep->findBy(array('idU'=>$utilisateur->getId()));
        for ($i = 0; $i < count($paniers); $i++){
            $panier = $paniers[$i];
            $em->remove($panier);
        }
        $em->flush();
        return $this->redirectToRoute('panier_list_produit');
    }
}
/*
 * Nathan Hubert
 * Valentin Lescorbie
 */
